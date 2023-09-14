<?php

namespace App\Services\Settings;

use App\DataTransferObjects\API\HRIS\EmployeeData;
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
        $result = $this->employeeService->whereIn('nik', $users->pluck('nik')->toArray())->getData();
        $data = EmployeeData::collection(isset($result['data']) ? $result['data'] : [])->toCollection();
        $user = $users->where('nik', 12345678)->first();
        $data->add(EmployeeData::from([
            'nik' => $user->nik,
            'nama_karyawan' => $user->name
        ]));
        return $data;
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
