<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class SubClusterData extends Data implements DataInterface
{
    public function __construct(
        #[Required]
        public string $cluster_id,
        #[Required]
        public string $name,
        public ?string $key = null,
        public ?string $id = null,
        public ?ClusterData $cluster,
        #[DataCollectionOf(SubClusterItemData::class)]
        public ?DataCollection $sub_cluster_items,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}
