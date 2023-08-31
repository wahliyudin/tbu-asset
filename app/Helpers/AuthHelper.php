<?php

namespace App\Helpers;

class AuthHelper
{
    public static function getNik()
    {
        return auth()->user()?->nik;
    }
}
