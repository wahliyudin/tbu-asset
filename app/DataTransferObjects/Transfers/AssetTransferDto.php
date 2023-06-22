<?php

namespace App\DataTransferObjects\Transfers;

use App\Http\Requests\Transfers\AssetTransferRequest;

class AssetTransferDto
{
    public function __construct(
        public readonly string $no_transaksi,
        public readonly string $nik,
        public readonly string $old_pic,
        public readonly string $old_location,
        public readonly string $old_divisi,
        public readonly string $old_department,
        public readonly string $new_pic,
        public readonly string $new_location,
        public readonly string $new_divisi,
        public readonly string $new_department,
        public readonly string $request_transfer_date,
        public readonly string $justifikasi,
        public readonly string $remark,
        public readonly string $transfer_date,
        public readonly mixed $key = null,
    ) {
    }

    public static function fromRequest(AssetTransferRequest $request): self
    {
        return new self(
            $request->get('no_transaksi'),
            $request->get('nik'),
            $request->get('old_pic'),
            $request->get('old_location'),
            $request->get('old_divisi'),
            $request->get('old_department'),
            $request->get('new_pic'),
            $request->get('new_location'),
            $request->get('new_divisi'),
            $request->get('new_department'),
            $request->get('request_transfer_date'),
            $request->get('justifikasi'),
            $request->get('remark'),
            $request->get('transfer_date'),
            $request->get('key'),
        );
    }
}