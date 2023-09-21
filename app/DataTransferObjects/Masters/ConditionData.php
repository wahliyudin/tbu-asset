<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Data;

class ConditionData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $key = null,
        public ?string $id = null,
    ) {
    }
}
