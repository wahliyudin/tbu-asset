<?php

namespace App\DataTransferObjects\Cers;

use App\DataTransferObjects\Masters\UomData;
use Spatie\LaravelData\Data;

class CerItemData extends Data
{
    public function __construct(
        public ?string $description,
        public ?string $model,
        public ?int $est_umur,
        public ?int $qty,
        public ?int $price,
        public ?string $uom_id,
        public ?string $key = null,
        public ?string $id = null,
        public ?UomData $uom,
        public ?CerData $cer,
    ) {
    }
}
