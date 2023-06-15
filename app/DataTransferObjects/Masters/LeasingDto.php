<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\LeasingRequest;

class LeasingDto
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(LeasingRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('key'),
        );
    }
}