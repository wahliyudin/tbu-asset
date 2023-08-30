<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UomData;
use App\Facades\Elasticsearch;
use App\Http\Requests\Masters\UomStoreRequest;
use App\Models\Masters\Uom;

class UomService
{
    public function all($search = null, $length = 50)
    {
        return Elasticsearch::setModel(Uom::class)->searchMultiMatch($search, $length)->all();
    }

    public static function dataForSelect(...$others)
    {
        return Uom::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(UomStoreRequest $request)
    {
        $data = UomData::from($request->all());
        $uom = Uom::query()->updateOrCreate([
            'id' => $data->id
        ], $data->toArray());
        $this->sendToElasticsearch($uom, $data->getKey());
        return $uom;
    }

    public function delete(Uom $uom)
    {
        Elasticsearch::setModel(Uom::class)->deleted(UomData::from($uom));
        return $uom->delete();
    }

    public function getDataForEdit($id): array
    {
        $asset = Elasticsearch::setModel(Uom::class)->find($id)->asArray();
        return $asset['_source'];
    }

    private function sendToElasticsearch(Uom $uom, $key)
    {
        if ($key) {
            return Elasticsearch::setModel(Uom::class)->updated(UomData::from($uom));
        }
        return Elasticsearch::setModel(Uom::class)->created(UomData::from($uom));
    }
}
