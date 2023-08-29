<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class SubClusterItemData extends Data implements DataInterface
{
    public function __construct(
        #[Required]
        public string $sub_cluster_id,
        #[Required]
        public string $name,
        public ?string $key = null,
        public ?string $id = null,
        public ?SubClusterData $sub_cluster,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}
