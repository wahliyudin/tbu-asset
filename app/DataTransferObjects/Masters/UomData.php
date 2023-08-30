<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Data;

class UomData extends Data implements DataInterface
{
    public function __construct(
        public ?string $name,
        public ?string $keterangan,
        public ?string $id = null,
        public ?string $key = null,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}
