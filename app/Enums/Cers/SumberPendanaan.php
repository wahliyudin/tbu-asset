<?php

namespace App\Enums\Cers;

enum SumberPendanaan: string
{
    case LEASING = 'leasing';
    case BUKAN_LEASING = 'bukan_leasing';

    public function label()
    {
        return match ($this) {
            self::LEASING => 'Leasing',
            self::BUKAN_LEASING => 'Bukan Leasing',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::LEASING => '<span class="badge badge-success">' . self::LEASING->label() . '</span>',
            self::BUKAN_LEASING => '<span class="badge badge-primary">' . self::BUKAN_LEASING->label() . '</span>',
        };
    }
}