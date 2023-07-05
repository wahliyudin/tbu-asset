<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class Example extends Data
{
    public function __construct(
        public ?int $nik,
        public ?string $nama_karyawan,
        public ?string $costing,
        public ?string $activity,
        public ?string $tipe_kontrak,
        public ?string $tgl_bergabung,
        public ?string $tgl_pengangkatan,
        public ?string $resign_date,
        public ?string $tgl_naik_level,
        public ?string $tgl_mcu_terakhir,
        public ?string $email_perusahaan,
        public ?string $point_of_hire,
        public ?string $point_of_leave,
        public ?string $ring_clasification,
        public ?string $tipe_mess,
        public ?string $martial_status_id,
        public ?string $status,
        public Position $position,
    ) {
    }
}