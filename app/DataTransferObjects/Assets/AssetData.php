<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\HRIS\ProjectData;
use App\DataTransferObjects\Masters\ActivityData;
use App\DataTransferObjects\Masters\ConditionData;
use App\DataTransferObjects\Masters\LifetimeData;
use App\DataTransferObjects\Masters\SubClusterData;
use App\DataTransferObjects\Masters\UomData;
use App\Enums\Asset\Status;
use App\Interfaces\DataInterface;
use App\Services\Assets\AssetService;
use App\Services\GlobalService;
use Spatie\LaravelData\Data;

class AssetData extends Data implements DataInterface
{
    public function __construct(
        public ?string $kode,
        public ?string $new_id_asset,
        public ?string $asset_unit_id,
        public ?string $sub_cluster_id,
        public ?string $pic,
        public ?string $activity_id,
        public ?string $asset_location,
        public ?string $condition_id,
        public ?string $uom_id,
        public ?string $quantity,
        public ?string $lifetime_id,
        public ?string $nilai_sisa,
        public ?string $tgl_bast,
        public ?string $hm,
        public ?string $pr_number,
        public ?string $po_number,
        public ?string $gr_number,
        public ?string $remark,
        public ?Status $status,
        public ?string $status_asset,
        public ?string $key = null,
        public ?string $id = null,
        public ?AssetInsuranceData $insurance,
        public ?SubClusterData $sub_cluster,
        public ?AssetLeasingData $leasing,
        public ?DeprecationData $deprecation,
        public ?AssetUnitData $asset_unit,
        public ?UomData $uom,
        public ?LifetimeData $lifetime,
        public ?ActivityData $activity,
        public ?ConditionData $condition,
        public ?ProjectData $project,
        public ?EmployeeData $employee,
    ) {
        $this->initParams();
    }

    public function initParams()
    {
        if (!isset($this->employee)) {
            $this->employee = EmployeeData::from(GlobalService::getEmployee($this->pic));
        }
        if (!isset($this->project)) {
            $this->project = ProjectData::from(GlobalService::getProject($this->asset_location));
        }
    }

    public function getKey(): string|null
    {
        return $this?->key ?? $this?->id;
    }
}
