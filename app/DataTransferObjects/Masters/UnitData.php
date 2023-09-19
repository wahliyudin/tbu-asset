<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UnitData extends Data implements DataInterface
{
    public function __construct(
        public ?string $prefix,
        public ?string $model,
        public ?string $key = null,
        public ?string $id = null,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }

    public function fromImport(array $data)
    {
        return new self(
            isset($data['prefix']) ? $data['prefix'] : null,
            isset($data['unit_model']) ? $data['unit_model'] : null,
        );
    }
}
