<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_hris';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_id',
        'project',
        'project_prefix',
        'location',
        'location_prefix',
        'pjo',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'pjo', 'nik');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'project_id', 'project_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'project_id', 'project_id');
    }
}
