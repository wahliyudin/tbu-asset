<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\LifetimeData;
use App\Http\Requests\Masters\LifetimeRequest;
use App\Models\Masters\Lifetime;
use Illuminate\Support\Facades\DB;

class LifetimeService
{
    public function all()
    {
        return Lifetime::query()->get();
    }

    public static function dataForSelect(...$others)
    {
        return Lifetime::select(array_merge(['id', 'masa_pakai'], $others))->get();
    }

    public function updateOrCreate(LifetimeRequest $request)
    {
        $data = LifetimeData::from($request->all());
        return DB::transaction(function () use ($data) {
            return Lifetime::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
        });
    }

    public function delete(Lifetime $lifetime)
    {
        return DB::transaction(function () use ($lifetime) {
            return $lifetime->delete();
        });
    }

    public static function store(array $data)
    {
        if (!$data['masa_pakai']) {
            return null;
        }
        if ($lifetime = Lifetime::query()->where('masa_pakai', $data['masa_pakai'])->first()) {
            return $lifetime;
        }
        return Lifetime::query()->create([
            'masa_pakai' => $data['masa_pakai']
        ]);
    }
}
