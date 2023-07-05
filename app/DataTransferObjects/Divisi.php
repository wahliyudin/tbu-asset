<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class Divisi extends Data
{
    public function __construct(
        public ?int $division_id,
        public ?string $division_name,
        public ?int $division_head,
    ) {
    }
}