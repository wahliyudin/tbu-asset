<?php

namespace App\DataTransferObjects\API\TXIS;

class BudgetDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $kode,
        public readonly ?int $total,
    ) {
    }

    public static function fromResponseMultiple(array $response): array
    {
        $data = [];
        if (isset($response['data'])) {
            $data = $response['data'];
        }
        $results = [];
        foreach ($data as $key => $value) {
            $results = array_merge($results, [new self(
                isset($value['id']) ? $value['id'] : null,
                isset($value['kode']) ? $value['kode'] : null,
                isset($value['total']) ? $value['total'] : null,
            )]);
        }
        return $results;
    }
}