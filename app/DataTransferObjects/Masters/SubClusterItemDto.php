<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\SubClusterItemRequest;

class SubClusterItemDto
{
    public function __construct(
        public readonly mixed $sub_cluster_id,
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(SubClusterItemRequest $request): self
    {
        return new self(
            $request->get('sub_cluster_id'),
            $request->get('name'),
            $request->get('key'),
        );
    }
}