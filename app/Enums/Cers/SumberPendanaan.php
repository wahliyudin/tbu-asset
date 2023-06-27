<?php

namespace App\Enums\Cers;

use App\Interfaces\EnumInterface;

enum SumberPendanaan: string implements EnumInterface
{
    case LEASING = 'leasing';
    case BUKAN_LEASING = 'bukan_leasing';

    public function label(): string
    {
        return match ($this) {
            self::LEASING => 'Leasing',
            self::BUKAN_LEASING => 'Bukan Leasing',
            default => 'Not Defined',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::LEASING => '<span class="badge badge-success fs-7">' . self::LEASING->label() . '</span>',
            self::BUKAN_LEASING => '<span class="badge badge-primary fs-7">' . self::BUKAN_LEASING->label() . '</span>',
            default => 'Not Defined',
        };
    }
}