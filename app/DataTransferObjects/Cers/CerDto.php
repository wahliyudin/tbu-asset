<?php

namespace App\DataTransferObjects\Cers;

use App\Http\Requests\Cers\CerRequest;
use Illuminate\Support\Collection;

class CerDto
{
    public function __construct(
        public readonly string $no_cer,
        public readonly string $nik,
        public readonly string $type_budget,
        public readonly string $budget_ref,
        public readonly string $peruntukan,
        public readonly string $tgl_kebutuhan,
        public readonly string $justifikasi,
        public readonly string $sumber_pendanaan,
        public readonly string $cost_analyst,
        public readonly mixed $key = null,
        public readonly ?Collection $items,
        public readonly ?array $itemsToAttach,
    ) {
    }

    public static function fromRequest(CerRequest $request): self
    {
        return new self(
            $request->get('no_cer'),
            $request->get('nik'),
            $request->get('type_budget'),
            $request->get('budget_ref'),
            $request->get('peruntukan'),
            $request->get('tgl_kebutuhan'),
            $request->get('justifikasi'),
            $request->get('sumber_pendanaan'),
            $request->get('cost_analyst'),
            $request->get('key'),
            CerItemDto::fromArray($request->get('items')),
            CerItemDto::fromArrayToAttach($request->get('items')),
        );
    }
}
