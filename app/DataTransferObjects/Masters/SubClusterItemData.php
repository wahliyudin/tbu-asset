<?php

namespace App\DataTransferObjects\Masters;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class SubClusterItemData extends Data
{
    public function __construct(
        #[Required]
        public string $sub_cluster_id,
        #[Required]
        public string $name,
        public ?string $key = null,
    ) {
    }
}