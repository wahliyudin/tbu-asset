<?php

namespace App\Helpers;

use App\Enums\Cers\TypeBudget;
use App\Models\Cers\Cer;

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

    public static function hasBudgeted(?Cer $cer)
    {
        return $cer?->type_budget === TypeBudget::BUDGET;
    }

    public static function hasUnBudgeted(?Cer $cer)
    {
        return $cer?->type_budget === TypeBudget::UNBUDGET;
    }
}
