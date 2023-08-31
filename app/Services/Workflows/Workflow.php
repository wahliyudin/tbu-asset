<?php

namespace App\Services\Workflows;

use App\DataTransferObjects\WorkflowData;
use App\Enums\Settings\Approval;
use App\Enums\Workflows\LastAction;
use App\Enums\Workflows\Module;
use App\Enums\Workflows\Status;
use App\Helpers\AuthHelper;
use App\Models\Settings\SettingApproval;
use App\Repositories\API\HRIS\ApprovalRepository as HRISApprovalRepository;
use App\Repositories\Settings\ApprovalRepository;
use App\Repositories\WorkflowRepository;
use App\Services\Workflows\Contracts\ModelThatHaveWorkflow;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\DataCollection;

abstract class Workflow extends Checker
{
    protected array $additionalParams = [];

    protected int $barrier = 0;

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

        $response = $this->patchDataWorkflows($data, AuthHelper::getNik());

        return $this->responseToCollectionsOfWorkflowData($response);
    }

    private function approvalsByModule(): Collection
    {
        return ApprovalRepository::getByModule($this->module);
    }

    private function prepareApprovals(Collection $approvals): array
    {
        $data = [];
        foreach ($approvals as $key => $approval) {
            array_push($data, $this->payloadApprovalForHRIS($approval));
            if (!$this->delimiterCheck($approval)) {
                break;
            }
        }
        return $data;
    }

    private function delimiterCheck(SettingApproval $settingApproval)
    {
        if ($this->barrier < 10_000_000 && $settingApproval->approval === Approval::DEPARTMENT_HEAD) {
            return false;
        }
        // if ($this->barrier > 10_000_000 && $this->barrier <= 25_000_000 && $settingApproval->approval === Approval::DIVISION_HEAD) {
        //     return false;
        // }
        if ($this->barrier > 25_000_000 && $settingApproval->approval === Approval::DIRECTOR) {
            return false;
        }
        return true;
    }

    private function payloadApprovalForHRIS(SettingApproval $approval): array
    {
        return [
            'approval' => $approval->approval->valueByHRIS(),
            'nik' => $approval->nik,
            'title' => $approval->title
        ];
    }

    private function patchDataWorkflows(array $data, $nik)
    {
        $payload = $this->preparePayload($data, $nik);
        $response = (new HRISApprovalRepository)->getBySubmitted($payload);
        if (isset($response['exception'])) {
            throw ValidationException::withMessages([isset($response['message']) ? $response['message'] : 'Something went wrong!']);
        }
        return $response;
    }

    private function preparePayload(array $data, $nik)
    {
        $payload = [
            'submitted' => $nik,
            'approvals' => $data,
        ];
        return array_merge($payload, $this->additionalParams);
    }

    private function responseToCollectionsOfWorkflowData($response): DataCollection
    {
        return WorkflowData::collection($response)->except('employee', 'last_action_date');
    }

    public function store()
    {
        $workflowDatas = $this->approvals();
        $this->handleStoreWorkflow();
        return WorkflowRepository::store($this->model, $workflowDatas->toArray());
    }

    public function lastAction(LastAction $lastAction)
    {
        $workflow = $this->currentWorkflow();
        if (!$workflow->nik == AuthHelper::getNik()) {
            throw ValidationException::withMessages(['Anda tidak berhak melakukan aksi ini']);
        }
        if ($this->isLast() && $lastAction == LastAction::APPROV) {
            WorkflowRepository::updateStatus($this->model, Status::CLOSE);
            $this->handleIsLastAndApprov();
            $this->changeStatus($this->model, Status::CLOSE);
        }
        if (!($this->isLast()) && $lastAction == LastAction::APPROV) {
            $this->handleIsNotLastAndApprov();
        }
        if ($lastAction == LastAction::REJECT) {
            WorkflowRepository::updateStatus($this->model, Status::REJECT);
            $this->changeStatus($this->model, Status::REJECT);
            $this->handleIsRejected();
        }
        return WorkflowRepository::updateLasAction($workflow, $lastAction);
    }

    public function setAdditionalParams(array $params)
    {
        $this->additionalParams = $params;
        return $this;
    }

    public function setBarrier(int $barrier)
    {
        $this->barrier = $barrier;
        return $this;
    }

    protected abstract function handleStoreWorkflow();

    protected abstract function handleIsLastAndApprov();

    protected abstract function handleIsNotLastAndApprov();

    protected abstract function handleIsRejected();

    protected abstract function changeStatus(Model $model, Status $status);
}
