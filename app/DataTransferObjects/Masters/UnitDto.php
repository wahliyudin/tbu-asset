<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\UnitRequest;
use App\Models\Masters\Unit;

class UnitDto
{
    public function __construct(
        public readonly string $kode,
        public readonly string $model,
        public readonly string $type,
        public readonly string $seri,
        public readonly string $class,
        public readonly string $brand,
        public readonly string $serial_number,
        public readonly string $spesification,
        public readonly string $tahun_pembuatan,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(UnitRequest $request): self
    {
        return new self(
            $request->get('kode'),
            $request->get('model'),
            $request->get('type'),
            $request->get('seri'),
            $request->get('class'),
            $request->get('brand'),
            $request->get('serial_number'),
            $request->get('spesification'),
            $request->get('tahun_pembuatan'),
            $request->get('key'),
        );
    }

    public static function fromModel(Unit $unit): self
    {
        return new self(
            $unit->kode,
            $unit->model,
            $unit->type,
            $unit->seri,
            $unit->class,
            $unit->brand,
            $unit->serial_number,
            $unit->spesification,
            $unit->tahun_pembuatan,
            $unit->getKey(),
        );
    }
}
