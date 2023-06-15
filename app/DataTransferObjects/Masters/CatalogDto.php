<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\CatalogRequest;

class CatalogDto
{
    public function __construct(
        public readonly string $unit_model,
        public readonly string $unit_type,
        public readonly string $seri,
        public readonly string $unit_class,
        public readonly string $brand,
        public readonly string $spesification,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(CatalogRequest $request): self
    {
        return new self(
            $request->get('unit_model'),
            $request->get('unit_type'),
            $request->get('seri'),
            $request->get('unit_class'),
            $request->get('brand'),
            $request->get('spesification'),
            $request->get('key'),
        );
    }
}