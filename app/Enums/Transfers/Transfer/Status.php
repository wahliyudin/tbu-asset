<?php

namespace App\Enums\Transfers\Transfer;

enum Status: string
{
    case PENDING = 'pending';
    case PROCESS = 'process';
    case RECEIVED = 'received';

    public function label()
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESS => 'Delivery Process',
            self::RECEIVED => 'Received',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::PENDING => '<span class="badge badge-warning">' . self::PENDING->label() . '</span>',
            self::PROCESS => '<span class="badge badge-info">' . self::PROCESS->label() . '</span>',
            self::RECEIVED => '<span class="badge badge-success">' . self::RECEIVED->label() . '</span>',
        };
    }
}
