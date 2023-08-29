<?php

namespace App\DataTransferObjects\Assets;

use Spatie\LaravelData\Data;

class DeprecationData extends Data
{
    public function __construct(
        public ?string $masa_pakai,
        public ?string $umur_asset,
        public ?string $umur_pakai,
        public ?string $depresiasi,
        public ?string $sisa,
        public ?string $key = null,
    ) {
    }
}
