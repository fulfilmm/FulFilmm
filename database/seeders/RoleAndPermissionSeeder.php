<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    private $roles_and_permission = [
        'Employee' => [
            'resources' => [
                'employees', 'activities', 'activity_tasks', 'comments', 'customers', 'companies','groups'
            ]
        ],
        'Manager' => [
            'resources' => [
                'employees', 'activities', 'activity_tasks', 'comments', 'customers', 'companies', 'departments','groups'
            ]
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles_and_permission as $role => $permission_types) {
            $role = Role::where('name', $role)->first();
            foreach ($permission_types as $permission_type => $permissions) {
                if ($permission_type == 'resources') {
                    foreach ($permissions as $resource) {
                        $this->giveResourcePermission($role, $resource);
                    }
                }
            }
        }
    }

    public function giveResourcePermission($role, $resource): void
    {
        $role->givePermissionTo([
            $resource . '.index',
            $resource . '.create',
            $resource . '.store',
            $resource . '.edit',
            $resource . '.update',
            $resource . '.destroy',
        ]);
    }

}
