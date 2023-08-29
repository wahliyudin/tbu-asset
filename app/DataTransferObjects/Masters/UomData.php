<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Data;

class UomData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $keterangan,
        public ?string $id = null,
    ) {
    }
}
