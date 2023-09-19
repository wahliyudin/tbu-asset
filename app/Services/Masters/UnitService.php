<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\UnitData;
use App\Http\Requests\Masters\UnitStoreRequest;
use App\Facades\Elasticsearch;
use App\Jobs\Masters\Unit\BulkJob;
use App\Models\Masters\Unit;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {
            $unit = Unit::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
            $this->sendToElasticsearch($unit, $data->getKey());
            return $unit;
        });
    }


    public static function store(array $data)
    {
        if (!isset($data['kode']) || !isset($data['model'])) {
            return null;
        }
        if ($unit = Unit::query()
            ->where('kode', trim(isset($data['kode']) ? $data['kode'] : null))
            ->orWhere('model', trim(isset($data['model']) ? $data['model'] : null))
            ->first()
        ) {
            return $unit;
        }
        return Unit::query()->create([
            'prefix' => isset($data['prefix']) ? $data['prefix'] : null,
            'model' => isset($data['model']) ? $data['model'] : null,
        ]);
    }

    public function delete(Unit $unit)
    {
        return DB::transaction(function () use ($unit) {
            Elasticsearch::setModel(Unit::class)->deleted(UnitData::from($unit));
            return $unit->delete();
        });
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

    public function getAllDataWithRelations()
    {
        return Unit::query()->get();
    }

    public function bulk(array $clusters = [])
    {
        return Elasticsearch::setModel(Unit::class)
            ->bulk(UnitData::collection($clusters));
    }

    public function instanceBulk(Batch $batch)
    {
        $units = $this->getAllDataWithRelations()->toArray();
        foreach (array_chunk($units, 10) as $units) {
            $batch->add(new BulkJob($units));
        }
        return $batch;
    }
}
