<?php

namespace App\DataTransferObjects\Assets;

use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use Spatie\LaravelData\Data;

class AssetInsuranceData extends Data
{
    public function __construct(
        public ?string $jangka_waktu,
        public ?string $biaya,
        public ?string $legalitas,
        public ?string $key = null,
    ) {
    }

    public static function fromRequest(AssetRequest $request)
    {
        return new self(
            $request->get('jangka_waktu_insurance'),
            $request->get('biaya_insurance'),
            $request->get('legalitas_insurance'),
        );
    }

    public function biayaToInt(): int
    {
        return is_int($this->biaya) ? $this->biaya : Helper::resetRupiah($this->biaya);
    }
}
