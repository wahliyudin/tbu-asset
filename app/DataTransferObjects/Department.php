<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class Department extends Data
{
    public function __construct(
        public ?int $dept_id,
        public ?string $dept_code,
        public ?string $department_name,
        public ?int $project_id,
        public ?int $division_id,
        public ?int $dept_head,
    ) {
    }
}