<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\Masters\UnitData;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssetUnitData extends Data
{
    public function __construct(
        public ?string $unit_id,
        public ?string $kode,
        public ?string $unit_id_owner,
        public ?string $type,
        public ?string $seri,
        public ?string $class,
        public ?string $brand,
        public ?string $serial_number,
        public ?string $spesification,
        public ?string $tahun_pembuatan,
        public ?string $kelengkapan_tambahan,
        public ?UnitData $unit = null,
        public ?string $key = null,
    ) {
    }

    public static function fromRequest(Request $request)
    {
        return new self(
            $request->get('unit_unit_id'),
            $request->get('unit_kode'),
            $request->get('unit_unit_id_owner'),
            $request->get('unit_type'),
            $request->get('unit_seri'),
            $request->get('unit_class'),
            $request->get('unit_brand'),
            $request->get('unit_serial_number'),
            $request->get('unit_spesification'),
            $request->get('unit_tahun_pembuatan'),
            $request->get('unit_kelengkapan_tambahan'),
        );
    }
}
