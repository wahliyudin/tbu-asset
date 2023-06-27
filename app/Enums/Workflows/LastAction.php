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

    public static function getByValue($val): self
    {
        return match ($val) {
            self::NOTTING->value => self::NOTTING,
            self::SUBMIT->value => self::SUBMIT,
            self::APPROV->value => self::APPROV,
            self::REJECT->value => self::REJECT,
            default => self::NOTTING,
        };
    }
}
