<?php

namespace App\Enums\Workflows;

enum Module: string
{
    case CER_HO = 'CER HO';
    case CER_SITE = 'CER SITE';
    case TRANSFER = 'TRANSFER';
    case DISPOSE = 'DISPOSE';

    public function label()
    {
        return match ($this) {
            self::CER_HO => 'Cer HO',
            self::CER_SITE => 'Cer SITE',
            self::TRANSFER => 'Transfer',
            self::DISPOSE => 'Dispose',
        };
    }

    public static function byValue(string $val): Module|null
    {
        return match ($val) {
            Module::CER_HO->value => Module::CER_HO,
            Module::CER_SITE->value => Module::CER_SITE,
            Module::TRANSFER->value => Module::TRANSFER,
            Module::DISPOSE->value => Module::DISPOSE,
            default => null
        };
    }
}
