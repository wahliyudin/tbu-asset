<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Divisi;

class Department extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_hris';
    protected $primaryKey = 'dept_id';

    protected $fillable = [
        'dept_id',
        'dept_code',
        'budget_dept_code',
        'department_name',
        'dept_head',
        'division_id',
        'project_id',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'division_id', 'division_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function deptHead()
    {
        return $this->belongsTo(Employee::class, 'dept_head', 'nik');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'dept_id', 'dept_id');
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Position::class, 'dept_id', 'position_id', 'dept_id', 'position_id');
    }
}