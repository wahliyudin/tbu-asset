<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_hris';
    protected $primaryKey = 'position_id';

    protected $fillable = [
        'position_id',
        'position_name',
        'project_id',
        'division_id',
        'dept_id',
        'jabatan_atasan_langsung',
        'jabatan_atasan_tidak_langsung',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'division_id', 'division_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }

    public function atasan_langsung()
    {
        return $this->belongsTo(Position::class, 'jabatan_atasan_langsung', 'position_id');
    }

    public function atasan_tidak_langsung()
    {
        return $this->belongsTo(Position::class, 'jabatan_atasan_tidak_langsung', 'position_id');
    }
}
