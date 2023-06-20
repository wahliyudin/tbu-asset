<?php

namespace App\Services;

use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Module;
use App\Interfaces\ModelWithWorkflowInterface;
use App\Repositories\Settings\ApprovalRepository;
use App\Repositories\WorkflowRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class WorkflowService
{
    public function __construct(
        protected Model $model,
        protected Module $module,
    ) {
        if (!$model instanceof ModelWithWorkflowInterface) {
            throw new Exception("Model must be implements " . ModelWithWorkflowInterface::class);
        }
        $this->model = WorkflowRepository::loadWorkflows($this->model);
    }

    public function store()
    {
        $results = [];
        array_push($results, $this->generatePayload(1, auth()->user()->nik, str("Submitted")->upper(), LastAction::APPROV));
        $settings = ApprovalRepository::getByModule($this->module);
        $index = 2;
        foreach ($settings as $setting) {
            array_push(
                $results,
                $this->generatePayload(
                    $index,
                    ApprovalRepository::logicApproval($setting->approval) ?? $setting->nik,
                    str($setting->title)->upper(),
                    LastAction::NOTTING
                )
            );
            $index++;
        }
        $this->handleStoreWorkflow();
        return WorkflowRepository::store($this->model, $results);
    }

    private function generatePayload(int $index, $nik, string $title, LastAction $lastAction)
    {
        return [
            'sequence' => $index,
            'nik' => $nik,
            'title' => $title,
            'last_action' => $lastAction,
            'last_action_date' => now(),
        ];
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
        return WorkflowRepository::updateLasAction($workflow, $lastAction);
    }

    protected abstract function handleStoreWorkflow();

    protected abstract function handleIsLastAndApprov();

    protected abstract function handleIsNotLastAndApprov();

    protected abstract function handleIsRejected();
}
