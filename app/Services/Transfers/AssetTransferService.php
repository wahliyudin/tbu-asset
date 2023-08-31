<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Transfers\AssetTransfer;
use App\Repositories\Transfers\AssetTransferRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssetTransferService
{
    public function __construct(
        protected AssetTransferRepository $assetTransferRepository
    ) {
    }

    public function all()
    {
        return AssetTransfer::query()->where('nik', auth()->user()?->nik)->with('asset')->get();
    }

    public function allToAssetTransferData($search = null, $length = 50)
    {
        $data = Elasticsearch::setModel(AssetTransfer::class)
            ->searchMultiMatch($search, $length)
            ->all();

        $assetTransferData = AssetTransferData::collection(
            collect($data)->pluck('_source')
        );

        $userNik = auth()->user()?->nik;
        return $assetTransferData->toCollection()->where('nik', $userNik);
    }

    public function updateOrCreate(AssetTransferRequest $request)
    {
        $data = AssetTransferData::from(array_merge($request->all(), ['status' => Status::OPEN]));
        DB::transaction(function () use ($data) {
            $assetTransfer = $this->assetTransferRepository->updateOrCreate($data);
            if ($data->getKey()) {
                $assetTransfer->workflows()->delete();
            }
            TransferWorkflowService::setModel($assetTransfer)->store();
            $this->assetTransferRepository->sendToElasticsearch($assetTransfer, $data->getKey());
        });
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        return DB::transaction(function () use ($assetTransfer) {
            $assetTransfer->workflows()->delete();
            $this->assetTransferRepository->deleteFromElasticsearch($assetTransfer);
            return $assetTransfer->delete();
        });
    }

    public static function getByCurrentApproval()
    {
        $data = AssetTransfer::query()->with('asset')
            ->whereHas('workflows', function (Builder $query) {
                $query->where('last_action', LastAction::NOTTING)
                    ->where('nik', auth()->user()?->nik);
            })
            ->get();
        return AssetTransferData::collection($data)->toCollection();
    }
}
