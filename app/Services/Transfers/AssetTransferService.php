<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Enums\Transfers\Transfer\Status as TransferStatus;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Helpers\AuthHelper;
use App\Helpers\CarbonHelper;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Transfers\AssetTransfer;
use App\Models\Transfers\StatusTransfer;
use App\Repositories\Transfers\AssetTransferRepository;
use App\Services\Assets\AssetService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        $data = Elasticsearch::setModel(AssetTransfer::class)
            ->searchMultiMatch($search, $length)
            ->all();

        $assetTransferData = AssetTransferData::collection(
            collect($data)->pluck('_source')
        );

        $userNik = AuthHelper::getNik();
        return $assetTransferData->toCollection()->where('nik', $userNik);
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
                        $this->additionalParams($data)
                    )->store();
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
                'sequence' => 2,
                'dept_id' => $deptId,
            ],
            [
                'sequence' => 4,
                'project_id' => $newProjectId,
            ],
            [
                'sequence' => 5,
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
}
