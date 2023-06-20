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
}
