<?php

namespace App\DataTransferObjects\Masters;

use App\Interfaces\DataInterface;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UnitData extends Data implements DataInterface
{
    public function __construct(
        public ?string $kode,
        public ?string $model,
        public ?string $type,
        public ?string $seri,
        public ?string $class,
        public ?string $brand,
        public ?string $serial_number,
        public ?string $spesification,
        public ?string $tahun_pembuatan,
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
            isset($data['id_unit']) ? $data['id_unit'] : null,
            isset($data['unit_model']) ? $data['unit_model'] : null,
            isset($data['unit_type']) ? $data['unit_type'] : null,
            isset($data['seri']) ? $data['seri'] : null,
            isset($data['unit_class']) ? $data['unit_class'] : null,
            isset($data['unit_merk_brand']) ? $data['unit_merk_brand'] : null,
            isset($data['serial_number']) ? $data['serial_number'] : null,
            isset($data['detail_spesifikasi']) ? $data['detail_spesifikasi'] : null,
            isset($data['tahun_pembuatan']) ? $data['tahun_pembuatan'] : null,
        );
    }
}
