<?php

namespace App\DataTransferObjects\Assets;

use App\DataTransferObjects\Masters\UnitDto;
use App\Http\Requests\Assets\AssetRequest;
use App\Models\Assets\Asset;

class AssetDto
{
    public function __construct(
        public readonly string $kode,
        public readonly int $unit_id,
        public readonly int $sub_cluster_id,
        public readonly string $member_name,
        public readonly int $pic,
        public readonly string $activity,
        public readonly int $asset_location,
        public readonly string $kondisi,
        public readonly string $uom,
        public readonly int $quantity,
        public readonly string $tgl_bast,
        public readonly string $hm,
        public readonly string $pr_number,
        public readonly string $po_number,
        public readonly string $gr_number,
        public readonly string $remark,
        public readonly string $status,
        public readonly mixed $key = null,
        public readonly ?UnitDto $unit = null,
    ) {
    }

    public static function fromRequest(AssetRequest $request): self
    {
        return new self(
            $request->get('kode'),
            $request->get('unit_id'),
            $request->get('sub_cluster_id'),
            $request->get('member_name'),
            $request->get('pic'),
            $request->get('activity'),
            $request->get('asset_location'),
            $request->get('kondisi'),
            $request->get('uom'),
            $request->get('quantity'),
            $request->get('tgl_bast'),
            $request->get('hm'),
            $request->get('pr_number'),
            $request->get('po_number'),
            $request->get('gr_number'),
            $request->get('remark'),
            $request->get('status'),
            $request->get('key'),
        );
    }

    public static function fromModel(Asset $asset): self
    {
        return new self(
            $asset->kode,
            $asset->unit_id,
            $asset->sub_cluster_id,
            $asset->member_name,
            $asset->pic,
            $asset->activity,
            $asset->asset_location,
            $asset->kondisi,
            $asset->uom,
            $asset->quantity,
            $asset->tgl_bast,
            $asset->hm,
            $asset->pr_number,
            $asset->po_number,
            $asset->gr_number,
            $asset->remark,
            $asset->status?->value,
            $asset->getKey(),
            UnitDto::fromModel($asset->unit)
        );
    }

    public function toArray(): array
    {
        return [
            'kode' => $this->kode,
            'unit_id' => $this->unit_id,
            'sub_cluster_id' => $this->sub_cluster_id,
            'member_name' => $this->member_name,
            'pic' => $this->pic,
            'activity' => $this->activity,
            'asset_location' => $this->asset_location,
            'kondisi' => $this->kondisi,
            'uom' => $this->uom,
            'quantity' => $this->quantity,
            'tgl_bast' => $this->tgl_bast,
            'hm' => $this->hm,
            'pr_number' => $this->pr_number,
            'po_number' => $this->po_number,
            'gr_number' => $this->gr_number,
            'remark' => $this->remark,
            'status' => $this->status,
            'key' => $this->key,
        ];
    }
}
