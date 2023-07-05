<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UomData extends Data
{
    public function __construct(
        #[Required]
        public string $name,
        public ?string $keterangan,
        public ?string $key,
    ) {
    }
}