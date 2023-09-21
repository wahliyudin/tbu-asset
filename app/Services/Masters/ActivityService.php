<?php

namespace App\Services\Masters;

use App\DataTransferObjects\Masters\ActivityData;
use App\Http\Requests\Masters\ActivityRequest;
use App\Models\Masters\Activity;
use Illuminate\Support\Facades\DB;

class ActivityService
{
    public function all()
    {
        return Activity::query()->get();
    }

    public static function dataForSelect(...$others)
    {
        return Activity::select(array_merge(['id', 'name'], $others))->get();
    }

    public function updateOrCreate(ActivityRequest $request)
    {
        $data = ActivityData::from($request->all());
        return DB::transaction(function () use ($data) {
            return Activity::query()->updateOrCreate([
                'id' => $data->key
            ], $data->toArray());
        });
    }

    public function delete(Activity $lifetime)
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
        if ($lifetime = Activity::query()->where('name', $data['name'])->first()) {
            return $lifetime;
        }
        return Activity::query()->create([
            'name' => $data['name']
        ]);
    }
}
