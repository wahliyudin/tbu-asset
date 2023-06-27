<?php

namespace App\Enums\Cers;

enum TypeBudget: string
{
    case BUDGET = 'budget';
    case UNBUDGET = 'unbudget';

    public function label()
    {
        return match ($this) {
            self::BUDGET => 'Budget',
            self::UNBUDGET => 'Unbudget',
        };
    }

    public function badge()
    {
        return match ($this) {
            self::BUDGET => '<span class="badge badge-success fs-7">' . self::BUDGET->label() . '</span>',
            self::UNBUDGET => '<span class="badge badge-danger fs-7">' . self::UNBUDGET->label() . '</span>',
        };
    }
}