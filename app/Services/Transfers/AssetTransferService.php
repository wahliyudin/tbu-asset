<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Elasticsearch\QueryBuilder\Term;
use App\Enums\Transfers\Transfer\Status as TransferStatus;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Facades\BudgetService;
use App\Facades\Elasticsearch;
use App\Helpers\AuthHelper;
use App\Helpers\CarbonHelper;
use App\Helpers\Helper;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Http\Requests\Transfers\ReceivedRequest;
use App\Jobs\Transfers\BudgetMutationJob;
use App\Models\Employee;
use App\Models\Transfers\AssetTransfer;
use App\Models\Transfers\StatusTransfer;
use App\Repositories\Transfers\AssetTransferRepository;
use App\Services\Assets\AssetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AssetTransferService
{
    public function __construct(
        protected AssetTransferRepository $assetTransferRepository,
        protected AssetService $assetService
    ) {
    }

    public function all()
    {
        return AssetTransfer::query()->where('nik', AuthHelper::getNik())->with('asset')->get();
    }

    public function allToAssetTransferData($search = null, $length = 50)
    {
        $data = Elasticsearch::setModel(AssetTransfer::class)->searchMultipleQuery($search, terms: [
            new Term('nik', AuthHelper::getNik())
        ], size: $length)->all();
        return $data;
        // return Arr::pluck($data, '_source');
        // return AssetTransferData::collection(Arr::pluck($data, '_source'))->toCollection();
    }

    public function updateOrCreate(AssetTransferRequest $request, bool $isDraft = false)
    {
        $additional = [
            'status' => Status::OPEN,
            'transfer_date' => CarbonHelper::convertDate($request->transfer_date),
        ];
        if ($isDraft) {
            $additional['status'] = Status::DRAFT;
        }
        $data = AssetTransferData::from(array_merge($request->all(), $additional));
        DB::transaction(function () use ($data, $isDraft) {
            $assetTransfer = $this->assetTransferRepository->updateOrCreate($data);
            if ($data->getKey()) {
                $assetTransfer->workflows()->delete();
            } else {
                $this->storeStatusTransfer($assetTransfer->getKey(), TransferStatus::PENDING);
            }
            if (!$isDraft) {
                TransferWorkflowService::setModel($assetTransfer)
                    ->setAdditionalParams(
                        $this->additionalParams($data),
                    )
                    ->setBarrier($assetTransfer?->asset?->subCluster?->cluster?->category?->name)
                    ->store();
            }
            $this->assetTransferRepository->sendToElasticsearch($assetTransfer, $data->getKey());
        });
    }

    public function storeStatusTransfer($transfer_id, TransferStatus $status)
    {
        return StatusTransfer::query()->create([
            'asset_transfer_id' => $transfer_id,
            'status' => $status,
            'date' => now(),
        ]);
    }

    private function additionalParams(AssetTransferData $assetTransferData)
    {
        $deptId = $assetTransferData?->oldPic?->position?->department?->dept_id;
        if (!$deptId) {
            throw ValidationException::withMessages(['Old PIC belum mempunyai department']);
        }
        $projectId = $assetTransferData?->oldPic?->position?->project?->project_id;
        if (!$projectId) {
            throw ValidationException::withMessages(['Old PIC belum mempunyai project']);
        }
        $newProjectId = $assetTransferData?->newPic?->position?->project?->project_id;
        if (!$newProjectId) {
            throw ValidationException::withMessages(['New PIC belum mempunyai project']);
        }
        return [
            [
                'sequence' => 0,
                'dept_id' => $deptId,
            ],
            [
                'sequence' => 3,
                'project_id' => $projectId,
            ],
        ];
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        return DB::transaction(function () use ($assetTransfer) {
            $assetTransfer->workflows()->delete();
            $this->assetTransferRepository->deleteFromElasticsearch($assetTransfer);
            return $assetTransfer->delete();
        });
    }

    public function received(ReceivedRequest $request, AssetTransfer $assetTransfer)
    {
        return DB::transaction(function () use ($request, $assetTransfer) {
            $fileName = $this->storeFile($request->file('file_bast'), $assetTransfer->no_transaksi, $request->no_bast);
            $assetTransfer->update([
                'tanggal_bast' => $request->tanggal_bast,
                'no_bast' => $request->no_bast,
                'file_bast' => $fileName,
            ]);
            $this->statusTransfer($assetTransfer, TransferStatus::RECEIVED);
            $this->assetService->transfer($assetTransfer->asset, $assetTransfer->new_project, $assetTransfer->new_pic);
            BudgetService::sendTransfer($assetTransfer->no_transaksi, $assetTransfer->asset_id);
            dispatch(new BudgetMutationJob('emails.transfer.finance', $assetTransfer));
            $this->assetTransferRepository->sendToElasticsearch($assetTransfer, $assetTransfer->getKey());
        });
    }

    public function storeFile(?UploadedFile $uploadedFile, $noTransaksi, $noBast)
    {
        if (!$uploadedFile) {
            return null;
        }
        $folder = 'transfers';
        if (count(Storage::disk('public')->allDirectories($folder)) > 0) {
            Storage::disk('public')->makeDirectory($folder);
        }
        $noBast = str($noBast)->snake('-')->value();
        $noTransaksi = str($noTransaksi)->replace('/', '-')->value();
        $fileName = $noTransaksi . '-' . $noBast . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs("public/$folder", $fileName);
        return $folder . '/' . $fileName;
    }

    public function statusTransfer(AssetTransfer $assetTransfer, TransferStatus $status)
    {
        return DB::transaction(function () use ($assetTransfer, $status) {
            $this->storeStatusTransfer($assetTransfer->getKey(), $status);
            $this->assetTransferRepository->sendToElasticsearch($assetTransfer, $assetTransfer->getKey());
            return $assetTransfer;
        });
    }

    public static function getByCurrentApproval()
    {
        $data = AssetTransfer::query()
            ->with('asset')
            ->where('status', Status::OPEN)
            ->whereHas('currentApproval', function ($query) {
                $query->where('nik', AuthHelper::getNik());
            })
            ->get();
        return AssetTransferData::collection($data)->toCollection();
    }

    public function checkAsset(Request $request)
    {
        return $request->get('asset') ? $this->assetService->getByKode($request->get('asset')) : null;
    }

    public function nextNoTransfer($nik)
    {
        $employee = Employee::query()->with(['position' => function ($query) {
            $query->with(['department', 'project']);
        }])->where('nik', $nik)->first();

        return collect([
            $this->nextNumber($employee->position?->project?->project_prefix),
            $employee->position?->department?->dept_code,
            $employee->position?->project?->project_prefix,
            Helper::getRomawi(now()->month),
            now()->year,
        ])->implode('/');
    }

    public function nextNumber($projectPrefix)
    {
        $cer = AssetTransfer::select(['no_transaksi'])
            ->where('no_transaksi', 'like', "%/$projectPrefix/%")
            ->orderBy('no_transaksi', 'DESC')
            ->first();
        $lastKode = null;
        if ($cer) {
            $lastKode = str($cer?->no_transaksi)->explode('/')->first();
        }
        $prefix = 'TFR';
        $length = 7;
        $prefixLength = strlen($prefix);
        $idLength = $length - $prefixLength;
        if (!$lastKode) {
            return $prefix . str_pad(1, $idLength, '0', STR_PAD_LEFT);
        }
        $maxId = substr($lastKode, $prefixLength + 1, $idLength);
        return $prefix . str_pad((int)$maxId + 1, $idLength, '0', STR_PAD_LEFT);
    }
}
