<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_hris';
    protected $table = "divisions";
    protected $primaryKey = 'division_id';

    protected $fillable = [
        'division_id',
        'division_name',
        'division_head',
    ];

    public function department()
    {
        return $this->hasMany(Department::class);
    }

    public function divisionHead()
    {
        return $this->belongsTo(Employee::class, 'division_head', 'nik');
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Position::class, 'division_id', 'position_id', 'division_id', 'position_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'division_id', 'division_id');
    }
}