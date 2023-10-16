<?php

namespace App\DataTransferObjects\Transfers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Assets\AssetData;
use App\DataTransferObjects\WorkflowData;
use App\Enums\Transfers\Transfer\Status as TransferStatus;
use App\Enums\Workflows\Status;
use App\Facades\HRIS\EmployeeService;
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
        public ?string $old_project,
        public ?string $old_location,
        public ?string $old_divisi,
        public ?string $old_department,
        public ?string $new_pic,
        public ?string $new_project,
        public ?string $new_location,
        public ?string $new_divisi,
        public ?string $new_department,
        public ?string $request_transfer_date,
        public ?string $justifikasi,
        public ?string $remark,
        public ?string $note,
        public ?string $transfer_date,
        public ?string $tanggal_bast,
        public ?string $no_bast,
        public ?string $file_bast,
        public ?string $created_at,
        public ?StatusTransferData $status_transfer,
        public ?Status $status,
        public ?string $id = null,
        public ?EmployeeData $oldPic,
        public ?EmployeeData $newPic,
        public ?AssetData $asset,
        #[DataCollectionOf(WorkflowData::class)]
        public ?DataCollection $workflows,
    ) {
        $this->setDefaultValue();
        $this->oldPic = EmployeeData::from(EmployeeService::findByNik($this->old_pic) ?? []);
        $this->newPic = EmployeeData::from(EmployeeService::findByNik($this->new_pic) ?? []);
    }

    private function setDefaultValue()
    {
        if (is_null($this->id)) {
            $this->nik = auth()->user()?->nik;
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
