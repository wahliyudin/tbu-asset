<?php

namespace App\Services;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\TXIS\BudgetService;

class GlobalService
{
    public static function getEmployee($nik = null, $hasDefault = false): array
    {
        $token = UserService::getAdministrator()?->oatuhToken?->access_token;
        $nik = $hasDefault ? auth()->user()->nik : $nik;
        $employee = (new EmployeeService)->setToken(auth()->check() ? null : $token)->getByNik($nik);
        return isset($employee['data']) ? $employee['data'] : [];
    }

    public static function getBudgetByCode($code): array
    {
        $budget = (new BudgetService)->getByCode($code);
        return isset($budget['data']) ? $budget['data'] : [];
    }

    public static function getEmployees(array $attributes)
    {
        return EmployeeData::collection((new EmployeeService)->getData()['data'])->only(...$attributes);
    }
}