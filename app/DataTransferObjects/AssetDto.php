<?php

namespace App\DataTransferObjects;

use App\Http\Requests\AssetRequest;

class AssetDto
{
    public function __construct(
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
    ) {
    }

    public static function fromRequest(AssetRequest $request): self
    {
        return new self(
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
}
