<?php

namespace App\Services\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Repositories\Disposes\AssetDisposeRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AssetDisposeService
{
    public function all()
    {
        return AssetDispose::query()->where('nik', auth()->user()?->nik)->get();
    }

    public function updateOrCreate(AssetDisposeRequest $request)
    {
        $data = AssetDisposeData::from(array_merge($request->all(), ['status' => Status::OPEN]))->except('employee');
        DB::transaction(function () use ($data) {
            $assetDispose = (new AssetDisposeRepository)->updateOrCreate($data);
            $assetDispose->workflows()->delete();
            DisposeWorkflowService::setModel($assetDispose)->store();
        });
    }

    public function delete(AssetDispose $assetDispose)
    {
        return DB::transaction(function () use ($assetDispose) {
            $assetDispose->workflows()->delete();
            return $assetDispose->delete();
        });
    }

    public static function getByCurrentApproval()
    {
        return AssetDispose::query()->whereHas('workflows', function (Builder $query) {
            $query->where('last_action', LastAction::NOTTING)
                ->where('nik', auth()->user()?->nik);
        })->get();
    }
}
