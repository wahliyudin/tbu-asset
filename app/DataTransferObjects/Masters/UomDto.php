<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\UomRequest;

class UomDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $keterangan,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(UomRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('keterangan'),
            $request->get('key'),
        );
    }
}
