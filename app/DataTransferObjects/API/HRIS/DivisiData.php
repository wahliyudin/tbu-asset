<?php

namespace App\DataTransferObjects\API\HRIS;

use Spatie\LaravelData\Data;

class DivisiData extends Data
{
    public function __construct(
        public ?int $division_id,
        public ?string $division_name,
        public ?int $division_head,
    ) {
    }
}