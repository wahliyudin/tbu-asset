<?php

namespace App\Enums\Cers;

use App\Interfaces\EnumInterface;

enum Peruntukan: string implements EnumInterface
{
    case PENGGANTIAN = 'penggantian';
    case PENAMBAHAN = 'penambahan';
    case SAFETY = 'safety';

    public function label(): string
    {
        return match ($this) {
            self::PENGGANTIAN => 'Penggantian',
            self::PENAMBAHAN => 'Penambahan',
            self::SAFETY => 'Safety',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENGGANTIAN => '<span class="badge badge-primary fs-7">' . self::PENGGANTIAN->label() . '</span>',
            self::PENAMBAHAN => '<span class="badge badge-success fs-7">' . self::PENAMBAHAN->label() . '</span>',
            self::SAFETY => '<span class="badge badge-info fs-7">' . self::SAFETY->label() . '</span>',
        };
    }
}