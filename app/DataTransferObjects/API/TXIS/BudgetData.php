<?php

namespace App\DataTransferObjects\API\TXIS;

use Spatie\LaravelData\Data;

class BudgetData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $periode,
        public ?string $kode,
        public ?string $description,
        public ?int $total,
    ) {
    }

    public static function fromApi(array $data): static
    {
        return new self(
            isset($data['idbudget_detail']) ? $data['idbudget_detail'] : null,
            isset($data['budgetheader']['tahun']) ? $data['budgetheader']['tahun'] : null,
            isset($data['budgetcode']) ? $data['budgetcode'] : null,
            isset($data['description']) ? $data['description'] : null,
            isset($data['totalbudget']) ? $data['totalbudget'] : null,
        );
    }
}
