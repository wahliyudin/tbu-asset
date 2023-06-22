<?php

namespace App\DataTransferObjects\API\HRIS;

class PositionDto
{
    public function __construct(
        public readonly ?int $position_id,
        public readonly ?string $position_name,
        public readonly ?int $jabatan_atasan_langsung,
        public readonly ?int $jabatan_atasan_tidak_langsung,
        public readonly DivisiDto $divisi,
        public readonly DepartmentDto $department,
        public readonly ProjectDto $project,
    ) {
    }

    public static function fromResponseByEmployee(array $response): self
    {
        $data = [];
        if (isset($response['position'])) {
            $data = $response['position'];
        }
        return new self(
            isset($data['position_id']) ? $data['position_id'] : null,
            isset($data['position_name']) ? $data['position_name'] : null,
            isset($data['jabatan_atasan_langsung']) ? $data['jabatan_atasan_langsung'] : null,
            isset($data['jabatan_atasan_tidak_langsung']) ? $data['jabatan_atasan_tidak_langsung'] : null,
            DivisiDto::fromResponseByPosition($data),
            DepartmentDto::fromResponseByPosition($data),
            ProjectDto::fromResponseByPosition($data),
        );
    }
}