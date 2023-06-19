<?php

namespace App\DataTransferObjects\Assets;

use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;

class AssetInsuranceDto extends Helper
{
    public function __construct(
        public readonly ?int $jangka_waktu,
        public readonly ?string $biaya,
        public readonly ?string $legalitas,
    ) {
    }

    public static function fromRequest(AssetRequest $request): self
    {
        return new self(
            $request->get('jangka_waktu_insurance'),
            $request->get('biaya_insurance'),
            $request->get('legalitas_insurance'),
        );
    }

    public static function fromAsset(Asset $asset): self
    {
        $asset->loadMissing('insurance');
        return new self(
            $asset->insurance?->jangka_waktu,
            $asset->insurance?->biaya,
            $asset->insurance?->legalitas,
        );
    }

    public function toArray(): array
    {
        return [
            'jangka_waktu_insurance' => $this->jangka_waktu,
            'biaya_insurance' => $this->biaya,
            'legalitas_insurance' => $this->legalitas,
        ];
    }

    public function intBiaya(): int
    {
        return $this->resetToNumber($this->biaya);
    }
}
