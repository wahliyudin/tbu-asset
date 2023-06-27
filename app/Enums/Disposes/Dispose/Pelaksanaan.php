<?php

namespace App\Enums\Disposes\Dispose;

use App\Interfaces\EnumInterface;

enum Pelaksanaan: string implements EnumInterface
{
    case PENJUALAN = 'penjualan';
    case DONASI = 'donasi';
    case PEMUSNAHAN = 'pemusnahan';

    public function label(): string
    {
        return match ($this) {
            self::PENJUALAN => 'Penjualan',
            self::DONASI => 'Donasi',
            self::PEMUSNAHAN => 'Pemusnahan',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENJUALAN => '<span class="badge badge-primary fs-7">' . self::PENJUALAN->label() . '</span>',
            self::DONASI => '<span class="badge badge-success fs-7">' . self::DONASI->label() . '</span>',
            self::PEMUSNAHAN => '<span class="badge badge-info fs-7">' . self::PEMUSNAHAN->label() . '</span>',
        };
    }
}
