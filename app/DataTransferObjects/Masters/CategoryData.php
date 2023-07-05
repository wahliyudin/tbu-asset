<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CategoryData extends Data
{
    public function __construct(
        #[Required]
        public string $name,
        public ?string $key,
    ) {
    }
}