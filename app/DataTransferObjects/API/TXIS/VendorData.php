<?php

namespace App\DataTransferObjects\API\TXIS;

use Spatie\LaravelData\Data;

class VendorData extends Data
{
    public function __construct(
        public ?string $btabvendorid,
        public ?string $contractno,
        public ?string $vendorid,
        public ?string $vendorname,
        public ?string $groupcompany,
        public ?string $status,
        public ?string $alamat,
        public ?string $pic,
        public ?string $jabatan,
        public ?string $telp,
        public ?string $fax,
        public ?string $email,
        public ?string $email2,
        public ?string $norek,
        public ?string $npwp,
        public ?string $deliverypoint,
        public ?string $namakota,
        public ?string $provinsi,
        public ?string $kodepos,
        public ?string $top,
        public ?string $website,
        public ?string $contactperson,
        public ?string $createdby,
        public ?string $createddate,
    ) {
    }
}
