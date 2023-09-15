<?php

namespace App\Enums\Cers;

enum StatusTXIS: int
{
    case DRAFT = 0;
    case OPEN = 1;
    case CLOSE = 2;

    public static function byValue($val)
    {
        return match ($val) {
            self::DRAFT->value => self::DRAFT,
            self::OPEN->value => self::OPEN,
            self::CLOSE->value => self::CLOSE,
            default => null
        };
    }

    public function label()
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::OPEN => 'Open',
            self::CLOSE => 'Close',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::DRAFT => '<span class="badge badge-warning fs-7">' . self::DRAFT->label() . '</span>',
            self::OPEN => '<span class="badge badge-success fs-7">' . self::OPEN->label() . '</span>',
            self::CLOSE => '<span class="badge badge-danger fs-7">' . self::CLOSE->label() . '</span>',
        };
    }
}
