<?php

namespace App\Enums\Disposes\Dispose;

use App\Interfaces\EnumInterface;

enum Status: string implements EnumInterface
{
    case OPEN = 'open';
    case CLOSE = 'close';
    case REJECT = 'reject';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::CLOSE => 'Close',
            self::REJECT => 'Reject',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::OPEN => '<span class="badge badge-primary fs-7">' . self::OPEN->label() . '</span>',
            self::CLOSE => '<span class="badge badge-warning fs-7">' . self::CLOSE->label() . '</span>',
            self::REJECT => '<span class="badge badge-danger fs-7">' . self::REJECT->label() . '</span>',
        };
    }
}
