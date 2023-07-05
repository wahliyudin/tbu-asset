<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\Masters\UnitData;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AssetData extends Data
{
    public function __construct(
        #[Required]
        public string $kode,
        #[Required]
        public string $unit_id,
        #[Required]
        public string $sub_cluster_id,
        #[Required]
        public string $member_name,
        #[Required]
        public string $pic,
        #[Required]
        public string $activity,
        #[Required]
        public string $asset_location,
        #[Required]
        public string $kondisi,
        #[Required]
        public string $uom,
        #[Required]
        public string $quantity,
        #[Required]
        public string $tgl_bast,
        #[Required]
        public string $hm,
        #[Required]
        public string $pr_number,
        #[Required]
        public string $po_number,
        #[Required]
        public string $gr_number,
        #[Required]
        public string $remark,
        #[Required]
        public string $status,
        public ?string $key = null,
        public ?AssetInsuranceData $insurance,
        public ?AssetLeasingData $leasing,
        public ?UnitData $unit,
        public ?EmployeeData $employee,
    ) {
    }
}