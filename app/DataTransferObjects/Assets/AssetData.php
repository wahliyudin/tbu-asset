<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Masters\UnitData;
use App\Services\GlobalService;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AssetData extends Data
{
    public function __construct(
        public string $kode,
        public string $unit_id,
        public string $sub_cluster_id,
        public string $member_name,
        public string $pic,
        public string $activity,
        public string $asset_location,
        public string $kondisi,
        public string $uom,
        public string $quantity,
        public string $tgl_bast,
        public string $hm,
        public string $pr_number,
        public string $po_number,
        public string $gr_number,
        public string $remark,
        public string $status,
        public ?string $key = null,
        public ?AssetInsuranceData $insurance,
        public ?AssetLeasingData $leasing,
        public ?UnitData $unit,
        public ?EmployeeData $employee,
    ) {
        $this->employee = EmployeeData::from(GlobalService::getEmployee($this->pic));
    }
}