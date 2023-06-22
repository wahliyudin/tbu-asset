<?php

namespace App\DataTransferObjects\API\HRIS;

class DivisiDto
{
    public function __construct(
        public readonly ?int $division_id,
        public readonly ?string $division_name,
        public readonly ?int $division_head,
    ) {
    }

    public static function fromResponseByPosition(array $response): self
    {
        $data = [];
        if (isset($response['divisi'])) {
            $data = $response['divisi'];
        }
        return new self(
            isset($data['division_id']) ? $data['division_id'] : null,
            isset($data['division_name']) ? $data['division_name'] : null,
            isset($data['division_head']) ? $data['division_head'] : null,
        );
    }
}