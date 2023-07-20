<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LeasingData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Leasing;

class LeasingService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Leasing::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(LeasingData $data)
    {
        $leasing = Leasing::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'name' => $data->name,
        ]);
        $this->sendToElasticsearch($leasing, $data->getKey());
        return $leasing;
    }

    public static function store(LeasingData $data)
    {
        return Leasing::query()->create([
            'name' => $data->name,
        ]);
    }

    public function delete(Leasing $leasing)
    {
        Elasticsearch::setModel(Leasing::class)->deleted(LeasingData::from($leasing));
        return $leasing->delete();
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
