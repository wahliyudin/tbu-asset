<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Http\Requests\Masters\LeasingStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Leasing;
use Illuminate\Support\Facades\DB;

class LeasingService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Leasing::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Leasing::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(LeasingStoreRequest $request)
    {
        $data = LeasingData::from($request->all());
        return DB::transaction(function () use ($data) {
            $leasing = Leasing::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
            $this->sendToElasticsearch($leasing, $data->getKey());
            return $leasing;
        });
    }

    public static function store(LeasingData $data)
    {
        return Leasing::query()->create([
            'name' => $data->name,
        ]);
    }

    public function delete(Leasing $leasing)
    {
        return DB::transaction(function () use ($leasing) {
            Elasticsearch::setModel(Leasing::class)->deleted(LeasingData::from($leasing));
            return $leasing->delete();
        });
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Leasing::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Leasing $cluster, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Leasing::class)->updated(LeasingData::from($cluster));
        }
        return Elasticsearch::setModel(Leasing::class)->created(LeasingData::from($cluster));
    }
}
