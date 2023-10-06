<?php

namespace App\DataTransferObjects\Transfers;

use App\Enums\Transfers\Transfer\Status;
use Spatie\LaravelData\Data;

class StatusTransferData extends Data
{
    public function __construct(
        public ?string $asset_transfer_id,
        public ?Status $status,
        public ?string $date,
        public ?AssetTransferData $asset_transfer
    ) {
    }
}
