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

    public static function formResponse(array $response): self
    {
        $data = [];
        if (isset($response['data'])) {
            $data = $response['data'];
        }
        return new self(
            isset($data['idbudget_detail']) ? $data['idbudget_detail'] : null,
            isset($data['budgetheader']['tahun']) ? $data['budgetheader']['tahun'] : null,
            isset($data['budgetcode']) ? $data['budgetcode'] : null,
            isset($data['totalbudget']) ? $data['totalbudget'] : null,
        );
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
