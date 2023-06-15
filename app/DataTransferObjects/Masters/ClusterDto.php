<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\ClusterRequest;

class ClusterDto
{
    public function __construct(
        public readonly mixed $category_id,
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(ClusterRequest $request): self
    {
        return new self(
            $request->get('category_id'),
            $request->get('name'),
            $request->get('key'),
        );
    }
}