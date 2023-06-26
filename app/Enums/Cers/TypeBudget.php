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
            self::BUDGET => '<span class="badge badge-success">' . self::BUDGET->label() . '</span>',
            self::UNBUDGET => '<span class="badge badge-primary">' . self::UNBUDGET->label() . '</span>',
        };
    }
}
