<?php

namespace App\DataTransferObjects\API\HRIS;

class EmployeeDto
{
    public function __construct(
        public readonly int $nik,
        public readonly ?string $nama_karyawan,
        public readonly ?string $costing,
        public readonly ?string $activity,
        public readonly ?string $tipe_kontrak,
        public readonly ?string $tgl_bergabung,
        public readonly ?string $tgl_pengangkatan,
        public readonly ?string $resign_date,
        public readonly ?string $tgl_naik_level,
        public readonly ?string $tgl_mcu_terakhir,
        public readonly ?string $email_perusahaan,
        public readonly ?string $point_of_hire,
        public readonly ?string $point_of_leave,
        public readonly ?string $ring_clasification,
        public readonly ?string $tipe_mess,
        public readonly ?string $martial_status_id,
        public readonly ?string $status,
        public readonly PositionDto $position,
    ) {
    }

    public static function fromResponse(array $response): self
    {
        $data = $response['data'];
        return new self(
            $data['nik'],
            $data['nama_karyawan'],
            $data['costing'],
            $data['activity'],
            $data['tipe_kontrak'],
            $data['tgl_bergabung'],
            $data['tgl_pengangkatan'],
            $data['resign_date'],
            $data['tgl_naik_level'],
            $data['tgl_mcu_terakhir'],
            $data['email_perusahaan'],
            $data['point_of_hire'],
            $data['point_of_leave'],
            $data['ring_clasification'],
            $data['tipe_mess'],
            $data['martial_status_id'],
            $data['status'],
            PositionDto::fromResponseByEmployee($data),
        );
    }
}