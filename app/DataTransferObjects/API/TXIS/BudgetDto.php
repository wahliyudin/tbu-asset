<?php

namespace App\DataTransferObjects\API\TXIS;

class BudgetDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $periode,
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
                isset($value['idbudget_detail']) ? $value['idbudget_detail'] : null,
                isset($value['budgetheader']['tahun']) ? $value['budgetheader']['tahun'] : null,
                isset($value['budgetcode']) ? $value['budgetcode'] : null,
                isset($value['totalbudget']) ? $value['totalbudget'] : null,
            )]);
        }
        return $results;
    }
}