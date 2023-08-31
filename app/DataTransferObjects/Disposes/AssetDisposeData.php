<?php

namespace App\DataTransferObjects\Disposes;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Disposes\Dispose\Pelaksanaan;
use App\Enums\Workflows\Status;
use App\Helpers\Helper;
use App\Interfaces\DataInterface;
use App\Services\GlobalService;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Str;

class AssetDisposeData extends Data implements DataInterface
{
    public function __construct(
        public ?string $asset_id,
        public ?string $no_dispose,
        public ?string $nik,
        public ?string $nilai_buku,
        public ?string $est_harga_pasar,
        public ?string $notes,
        public ?string $justifikasi,
        public ?string $remark,
        public Pelaksanaan|null $pelaksanaan,
        public ?Status $status,
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

    public function getKey(): string|null
    {
        return $this->id;
    }
}
