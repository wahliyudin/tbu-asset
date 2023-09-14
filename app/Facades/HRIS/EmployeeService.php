<?php

namespace App\Facades\HRIS;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Services\HRIS\EmployeeService
 *
 * @method static \Illuminate\Support\Collection all(array $attributes)
 *
 * @see \App\Services\HRIS\EmployeeService
 */
class EmployeeService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'employee_service';
    }
}
