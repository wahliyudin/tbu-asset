<?php

namespace App\DataTransferObjects\Assets;

use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AssetLeasingData extends Data
{
    public function __construct(
        public ?string $dealer_id,
        public ?string $leasing_id,
        public ?string $harga_beli,
        public ?string $jangka_waktu_leasing,
        public ?string $biaya_leasing,
        public ?string $legalitas,
        public ?string $key = null,
    ) {
    }

    public static function fromRequest(AssetRequest $request): self
    {
        return new self(
            $request->get('dealer_id_leasing'),
            $request->get('leasing_id_leasing'),
            $request->get('harga_beli_leasing'),
            $request->get('jangka_waktu_leasing'),
            $request->get('biaya_leasing'),
            $request->get('legalitas_leasing'),
        );
    }

    public function hargaBeliToInt(): int
    {
        return Helper::resetRupiah($this->harga_beli);
    }

    public function biayaToInt(): int
    {
        return Helper::resetRupiah($this->biaya_leasing);
    }
}