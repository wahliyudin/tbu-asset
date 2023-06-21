<?php

namespace App\Repositories;

use App\Enums\Workflows\LastAction;
use Illuminate\Database\Eloquent\Model;

class WorkflowRepository
{
    public static function updateLasAction(Model $workflow, LastAction $lastAction)
    {
        return $workflow->update([
            'last_action' => $lastAction,
            'last_action_date' => now()
        ]);
    }

    public static function loadWorkflows(Model $model)
    {
        return $model->loadMissing(['workflow', 'workflows' => function ($query) {
            $query->where('last_action', LastAction::NOTTING);
        }]);
    }

    public static function store(Model $model, array $data)
    {
        return $model->workflows()->createMany($data);
    }
}