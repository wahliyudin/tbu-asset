<?php

namespace App\DataTransferObjects\API\HRIS;

use Spatie\LaravelData\Data;

class DepartmentData extends Data
{
    public function __construct(
        public ?int $dept_id,
        public ?string $dept_code,
        public ?string $budget_dept_code,
        public ?string $department_name,
        public ?int $project_id,
        public ?int $division_id,
        public ?int $dept_head,
    ) {
    }
}
