<?php

namespace App\Http\Controllers\Settings;

use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\API\HRIS\EmployeeService;
use Yajra\DataTables\Facades\DataTables;

class AccessPermissionController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService
    ) {
    }

    public function index()
    {
        return view('settings.access-permission.index');
    }

    public function datatable()
    {
        $niks = User::query()->pluck('nik')->toArray();
        return DataTables::of(EmployeeDto::formResponseMultiple($this->employeeService->whereIn('nik', $niks)->getData()))
            ->editColumn('nik', function (EmployeeDto $employee) {
                return $employee->nik;
            })
            ->editColumn('nama_karyawan', function (EmployeeDto $employee) {
                return $employee->nama_karyawan;
            })
            ->editColumn('action', function (EmployeeDto $employee) {
                return view('settings.access-permission.action', ['employee' => $employee])->render();
            })
            ->make();
    }
}
