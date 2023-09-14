<?php

namespace App\Services\HRIS;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\Models\Employee;

class EmployeeService
{
    public function all(array $attributes)
    {
        $employees = Employee::select($attributes)->get();
        return EmployeeData::collection($employees)->toCollection();
    }
}
