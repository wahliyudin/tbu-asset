<?php

namespace App\DataTransferObjects\Transfers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Workflows\Status;
use App\Interfaces\DataInterface;
use App\Services\GlobalService;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Str;

class AssetTransferData extends Data implements DataInterface
{
    public function __construct(
        public ?string $no_transaksi,
        public ?string $nik,
        public ?string $asset_id,
        public ?string $old_pic,
        public ?string $old_location,
        public ?string $old_divisi,
        public ?string $old_department,
        public ?string $new_pic,
        public ?string $new_location,
        public ?string $new_divisi,
        public ?string $new_department,
        public ?string $request_transfer_date,
        public ?string $justifikasi,
        public ?string $remark,
        public ?string $transfer_date,
        public ?string $created_at,
        public ?Status $status,
        public ?string $id = null,
        public ?EmployeeData $oldPic,
        public ?EmployeeData $newPic,
        public ?AssetData $asset,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
    ) {
        $this->setDefaultValue();
        $this->oldPic = EmployeeData::from(GlobalService::getEmployee($this->old_pic));
        $this->newPic = EmployeeData::from(GlobalService::getEmployee($this->new_pic));
    }

    private function setDefaultValue()
    {
        if (is_null($this->id)) {
            $this->nik = auth()->user()->nik;
            $this->no_transaksi = Str::random();
        }
        if (is_null($this->request_transfer_date)) {
            $this->request_transfer_date = now();
        }
    }

    public function getKey(): string|null
    {
        return $this->id;
    }
}
