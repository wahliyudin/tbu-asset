<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class SubClusterData extends Data
{
    public function __construct(
        #[Required]
        public string $cluster_id,
        #[Required]
        public string $name,
        public ?string $key = null,
    ) {
    }
}