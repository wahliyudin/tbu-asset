<?php

namespace App\DataTransferObjects\API\HRIS;

class EmployeeDto
{
    public function __construct(
        public readonly ?int $nik,
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
        $data = [];
        if (isset($response['data'])) {
            $data = $response['data'];
        }
        return new self(
            isset($data['nik']) ? $data['nik'] : null,
            isset($data['nama_karyawan']) ? $data['nama_karyawan'] : null,
            isset($data['costing']) ? $data['costing'] : null,
            isset($data['activity']) ? $data['activity'] : null,
            isset($data['tipe_kontrak']) ? $data['tipe_kontrak'] : null,
            isset($data['tgl_bergabung']) ? $data['tgl_bergabung'] : null,
            isset($data['tgl_pengangkatan']) ? $data['tgl_pengangkatan'] : null,
            isset($data['resign_date']) ? $data['resign_date'] : null,
            isset($data['tgl_naik_level']) ? $data['tgl_naik_level'] : null,
            isset($data['tgl_mcu_terakhir']) ? $data['tgl_mcu_terakhir'] : null,
            isset($data['email_perusahaan']) ? $data['email_perusahaan'] : null,
            isset($data['point_of_hire']) ? $data['point_of_hire'] : null,
            isset($data['point_of_leave']) ? $data['point_of_leave'] : null,
            isset($data['ring_clasification']) ? $data['ring_clasification'] : null,
            isset($data['tipe_mess']) ? $data['tipe_mess'] : null,
            isset($data['martial_status_id']) ? $data['martial_status_id'] : null,
            isset($data['status']) ? $data['status'] : null,
            PositionDto::fromResponseByEmployee($data),
        );
    }

    public static function formResponseMultiple(array $response): array
    {
        $data = [];
        if (isset($response['data'])) {
            $data = $response['data'];
        }
        $results = [];
        foreach ($data as $key => $value) {
            $results = array_merge($results, [new self(
                isset($value['nik']) ? $value['nik'] : null,
                isset($value['nama_karyawan']) ? $value['nama_karyawan'] : null,
                isset($value['costing']) ? $value['costing'] : null,
                isset($value['activity']) ? $value['activity'] : null,
                isset($value['tipe_kontrak']) ? $value['tipe_kontrak'] : null,
                isset($value['tgl_bergabung']) ? $value['tgl_bergabung'] : null,
                isset($value['tgl_pengangkatan']) ? $value['tgl_pengangkatan'] : null,
                isset($value['resign_date']) ? $value['resign_date'] : null,
                isset($value['tgl_naik_level']) ? $value['tgl_naik_level'] : null,
                isset($value['tgl_mcu_terakhir']) ? $value['tgl_mcu_terakhir'] : null,
                isset($value['email_perusahaan']) ? $value['email_perusahaan'] : null,
                isset($value['point_of_hire']) ? $value['point_of_hire'] : null,
                isset($value['point_of_leave']) ? $value['point_of_leave'] : null,
                isset($value['ring_clasification']) ? $value['ring_clasification'] : null,
                isset($value['tipe_mess']) ? $value['tipe_mess'] : null,
                isset($value['martial_status_id']) ? $value['martial_status_id'] : null,
                isset($value['status']) ? $value['status'] : null,
                PositionDto::fromResponseByEmployee($value),
            )]);
        }
        return $results;
    }
}
