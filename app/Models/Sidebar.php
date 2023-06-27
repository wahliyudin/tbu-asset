<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'parent_id'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function childs()
    {
        return $this->hasMany(Sidebar::class, 'parent_id');
    }
}
