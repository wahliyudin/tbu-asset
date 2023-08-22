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

    public static function resetRupiah(?string $val): int
    {
        return (int) str($val)
            ->replace('Rp. ', '')
            ->replace('.', '')
            ->value();
    }

    public static function formatRupiah($val, $withPrefix = false)
    {
        $result = number_format($val, 0, ',', '.');
        return $withPrefix ? "Rp. $result" : $result;
    }

    public static function clearUrl(string $url): string
    {
        return str($url)->replace('//', '/')->value();
    }
}
