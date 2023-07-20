<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Unit;

class UnitService
{
    public function all($search = null)
    {
        return Elasticsearch::setModel(Unit::class)->searchQueryString($search, 50)->all();
    }

    public function updateOrCreate(UnitData $data)
    {
        $unit = Unit::query()->updateOrCreate([
            'id' => $data->getKey()
        ], [
            'kode' => $data->kode,
            'model' => $data->model,
            'type' => $data->type,
            'seri' => $data->seri,
            'class' => $data->class,
            'brand' => $data->brand,
            'serial_number' => $data->serial_number,
            'spesification' => $data->spesification,
            'tahun_pembuatan' => $data->tahun_pembuatan,
        ]);
        $this->sendToElasticsearch($unit, $data->getKey());
        return $unit;
    }

    public function delete(Unit $unit)
    {
        Elasticsearch::setModel(Unit::class)->deleted(UnitData::from($unit));
        return $unit->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Unit::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Unit $unit, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Unit::class)->updated(UnitData::from($unit));
        }
        return Elasticsearch::setModel(Unit::class)->created(UnitData::from($unit));
    }
}
