<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CarbonHelper
{
    public static function dateFormatdFY(?string $date)
    {
        if (!static::isValidDate($date)) {
            return '-';
        }
        return Carbon::make($date)->translatedFormat('d F Y');
    }

    public static function dateFormatY(?string $date)
    {
        if (!static::isValidDate($date)) {
            return '-';
        }
        return Carbon::make($date)->format('Y');
    }

    public static function dateFormatYmd(?string $date)
    {
        if (!static::isValidDate($date)) {
            return '-';
        }
        return Carbon::make($date)->format('Y-m-d');
    }

    public static function isValidDate($date)
    {
        $validator = Validator::make(['date_value' => $date], [
            'date_value' => 'date',
        ]);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    public static function getRangeInCarbon(string $range, $hasWithDefault = true): array
    {
        $range = str($range)->explode(' - ');
        return [
            count($range) >= 2 ? Carbon::createFromFormat('m/d/Y', $range[0]) : ($hasWithDefault ? now()->setDay(21) : null),
            count($range) >= 2 ? Carbon::createFromFormat('m/d/Y', $range[1]) : ($hasWithDefault ? now()->setDay(20)->addMonth() : null)
        ];
    }

    public static function convertDate($date, $format = 'Y-m-d')
    {
        try {
            $dateFormats = [
                "d/m/Y",
                "Y-m-d",
                "Y/m/d",
                "d-m-Y",
                "m-d-Y",
                "m/d/Y",
                "d F Y",
            ];

            if (is_int($date)) {
                return Date::excelToDateTimeObject($date)->format($format);
            }
            foreach ($dateFormats as $dateFormat) {
                if (Carbon::hasFormat($date, $dateFormat)) {
                    return Carbon::createFromFormat($dateFormat, $date)->format($format);
                }
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
