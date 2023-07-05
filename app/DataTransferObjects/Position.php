<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class Position extends Data
{
    public function __construct(
        public ?int $position_id,
        public ?string $position_name,
        public ?int $jabatan_atasan_langsung,
        public ?int $jabatan_atasan_tidak_langsung,
        public ?Divisi $divisi,
        public ?Department $department,
        public ?Project $project,
    ) {
    }
}