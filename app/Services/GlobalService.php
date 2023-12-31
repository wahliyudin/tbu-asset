<?php

namespace App\Services;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\HRIS\ProjectData;
use App\DataTransferObjects\API\TXIS\VendorData;
use App\Services\API\HRIS\EmployeeService;
use App\Services\API\HRIS\ProjectService;
use App\Services\API\TXIS\BudgetService;
use App\Services\API\TXIS\VendorService;

class GlobalService
{
    public static function getEmployee($nik = null, $hasDefault = false): array
    {
        $token = UserService::getAdministrator()?->oatuhToken?->access_token;
        $nik = $hasDefault ? (auth()->user()?->nik ?? $nik) : $nik;
        $employee = (new EmployeeService)->setToken($token)->getByNik($nik);
        return isset($employee['data']) ? $employee['data'] : [];
    }

    public static function getBudgetByCode($code): array
    {
        try {
            $budget = (new BudgetService)->getByCode($code);
            return isset($budget['data']) ? $budget['data'] : [];
        } catch (\Throwable $th) {
            return [];
        }
    }

    public static function getEmployees(array $attributes)
    {
        $employee = (new EmployeeService)->getData();
        return EmployeeData::collection(isset($employee['data']) ? $employee['data'] : [])->only(...$attributes);
    }

    public static function getEmployeeByNamaKaryawan(?string $namaKaryawan): EmployeeData
    {
        $employee = (new EmployeeService)->whereIn('nama_karyawan', [trim($namaKaryawan)])->first();
        return EmployeeData::from(isset($employee['data']) ? $employee['data'] : []);
    }

    public static function getProjects()
    {
        $project = (new ProjectService)->all();
        return ProjectData::collection(isset($project['data']) ? $project['data'] : [])->toCollection();
    }

    public static function getProject($id)
    {
        $project = (new ProjectService)->getById($id);
        return ProjectData::from(isset($project['data']) ? $project['data'] : []);
    }

    public static function vendorForSelect()
    {
        return VendorData::collection((new VendorService())->all()['data'])
            ->only('vendorid', 'vendorname');
    }

    public static function vendorById($id)
    {
        return VendorData::from((new VendorService)->getById($id));
    }
}
