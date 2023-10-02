<?php

namespace App\Helpers;


class AuthHelper
{
    public static function getNik()
    {
        return auth()->user()?->nik;
    }

    public static function loadMissing(array|string $relations)
    {
        return auth()->user()?->loadMissing($relations);
    }
}
