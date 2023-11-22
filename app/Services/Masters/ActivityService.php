<?php

namespace App\Services\Masters;

use App\Http\Requests\Masters\ActivityRequest;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Activity;
use App\Repositories\Masters\ActivityRepository;
use Illuminate\Support\Facades\DB;

class ActivityService
{
    public function __construct(
        protected ActivityRepository $activityRepository
    ) {
    }

    public function all()
    {
        return $this->activityRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new ActivityRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(ActivityRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $activity = $this->activityRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($activity, $request->key);
            return $activity;
        });
    }

    public function delete(Activity $activity)
    {
        return DB::transaction(function () use ($activity) {
            Message::deleted(Topic::ACTIVITY, 'id', $activity->getKey(), Nested::ACTIVITY);
            return $this->activityRepository->destroy($activity);
        });
    }

    public static function store(array $data)
    {
        if (!$data['name']) {
            return null;
        }
        if ($activity = (new ActivityRepository)->check($data['name'])) {
            return $activity;
        }
        return Activity::query()->create([
            'name' => $data['name']
        ]);
    }

    private function sendToElasticsearch(Activity $activity, $key)
    {
        if ($key) {
            Message::updated(
                Topic::ACTIVITY,
                'id',
                $activity->getKey(),
                Nested::ACTIVITY,
                $activity->toArray()
            );
        }
    }
}
