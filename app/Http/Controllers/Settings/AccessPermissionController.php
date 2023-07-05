<?php

namespace App\Http\Controllers\Settings;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\DataTransferObjects\API\HRIS\EmployeeDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\API\HRIS\EmployeeService;
use App\Services\Settings\AccessPermissionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AccessPermissionController extends Controller
{
    public function __construct(
        protected EmployeeService $employeeService,
        protected AccessPermissionService $accessPermissionService,
    ) {
    }

    public function index()
    {
        return view('settings.access-permission.index');
    }

    public function datatable()
    {
        $niks = User::query()->pluck('nik')->toArray();
        return DataTables::of(EmployeeData::collection($this->employeeService->whereIn('nik', $niks)->getData()['data'])->toCollection())
            ->editColumn('nik', function (EmployeeData $employee) {
                return $employee->nik;
            })
            ->editColumn('nama_karyawan', function (EmployeeData $employee) {
                return $employee->nama_karyawan;
            })
            ->editColumn('action', function (EmployeeData $employee) {
                return view('settings.access-permission.action', ['employee' => $employee])->render();
            })
            ->make();
    }

    public function edit(User $user)
    {
        $user->load(['permissions:id']);
        $sidebars = $this->accessPermissionService->getSidebarAlreadyBuild($user);
        return view('settings.access-permission.edit', compact('user', 'sidebars'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $user->permissions()->sync($request->permissions);
            return to_route('settings.access-permission.index')
                ->with('success', 'Berhasil di update');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())
                ->withInput();
        }
    }
}