<?php

namespace App\Services\Transfers;

use App\DataTransferObjects\Transfers\AssetTransferData;
use App\Enums\Workflows\LastAction;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Transfers\AssetTransfer;
use App\Repositories\Transfers\AssetTransferRepository;
use Illuminate\Database\Eloquent\Builder;

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

    public function allToAssetTransferData()
    {
        return AssetTransferData::collection($this->all())->toCollection();
    }

    public function updateOrCreate(AssetTransferRequest $request)
    {
        $data = AssetTransferData::from($request->all());
        $assetTransfer = $this->assetTransferRepository->updateOrCreate($data);
        TransferWorkflowService::setModel($assetTransfer)->store();
    }

    public function delete(AssetTransfer $assetTransfer)
    {
        $assetTransfer->workflows()->delete();
        return $assetTransfer->delete();
    }

    public static function getByCurrentApproval()
    {
        $data = AssetTransfer::query()->with('asset')->whereHas('workflows', function (Builder $query) {
            $query->where('last_action', LastAction::NOTTING)
                ->where('nik', auth()->user()?->nik);
        })->get();
        return AssetTransferData::collection($data)->toCollection();
    }
}
