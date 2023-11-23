<?php

namespace App\Services\Disposes;

use App\DataTransferObjects\Disposes\AssetDisposeData;
use App\Enums\Workflows\Status;
use App\Facades\Elasticsearch;
use App\Helpers\AuthHelper;
use App\Http\Requests\Disposes\AssetDisposeRequest;
use App\Models\Disposes\AssetDispose;
use App\Repositories\Disposes\AssetDisposeRepository;
use Illuminate\Http\Request;
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

    public function datatable()
    {
        return AssetDispose::query()->get();
    }

    public function updateOrCreate(AssetDisposeRequest $request, $isDraft = false)
    {
        $additional = ['status' => Status::OPEN];
        if ($isDraft) {
            $additional['status'] = Status::DRAFT;
        }
        $data = AssetDisposeData::from(array_merge($request->all(), $additional))
            ->except('employee');
        DB::transaction(function () use ($data, $isDraft) {
            $assetDispose = (new AssetDisposeRepository)->updateOrCreate($data);
            if ($data->getKey()) {
                $assetDispose->workflows()->delete();
            }
            if (!$isDraft) {
                DisposeWorkflowService::setModel($assetDispose)->store();
            }
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
        return AssetDispose::query()
            ->with('asset')
            ->where('status', Status::OPEN)
            ->whereHas('currentApproval', function ($query) {
                $query->where('nik', AuthHelper::getNik());
            })
            ->get();
    }

    public function dataForExport(Request $request)
    {
        return AssetDispose::query()->get();
    }
}
