<?php

namespace App\Services\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Repositories\Disposes\AssetDisposeRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AssetDisposeService
{
    public function __construct(
        protected AssetDisposeRepository $assetDisposeRepository
    ) {
    }

    public function all($search = null)
    {
        $data = Elasticsearch::setModel(AssetDispose::class)->searchMultiMatch($search, 50)->all();
        return AssetDisposeData::collection(Arr::pluck($data, '_source'))->toCollection()->where('nik', auth()->user()?->nik);
    }

    public function updateOrCreate(AssetDisposeRequest $request)
    {
        $data = AssetDisposeData::from(array_merge($request->all(), ['status' => Status::OPEN]))->except('employee');
        DB::transaction(function () use ($data) {
            $assetDispose = (new AssetDisposeRepository)->updateOrCreate($data);
            if ($data->getKey()) {
                $assetDispose->workflows()->delete();
            }
            DisposeWorkflowService::setModel($assetDispose)->store();
            $this->assetDisposeRepository->sendToElasticsearch($assetDispose, $data->getKey());
        });
    }

    public function delete(AssetDispose $assetDispose)
    {
        return DB::transaction(function () use ($assetDispose) {
            $assetDispose->workflows()->delete();
            $this->assetDisposeRepository->deleteFromElasticsearch($assetDispose);
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
