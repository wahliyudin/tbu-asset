<?php

namespace App\DataTransferObjects\API\HRIS;

use Spatie\LaravelData\Data;

class PositionData extends Data
{
    public function __construct(
        public ?int $position_id,
        public ?string $position_name,
        public ?int $jabatan_atasan_langsung,
        public ?int $jabatan_atasan_tidak_langsung,
        public ?DivisiData $divisi,
        public ?DepartmentData $department,
        public ?ProjectData $project,
    ) {
    }
}