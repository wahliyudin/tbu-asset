<?php

namespace App\Helpers;

class Helper
{
    public function resetToNumber(string $val): int
    {
        return (int) str($val)
            ->replace('Rp. ', '')
            ->replace('.', '')
            ->value();
    }

    public static function clearUrl(string $url): string
    {
        return str($url)->replace('//', '/')->value();
    }
}