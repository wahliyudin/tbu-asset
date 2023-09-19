<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\Masters\UnitData;
use Spatie\LaravelData\Data;

class AssetUnitData extends Data
{
    public function __construct(
        public ?string $unit_id,
        public ?string $kode,
        public ?string $prefix,
        public ?string $seri,
        public ?string $class,
        public ?string $brand,
        public ?string $serial_number,
        public ?string $spesification,
        public ?string $tahun_pembuatan,
        public ?string $kelengkapan_tambahan,
        public ?UnitData $unit,
    ) {
    }
}
