<?php

namespace App\DataTransferObjects\Disposes;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Helpers\Helper;
use App\Services\GlobalService;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Str;

class AssetDisposeData extends Data
{
    public function __construct(
        public string|null $asset_id,
        public string|null $no_dispose,
        public string|null $nik,
        public string|null $nilai_buku,
        public string|null $est_harga_pasar,
        public string|null $notes,
        public string|null $justifikasi,
        public string|null $remark,
        public Pelaksanaan|string|null $pelaksanaan,
        public ?string $id = null,
        public ?AssetData $asset,
        public ?EmployeeData $employee,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
    ) {
        $this->setDefaultValue();
        $this->employee = EmployeeData::from(GlobalService::getEmployee($this->nik));
    }

    private function setDefaultValue()
    {
        if (is_null($this->id)) {
            $this->nik = auth()->user()->nik;
            $this->no_dispose = Str::random();
        }
    }

    public function nailaiBukuToInt()
    {
        return is_string($this->nilai_buku) ? Helper::resetRupiah($this->nilai_buku) : $this->nilai_buku;
    }

    public function estHargaPasarToInt()
    {
        return is_string($this->est_harga_pasar) ? Helper::resetRupiah($this->est_harga_pasar) : $this->est_harga_pasar;
    }
}
