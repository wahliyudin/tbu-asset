<?php

namespace App\DataTransferObjects\Assets;

use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;

class AssetLeasingDto extends Helper
{
    public function __construct(
        public readonly ?string $dealer_id,
        public readonly ?string $leasing_id,
        public readonly ?string $harga_beli,
        public readonly ?int $jangka_waktu_leasing,
        public readonly ?string $biaya_leasing,
        public readonly ?string $legalitas,
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

    public static function fromAsset(Asset $asset): self
    {
        $asset->loadMissing('leasing');
        return new self(
            $asset->leasing?->dealer_id,
            $asset->leasing?->leasing_id,
            $asset->leasing?->harga_beli,
            $asset->leasing?->jangka_waktu_leasing,
            $asset->leasing?->biaya_leasing,
            $asset->leasing?->legalitas,
        );
    }

    public function toArray(): array
    {
        return [
            'dealer_id_leasing' => $this->dealer_id,
            'leasing_id_leasing' => $this->leasing_id,
            'harga_beli_leasing' => $this->harga_beli,
            'jangka_waktu_leasing' => $this->jangka_waktu_leasing,
            'biaya_leasing' => $this->biaya_leasing,
            'legalitas_leasing' => $this->legalitas,
        ];
    }

    public function intHargaBeli(): int
    {
        return $this->resetToNumber($this->harga_beli);
    }

    public function intBiaya(): int
    {
        return $this->resetToNumber($this->biaya_leasing);
    }
}
