<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct()
    {
    }

    public function all()
    {
    }

    public static function getAdministrator()
    {
        return User::query()->where('email', 'administrator@tbu.co.id')->first();
    }
}
