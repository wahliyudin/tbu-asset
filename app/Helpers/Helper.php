<?php

namespace App\Helpers;

use App\DataTransferObjects\Cers\CerData;
use App\Enums\Cers\TypeBudget;

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

    public static function hasBudgeted(?CerData $cer)
    {
        return $cer?->type_budget === TypeBudget::BUDGET;
    }

    public static function hasUnBudgeted(?CerData $cer)
    {
        return $cer?->type_budget === TypeBudget::UNBUDGET;
    }

    public static function getRomawi(int $month)
    {
        switch ($month) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
