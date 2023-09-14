<?php

namespace App\Services\Settings;

use App\DataTransferObjects\API\HRIS\EmployeeData;
use App\Models\Employee;
use App\Models\Sidebar;
use App\Models\User;
use App\Services\API\HRIS\EmployeeService;

class AccessPermissionService
{
    public function __construct(
        protected EmployeeService $employeeService,
    ) {
    }

    public function datatable()
    {
        $users = User::select(['nik', 'name'])->get();
        $employees = Employee::select(['nik', 'nama_karyawan'])
            ->whereIn('nik', $users->pluck('nik'))
            ->get();
        $admin = $users->where('nik', 12345678)->first();
        $employees->add(new Employee([
            'nik' => $admin->nik,
            'nama_karyawan' => $admin->name,
        ]));
        return EmployeeData::collection($employees)->toCollection();
    }

    public function getSidebarAlreadyBuild(User $user)
    {
        $sidebars = Sidebar::query()->with('permissions:id,name')->get();
        return $this->build($sidebars, $user);
    }

    private function build($sidebars, $user, $parent = null)
    {
        $results = [];
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $parent) {
                $children = [];
                if ($this->hasChild($sidebars, $sidebar->id)) {
                    $children = array_merge($children, $this->build($sidebars, $user, $sidebar->id));
                }
                $sidebar = $this->attributeAdditional($sidebar, $user);
                array_push($results, [
                    'title' => $sidebar->title,
                    'name' => $sidebar->name,
                    'permissions' => $sidebar->permissions,
                    'children' => $children
                ]);
            }
        }
        return $results;
    }

    private function hasChild($sidebars, $sidebar_id)
    {
        foreach ($sidebars as $sidebar) {
            if ($sidebar->parent_id == $sidebar_id) {
                return true;
            }
        }
        return false;
    }

    private function attributeAdditional(Sidebar $sidebar, User $user)
    {
        foreach ($sidebar->permissions as $permission) {
            $permission->assigned = $user->permissions
                ->pluck('id')
                ->contains($permission->id);
            $permissionsMap = config('sidebar-with-permission.permissions_map');
            foreach ($permissionsMap as $key => $val) {
                if (str($permission->name)->contains($val)) {
                    $permission->display = str($val)->ucfirst();
                    $permission->input_name = $val . "[]";
                }
            }
        }
        return $sidebar;
    }
}
