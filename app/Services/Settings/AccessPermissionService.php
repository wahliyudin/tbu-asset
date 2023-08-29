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
            if (str($permission->name)->contains('create')) {
                $permission->display = 'Create';
                $permission->input_name = 'create[]';
            } elseif (str($permission->name)->contains('read')) {
                $permission->display = 'View';
                $permission->input_name = 'view[]';
            } elseif (str($permission->name)->contains('update')) {
                $permission->display = 'Update';
                $permission->input_name = 'update[]';
            } elseif (str($permission->name)->contains('delete')) {
                $permission->display = 'Delete';
                $permission->input_name = 'delete[]';
            } elseif (str($permission->name)->contains('approv')) {
                $permission->display = 'Approv';
                $permission->input_name = 'approv[]';
            } elseif (str($permission->name)->contains('reject')) {
                $permission->display = 'Reject';
                $permission->input_name = 'reject[]';
            } elseif (str($permission->name)->contains('list')) {
                $permission->display = 'List';
                $permission->input_name = 'list[]';
            }
        }
        return $sidebar;
    }
}
