<?php

namespace App\Enums\Workflows;

enum LastAction: int
{
    case NOTTING = 1;
    case SUBMIT = 2;
    case APPROV = 3;
    case REJECT = 4;

    public function label()
    {
        return match ($this) {
            self::SUBMIT => 'Submitted',
            self::APPROV => 'Approved',
            self::REJECT => 'Rejected',
            self::NOTTING => 'Notting',
        };
    }
}