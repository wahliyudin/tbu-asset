<?php

namespace App\DataTransferObjects\API\TXIS;

use Spatie\LaravelData\Data;

class BudgetTransferData extends Data
{
    public function __construct(
        public ?string $unitid,
        public ?string $project_from,
        public ?string $project_to,
        public ?string $no_transaksi,
    ) {
    }
}
