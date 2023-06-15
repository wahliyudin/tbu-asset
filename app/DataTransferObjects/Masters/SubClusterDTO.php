<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\SubClusterRequest;

class SubClusterDTO
{
    public function __construct(
        public readonly mixed $cluster_id,
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(SubClusterRequest $request): self
    {
        return new self(
            $request->get('cluster_id'),
            $request->get('name'),
            $request->get('key'),
        );
    }
}