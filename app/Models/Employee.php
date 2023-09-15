<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_hris';
    protected $primaryKey = 'nik';

    protected $fillable = [
        'nik',
        'nama_karyawan',
        'position_id',
        'grade_id',
        'costing',
        'activity',
        'tipe_kontrak',
        'tgl_bergabung',
        'tgl_pengangkatan',
        'resign_date',
        'tgl_naik_level',
        'tgl_mcu_terakhir',
        'email_perusahaan',
        'point_of_hire',
        'point_of_leave',
        'ring_clasification',
        'tipe_mess',
        'martial_status_id',
        'status'
    ];


    public function position()
    {
        return $this->hasOne(Position::class, 'position_id', 'position_id');
    }
}
