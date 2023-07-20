<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UnitData extends Data implements DataInterface
{
    public function __construct(
        #[Required]
        public string $kode,
        #[Required]
        public string $model,
        #[Required]
        public string $type,
        #[Required]
        public string $seri,
        #[Required]
        public string $class,
        #[Required]
        public string $brand,
        #[Required]
        public string $serial_number,
        #[Required]
        public string $spesification,
        #[Required]
        public string $tahun_pembuatan,
        public ?string $key = null,
        public ?string $id = null,
    ) {
    }

    public function getKey(): string|null
    {
        return $this->key ?? $this->id;
    }
}
