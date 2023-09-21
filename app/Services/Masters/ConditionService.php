<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ConditionData;
use App\Http\Requests\Masters\ConditionRequest;
use App\Models\Masters\Condition;
use Illuminate\Support\Facades\DB;

class ConditionService
{
    public function all()
    {
        return Condition::query()->get();
    }

    public static function dataForSelect(...$others)
    {
        return Condition::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(ConditionRequest $request)
    {
        $data = ConditionData::from($request->all());
        return DB::transaction(function () use ($data) {
            return Condition::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
        });
    }

    public function delete(Condition $lifetime)
    {
        return DB::transaction(function () use ($lifetime) {
            return $lifetime->delete();
        });
    }

    public static function store(array $data)
    {
        if (!$data['name']) {
            return null;
        }
        if ($lifetime = Condition::query()->where('name', $data['name'])->first()) {
            return $lifetime;
        }
        return Condition::query()->create([
            'name' => $data['name']
        ]);
    }
}
