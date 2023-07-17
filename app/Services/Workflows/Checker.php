<?php

namespace App\Services\Workflows;

use App\Enums\Workflows\LastAction;
use App\Repositories\WorkflowRepository;
use Illuminate\Database\Eloquent\Model;

class Checker
{
    public function __construct(
        protected Model $model,
    ) {
        $this->load();
    }

    private function load()
    {
        $this->model = WorkflowRepository::loadWorkflows($this->model);
    }

    public function isAllApprov(): bool
    {
        return $this->model->workflow?->last_action == LastAction::APPROV;
    }

    public function currentWorkflow()
    {
        return $this->model->workflows?->first();
    }

    public function isCurrentWorkflow(): bool
    {
        return $this->currentWorkflow()?->nik == auth()->user()->nik;
    }

    public function isLast(): bool
    {
        return count($this->model->workflows) == 1;
    }

    public function nextWorkflow()
    {
        $this->load();
        return $this->currentWorkflow();
    }
}
