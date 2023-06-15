<?php

namespace App\DataTransferObjects\Masters;

use App\Http\Requests\Masters\CategoryRequest;

class CategoryDto
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(CategoryRequest $request)
    {
        return new self(
            $request->get('name'),
            $request->get('key'),
        );
    }
}