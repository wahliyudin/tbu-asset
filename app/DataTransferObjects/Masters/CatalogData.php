<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CatalogData extends Data implements DataInterface
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
        public ?string $id = null,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}
