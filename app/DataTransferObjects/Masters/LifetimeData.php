<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Data;

class LifetimeData extends Data
{
    public function __construct(
        public ?string $masa_pakai,
        public ?string $key = null,
        public ?string $id = null,
    ) {
    }
}
