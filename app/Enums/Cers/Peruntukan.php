<?php

namespace App\Enums\Cers;

enum Peruntukan: string
{
    case PENGGANTIAN = 'penggantian';
    case PENAMBAHAN = 'penambahan';
    case SAFETY = 'safety';

    public function badge()
    {
        return match ($this) {
            self::PENGGANTIAN => '<span class="badge badge-primary">' . self::PENGGANTIAN . '</span>',
            self::PENAMBAHAN => '<span class="badge badge-success">' . self::PENAMBAHAN . '</span>',
            self::SAFETY => '<span class="badge badge-info">' . self::SAFETY . '</span>',
        };
    }
}
