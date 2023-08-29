<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\HRIS\ProjectData;
use App\DataTransferObjects\Masters\UnitData;
use App\DataTransferObjects\Masters\UomData;
use App\Interfaces\DataInterface;
use App\Services\GlobalService;
use Spatie\LaravelData\Data;

class AssetData extends Data implements DataInterface
{
    public function __construct(
        public ?string $kode,
        public ?string $unit_id,
        public ?string $sub_cluster_id,
        public ?string $pic,
        public ?string $activity,
        public ?string $asset_location,
        public ?string $kondisi,
        public ?string $uom_id,
        public ?string $quantity,
        public ?string $tgl_bast,
        public ?string $hm,
        public ?string $pr_number,
        public ?string $po_number,
        public ?string $gr_number,
        public ?string $remark,
        public ?string $status,
        public ?string $key = null,
        public ?string $id = null,
        public ?AssetInsuranceData $insurance,
        public ?AssetLeasingData $leasing,
        public ?DeprecationData $deprecation,
        public ?UnitData $unit,
        public ?UomData $uom,
        public ?ProjectData $project,
        public ?EmployeeData $employee,
    ) {
        $this->employee = EmployeeData::from(GlobalService::getEmployee($this->pic));
        $this->project = ProjectData::from(GlobalService::getProject($this->asset_location));
    }

    public function getKey(): string|null
    {
        return $this?->key ?? $this?->id;
    }
}
