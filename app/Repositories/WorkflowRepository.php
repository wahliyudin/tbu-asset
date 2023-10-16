<?php

namespace App\Repositories;

use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Status;
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
        return $model->load(['workflow', 'workflows' => function ($query) {
            $query->with('employee')->where('last_action', LastAction::NOTTING)->orderBy('sequence', 'ASC');
        }]);
    }

    public static function store(Model $model, array $data)
    {
        $model->workflows()->createMany($data);
        return $model;
    }

    public static function updateStatusAndNote(Model $model, Status $status, $note = null)
    {
        $model->update([
            'status' => $status,
            'note' => $note
        ]);
        return $model;
    }
}
