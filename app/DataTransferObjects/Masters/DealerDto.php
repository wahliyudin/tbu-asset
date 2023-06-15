<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\DealerRequest;

class DealerDto
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(DealerRequest $request): self
    {
        return new self(
            $request->get('name'),
            $request->get('key'),
        );
    }
}