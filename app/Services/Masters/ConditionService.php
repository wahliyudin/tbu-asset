<?php

namespace App\Services\Masters;

use App\Http\Requests\Masters\ConditionRequest;
use App\Kafka\Enums\Nested;
use App\Kafka\Enums\Topic;
use App\Kafka\Facades\Message;
use App\Models\Masters\Condition;
use App\Repositories\Masters\ConditionRepository;
use Illuminate\Support\Facades\DB;

class ConditionService
{
    public function __construct(
        protected ConditionRepository $conditionRepository
    ) {
    }

    public function all()
    {
        return $this->conditionRepository->instance();
    }

    public static function dataForSelect(...$others)
    {
        return (new ConditionRepository)->selectByAttributes($others);
    }

    public function updateOrCreate(ConditionRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $condition = $this->conditionRepository->updateOrCreate($request->all());
            $this->sendToElasticsearch($condition, $request->key);
            return $condition;
        });
    }

    public function delete(Condition $condition)
    {
        return DB::transaction(function () use ($condition) {
            Message::deleted(Topic::CONDITION, 'id', $condition->getKey(), Nested::CONDITION);
            return $this->conditionRepository->destroy($condition);
        });
    }

    public static function store(array $data)
    {
        if (!$data['name']) {
            return null;
        }
        if ($condition = (new ConditionRepository)->check($data['name'])) {
            return $condition;
        }
        return Condition::query()->create([
            'name' => $data['name']
        ]);
    }

    private function sendToElasticsearch(Condition $condition, $key)
    {
        if ($key) {
            Message::updated(
                Topic::CONDITION,
                'id',
                $condition->getKey(),
                Nested::CONDITION,
                $condition->toArray()
            );
        }
    }
}
