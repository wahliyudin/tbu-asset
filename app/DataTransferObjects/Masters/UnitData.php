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

    public static function fromImport(array $data)
    {
        return self::from([
            'kode' => isset($data['id_unit']) ? $data['id_unit'] : null,
            'model' => isset($data['unit_model']) ? $data['unit_model'] : null,
            'type' => isset($data['unit_type']) ? $data['unit_type'] : null,
            'seri' => isset($data['seri']) ? $data['seri'] : null,
            'class' => isset($data['unit_class']) ? $data['unit_class'] : null,
            'brand' => isset($data['unit_merk_brand']) ? $data['unit_merk_brand'] : null,
            'serial_number' => isset($data['serial_number']) ? $data['serial_number'] : null,
            'spesification' => isset($data['detail_spesifikasi']) ? $data['detail_spesifikasi'] : null,
            'tahun_pembuatan' => isset($data['tahun_pembuatan']) ? $data['tahun_pembuatan'] : null,
        ]);
    }
}