<?php

namespace App\Enums\Settings;

enum Approval: string
{
    case ATASAN_LANGSUNG = 'ATASAN_LANGSUNG';
    case DIRECTOR = 'DIRECTOR';
    case GENERAL_MANAGER = 'GENERAL_MANAGER';
    case DEPARTMENT_HEAD = 'DEPARTMENT_HEAD';
    case PROJECT_OWNER = 'PROJECT_OWNER';
    case FINANCE = 'FINANCE';
    case HCA = 'HCA';
    case GENERAL_MANAGER_OPERATION = 'GENERAL_MANAGER_OPERATION';
    case OTHER = 'OTHER';

    public function valueByHRIS()
    {
        return match ($this) {
            self::ATASAN_LANGSUNG => 1,
            self::DIRECTOR => 2,
            self::GENERAL_MANAGER => 3,
            self::DEPARTMENT_HEAD => 4,
            self::PROJECT_OWNER => 5,
            self::FINANCE => 6,
            self::HCA => 7,
            self::GENERAL_MANAGER_OPERATION => 8,
            self::OTHER => 9,
        };
    }

    public function label()
    {
        return match ($this) {
            self::ATASAN_LANGSUNG => 'Atasan Langsung',
            self::DIRECTOR => 'Director',
            self::GENERAL_MANAGER => 'General Manager',
            self::DEPARTMENT_HEAD => 'Department Head',
            self::PROJECT_OWNER => 'Project Owner',
            self::FINANCE => 'Finance',
            self::HCA => 'HCA',
            self::GENERAL_MANAGER_OPERATION => 'General Manager Operation',
            self::OTHER => 'Other',
        };
    }

    public static function byValue(string $val): self|null
    {
        return match ($val) {
            self::ATASAN_LANGSUNG->value => self::ATASAN_LANGSUNG,
            self::DIRECTOR->value => self::DIRECTOR,
            self::GENERAL_MANAGER->value => self::GENERAL_MANAGER,
            self::DEPARTMENT_HEAD->value => self::DEPARTMENT_HEAD,
            self::PROJECT_OWNER->value => self::PROJECT_OWNER,
            self::FINANCE->value => self::FINANCE,
            self::HCA->value => self::HCA,
            self::GENERAL_MANAGER_OPERATION->value => self::GENERAL_MANAGER_OPERATION,
            self::OTHER->value => self::OTHER,
            default => null
        };
    }
}
