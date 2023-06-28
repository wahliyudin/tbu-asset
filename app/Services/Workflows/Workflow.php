<?php

namespace App\Services\Workflows;

use App\DataTransferObjects\API\HRIS\WorkflowDto;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Models\Settings\SettingApproval;
use App\Repositories\API\HRIS\ApprovalRepository as HRISApprovalRepository;
use App\Repositories\Settings\ApprovalRepository;
use App\Repositories\WorkflowRepository;
use App\Services\Workflows\Contracts\ModelThatHaveWorkflow;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

abstract class Workflow extends Checker
{
    public function __construct(
        protected Model $model,
        protected Module $module,
    ) {
        $this->checkModel();
        parent::__construct($this->model);
    }

    private function checkModel()
    {
        if (!$this->model instanceof ModelThatHaveWorkflow) {
            throw new Exception("Model must be implements " . ModelThatHaveWorkflow::class);
        }
    }

    public function approvals()
    {
        $approvals = $this->approvalsByModule();

        $data = $this->prepareApprovals($approvals);

        $response = $this->patchDataWorkflows($data, auth()->user()->nik);

        return $this->responseToCollectionsOfWorkflowDto($response);
    }

    private function approvalsByModule(): Collection
    {
        return ApprovalRepository::getByModule($this->module);
    }

    private function prepareApprovals(Collection $approvals): array
    {
        $data = [];
        foreach ($approvals as $approval) {
            array_push($data, $this->payloadApproval($approval));
        }
        return $data;
    }

    private function payloadApproval(SettingApproval $approval): array
    {
        return [
            'approval' => $approval->approval->valueByHRIS(),
            'title' => $approval->title
        ];
    }

    private function patchDataWorkflows(array $data, $nik)
    {
        return (new HRISApprovalRepository)->getBySubmitted([
            'submitted' => $nik,
            'approvals' => $data
        ]);
    }

    private function responseToCollectionsOfWorkflowDto($response)
    {
        return WorkflowDto::fromResponseMultiple($response);
    }

    public function store()
    {
        $workflowDtos = $this->approvals();

        $results = $this->populateDataToStore($workflowDtos);

        return WorkflowRepository::store($this->model, $results);
    }

    private function populateDataToStore(Collection $workflowDtos)
    {
        $results = [];
        foreach ($workflowDtos as $workflowDto) {
            array_push($results, $this->payloadSettingApproval($workflowDto));
        }
        return $results;
    }

    private function payloadSettingApproval(WorkflowDto $workflowDto)
    {
        return [
            'sequence' => $workflowDto->sequence,
            'nik' => $workflowDto->nik,
            'title' => $workflowDto->title,
            'last_action' => $workflowDto->lastAction,
            'last_action_date' => now(),
        ];
    }

    public function lastAction(LastAction $lastAction)
    {
        $workflow = $this->currentWorkflow();
        if (!$workflow->nik == auth()->user()->nik) {
            throw ValidationException::withMessages(['Anda tidak berhak melakukan aksi ini']);
        }
        if ($this->isLast() && $lastAction == LastAction::APPROV) {
            WorkflowRepository::updateStatus($this->model, Status::CLOSE);
            $this->handleIsLastAndApprov();
        }
        if (!($this->isLast()) && $lastAction == LastAction::APPROV) {
            $this->handleIsNotLastAndApprov();
        }
        if ($lastAction == LastAction::REJECT) {
            WorkflowRepository::updateStatus($this->model, Status::REJECT);
            $this->handleIsRejected();
        }
        return WorkflowRepository::updateLasAction($workflow, $lastAction);
    }

    protected abstract function handleStoreWorkflow();

    protected abstract function handleIsLastAndApprov();

    protected abstract function handleIsNotLastAndApprov();

    protected abstract function handleIsRejected();
}