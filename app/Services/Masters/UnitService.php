<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Facades\Elasticsearch;
use App\Models\Masters\Unit;

class UnitService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Unit::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Unit::select(array_merge(['id', 'model'], $others))->get();
    }

    public function updateOrCreate(UnitStoreRequest $request)
    {
        $data = UnitData::from($request->all());
        $unit = Unit::query()->updateOrCreate([
            'id' => $data->key
        ], $data->toArray());
        $this->sendToElasticsearch($unit, $data->getKey());
        return $unit;
    }


    public static function store(UnitData $data)
    {
        if ($unit = Unit::query()
            ->where('kode', 'like', $data->kode)
            ->orWhere('model', 'like', $data->model)
            ->first()
        ) {
            return $unit;
        }
        return Unit::query()->create([
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
