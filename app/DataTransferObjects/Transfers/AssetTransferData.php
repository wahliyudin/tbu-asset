<?php

namespace App\DataTransferObjects\Transfers;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\Services\GlobalService;
use Spatie\LaravelData\Data;

class AssetTransferData extends Data
{
    public function __construct(
        public ?string $no_transaksi = null,
        public ?string $nik = null,
        public ?string $old_pic = null,
        public ?string $old_location = null,
        public ?string $old_divisi = null,
        public ?string $old_department = null,
        public ?string $new_pic = null,
        public ?string $new_location = null,
        public ?string $new_divisi = null,
        public ?string $new_department = null,
        public ?string $request_transfer_date = null,
        public ?string $justifikasi = null,
        public ?string $remark = null,
        public ?string $transfer_date = null,
        public ?string $id = null,
        public ?EmployeeData $oldPic = null,
        public ?EmployeeData $newPic = null,
    ) {
        $this->setDefaultValue();
        $this->oldPic = EmployeeData::from(GlobalService::getEmployee($this->old_pic));
        $this->newPic = EmployeeData::from(GlobalService::getEmployee($this->new_pic));
    }

    private function setDefaultValue()
    {
        if (is_null($this->nik)) {
            $this->nik = auth()->user()->nik;
        }
    }
}