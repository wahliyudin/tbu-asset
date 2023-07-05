<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CatalogData extends Data
{
    public function __construct(
        #[Required]
        public ?string $unit_model,
        #[Required]
        public ?string $unit_type,
        #[Required]
        public ?string $seri,
        #[Required]
        public ?string $unit_class,
        #[Required]
        public ?string $brand,
        #[Required]
        public ?string $spesification,
        public ?string $key = null,
    ) {
    }
}