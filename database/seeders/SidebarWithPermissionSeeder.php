<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Sidebar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SidebarWithPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = config('sidebar-with-permission.sidebars');
        $mapPermission = collect(config('sidebar-with-permission.permissions_map'));
        foreach ($modules as $module) {
            $name = str($module['title'])->lower()->value();
            $parent = Sidebar::query()->create([
                'title' => $module['title'],
                'name' => str($name)->snake()->value(),
            ]);
            foreach ($module['child'] as $child) {
                $permis = [];
                $name = str($child['title'])->lower()->value();
                $sidebar = Sidebar::query()->create([
                    'title' => $child['title'],
                    'name' => str($name)->snake()->value(),
                    'parent_id' => $parent->getKey(),
                ]);
                if (isset($child['permissions'])) {
                    foreach (explode(',', $child['permissions']) as $p => $perm) {
                        $permissionValue = $mapPermission->get($perm);
                        $permission = Permission::query()->firstOrCreate([
                            'name' => str($name)->snake() . '_' . $permissionValue,
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($name),
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst($name),
                        ])->id;
                        $permissions[] = $permission;
                        $permis[] = $permission;
                        $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $name);
                    }
                    $sidebar->permissions()->sync($permis);
                }
            }
        }
    }
}
