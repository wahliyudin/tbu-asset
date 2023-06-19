<?php

namespace App\Enums\Asset;

enum Status: string
{
    case ACTIVE = 'active';
    case IDLE = 'idle';
    case NON_ACTIVE = 'non_active'; // asset yang sudah di dispose

    public function label()
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::IDLE => 'Idle',
            self::NON_ACTIVE => 'Non Active',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::ACTIVE => '<span class="badge badge-success">' . self::ACTIVE->label() . '</span>',
            self::IDLE => '<span class="badge badge-info">' . self::IDLE->label() . '</span>',
            self::NON_ACTIVE => '<span class="badge badge-danger">' . self::NON_ACTIVE->label() . '</span>',
        };
    }
}
