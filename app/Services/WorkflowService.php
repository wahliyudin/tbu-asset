<?php

namespace App\Services;

use App\Enums\Workflows\LastAction;
use App\Interfaces\ModelWithWorkflowInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class WorkflowService
{
    public function __construct(
        protected Model $model,
    ) {
        if (!$model instanceof ModelWithWorkflowInterface) {
            throw new Exception("Model must be implements " . ModelWithWorkflowInterface::class);
        }
        $this->model->load(['workflows' => function ($query) {
            $query->where('last_action', LastAction::NOTTING);
        }]);
    }

    public function store()
    {
        return $this->storeWorkflow();
    }

    public function isAllApprov()
    {
        return $this->model->workflow?->last_action == LastAction::APPROV;
    }

    public function currentWorkflow()
    {
        return $this->model->workflows?->first();
    }

    public function isCurrentWorkflow()
    {
        return $this->currentWorkflow()?->nik == auth()->user()->nik;
    }

    public function isLast()
    {
        return count($this->model->workflows) == 1;
    }

    public function lastAction(LastAction $lastAction)
    {
        $workflow = $this->currentWorkflow();
        if (!$workflow->nik == auth()->user()->nik) {
            throw ValidationException::withMessages(['Anda tidak berhak melakukan aksi ini']);
        }

        if ($this->isLast() && $lastAction == LastAction::APPROV) {
            $this->handleIsLastAndApprov();
        }

        if (!($this->isLast()) && $lastAction == LastAction::APPROV) {
            $this->handleIsNotLastAndApprov();
        }

        if ($lastAction == LastAction::REJECT) {
            $this->handleIsRejected();
        }

        return $workflow->update([
            'last_action' => $lastAction,
            'last_action_date' => now()
        ]);
    }

    protected abstract function storeWorkflow();

    protected abstract function handleIsLastAndApprov();

    protected abstract function handleIsNotLastAndApprov();

    protected abstract function handleIsRejected();
}
