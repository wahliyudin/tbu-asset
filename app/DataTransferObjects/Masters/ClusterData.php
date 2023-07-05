<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ClusterData extends Data
{
    public function __construct(
        #[Required]
        public string $category_id,
        #[Required]
        public string $name,
        public ?string $key,
    ) {
    }
}