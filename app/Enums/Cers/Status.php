<?php

namespace App\Enums\Cers;

enum Status: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
    case REJECT = 'reject';

    public function badge()
    {
        return match ($this) {
            self::OPEN => '<span class="badge badge-primary">' . self::OPEN . '</span>',
            self::CLOSE => '<span class="badge badge-warning">' . self::CLOSE . '</span>',
            self::REJECT => '<span class="badge badge-danger">' . self::REJECT . '</span>',
        };
    }
}
