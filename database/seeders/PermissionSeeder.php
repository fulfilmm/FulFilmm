<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $permissions = [
        'activities', 'activity_tasks', 'comments', 'companies', 'customers', 'departments',
        'employees', 'groups', 'roles', 'permissions'
    ];
    public function run()
    {
        //
        foreach ($this->permissions as $permission) {
            $this->createResourcePermissions($permission);
        }

        Permission::create(['name' => 'activities.acknowledge', 'display_name' => "Can acknowledge the activities", 'guard_name' => 'employee']);
    }

    private function createResourcePermissions($resource)
    {
        Permission::create(['name' => $resource . '.index', 'display_name' => "View all $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.create', 'display_name' => "Show create form for $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.store', 'display_name' => "Store the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.show', 'display_name' => "View detail of the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.edit', 'display_name' => "Show Edit form for the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.update', 'display_name' => "Update the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.destroy', 'display_name' => "Delete the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.export', 'display_name' => "Export the $resource", 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.import', 'display_name' => "Import the $resource", 'guard_name' => 'employee']);
    }
}
