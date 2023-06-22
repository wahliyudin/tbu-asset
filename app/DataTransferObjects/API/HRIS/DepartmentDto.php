<?php

namespace App\DataTransferObjects\API\HRIS;

class DepartmentDto
{
    public function __construct(
        public readonly ?int $dept_id,
        public readonly ?string $dept_code,
        public readonly ?string $department_name,
        public readonly ?int $project_id,
        public readonly ?int $division_id,
        public readonly ?int $dept_head,
    ) {
    }

    public static function fromResponseByPosition(array $response): self
    {
        $data = [];
        if (isset($response['department'])) {
            $data = $response['department'];
        }
        return new self(
            isset($data['dept_id']) ? $data['dept_id'] : null,
            isset($data['dept_code']) ? $data['dept_code'] : null,
            isset($data['department_name']) ? $data['department_name'] : null,
            isset($data['project_id']) ? $data['project_id'] : null,
            isset($data['division_id']) ? $data['division_id'] : null,
            isset($data['dept_head']) ? $data['dept_head'] : null,
        );
    }
}