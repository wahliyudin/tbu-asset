<?php

namespace App\DataTransferObjects\Cers;

use Spatie\LaravelData\Data;

class CerItemData extends Data
{
    public function __construct(
        public ?string $description = null,
        public ?string $model = null,
        public ?int $est_umur = null,
        public ?int $qty = null,
        public ?int $price = null,
        public ?string $uom = null,
        public ?string $key = null,
    ) {
    }
}