<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Data;

class ActivityData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $key = null,
        public ?string $id = null,
    ) {
    }
}
