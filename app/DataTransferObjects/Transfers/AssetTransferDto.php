<?php

namespace App\DataTransferObjects\Transfers;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\Http\Requests\Transfers\AssetTransferRequest;
use App\Models\Transfers\AssetTransfer;
use App\Services\API\HRIS\EmployeeService;

class AssetTransferDto
{
    public function __construct(
        public readonly ?string $no_transaksi = null,
        public readonly ?string $nik = null,
        public readonly ?string $old_pic = null,
        public readonly ?string $old_location = null,
        public readonly ?string $old_divisi = null,
        public readonly ?string $old_department = null,
        public readonly ?string $new_pic = null,
        public readonly ?string $new_location = null,
        public readonly ?string $new_divisi = null,
        public readonly ?string $new_department = null,
        public readonly ?string $request_transfer_date = null,
        public readonly ?string $justifikasi = null,
        public readonly ?string $remark = null,
        public readonly ?string $transfer_date = null,
        public readonly mixed $key = null,
        public readonly ?EmployeeDto $oldPicDto = null,
        public readonly ?EmployeeDto $newPicDto = null,
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

    public static function fromModel(AssetTransfer $assetTransfer): self
    {
        return new self(
            $assetTransfer->no_transaksi,
            $assetTransfer->nik,
            $assetTransfer->old_pic,
            $assetTransfer->old_location,
            $assetTransfer->old_divisi,
            $assetTransfer->old_department,
            $assetTransfer->new_pic,
            $assetTransfer->new_location,
            $assetTransfer->new_divisi,
            $assetTransfer->new_department,
            $assetTransfer->request_transfer_date,
            $assetTransfer->justifikasi,
            $assetTransfer->remark,
            $assetTransfer->transfer_date,
            $assetTransfer->getKey(),
            EmployeeDto::fromResponse((new EmployeeService)->getByNik($assetTransfer->old_pic)),
            EmployeeDto::fromResponse((new EmployeeService)->getByNik($assetTransfer->new_pic)),
        );
    }
}