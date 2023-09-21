<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\API\TXIS\VendorData;
use App\DataTransferObjects\Masters\DealerData;
use App\DataTransferObjects\Masters\LeasingData;
use App\DataTransferObjects\Masters\LifetimeData;
use App\Helpers\Helper;
use App\Http\Requests\Assets\AssetRequest;
use App\Services\GlobalService;
use Spatie\LaravelData\Data;

class AssetLeasingData extends Data
{
    public function __construct(
        public ?string $dealer_id,
        public ?string $suplier_dealer,
        public ?string $leasing_id,
        public ?string $harga_beli,
        public ?string $jangka_waktu_leasing,
        public ?string $biaya_leasing,
        public ?string $legalitas,
        public ?string $tanggal_perolehan,
        public ?string $tanggal_awal_leasing,
        public ?string $tanggal_akhir_leasing,
        public ?LeasingData $leasing = null,
        public ?LifetimeData $lifetime = null,
        public ?VendorData $dealer = null,
        public ?string $key = null,
    ) {
        if ($this->dealer_id) {
            $this->dealer = GlobalService::vendorById($this->dealer_id);
        }
    }

    public static function fromRequest(AssetRequest $request): self
    {
        return new self(
            $request->get('dealer_id_leasing'),
            $request->get('suplier_dealer_leasing'),
            $request->get('leasing_id_leasing'),
            $request->get('harga_beli_leasing'),
            $request->get('jangka_waktu_leasing'),
            $request->get('biaya_leasing'),
            $request->get('legalitas_leasing'),
            $request->get('tanggal_perolehan_leasing'),
            $request->get('tanggal_awal_leasing'),
            $request->get('tanggal_akhir_leasing'),
        );
    }

    public function hargaBeliToInt(): int
    {
        return is_int($this->harga_beli) ? $this->harga_beli : Helper::resetRupiah($this->harga_beli);
    }

    public function biayaToInt(): int
    {
        return is_int($this->biaya_leasing) ? $this->biaya_leasing : Helper::resetRupiah($this->biaya_leasing);
    }
}
