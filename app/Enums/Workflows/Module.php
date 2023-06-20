<?php

namespace App\Enums\Workflows;

enum Module: string
{
    case CER = 'CER';
    case TRANSFER = 'TRANSFER';
    case DISPOSE = 'DISPOSE';

    public function label()
    {
        return match ($this) {
            self::CER => 'Cer',
            self::TRANSFER => 'Transfer',
            self::DISPOSE => 'Dispose',
        };
    }

    public static function byValue(string $val): Module|null
    {
        return match ($val) {
            Module::CER->value => Module::CER,
            Module::TRANSFER->value => Module::TRANSFER,
            Module::DISPOSE->value => Module::DISPOSE,
            default => null
        };
    }
}
