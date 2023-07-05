<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\Enums\Workflows\LastAction;
use App\Services\API\HRIS\EmployeeService;
use Spatie\LaravelData\Data;

class WorkflowData extends Data
{
    public function __construct(
        public string $sequence,
        public string $nik,
        public string $title,
        public string|LastAction $last_action,
        public string $last_action_date,
        public ?EmployeeData $employee,
    ) {
        $employee = (new EmployeeService)->getByNik($this->nik);
        $this->employee = EmployeeData::from(isset($employee['data']) ? $employee['data'] : [])->except('position');
    }
}