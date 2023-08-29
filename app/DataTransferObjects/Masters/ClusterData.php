<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ClusterData extends Data implements DataInterface
{
    public function __construct(
        #[Required]
        public string $category_id,
        #[Required]
        public string $name,
        public ?string $key = null,
        public ?string $id = null,
        public ?CategoryData $category,
        #[DataCollectionOf(SubClusterData::class)]
        public ?DataCollection $sub_clusters,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}