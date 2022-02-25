<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    private $roles_and_permission = [
        'Employee' => [
            'resources' => ['comments', 'customers', 'companies'],
            'others' => [
                'employees.show',
            ]
        ],
        'General Manager' => [
            'resources' => [
                'employees','comments', 'customers', 'companies', 'departments', 'groups', 'roles', 'permissions'],

        ],
         'Customer Service Manager' => [
            'resources' => [
                'employees', 'tickets','cases','priorities','comments', 'customers', 'companies', 'departments', 'groups',
            ],
            'others' => [
                'piechart'
            ]
        ],
        'Agent' => [
            'resources' => [
                'tickets','comments', 'customers', 'companies', 'departments', 'groups',
            ],
            'others' => [
                'employees.show',
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
                } else {
                    foreach ($permissions as $permission) {
                        $role->givePermissionTo($permission);
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
            $resource . '.show',
            $resource . '.edit',
            $resource . '.update',
            $resource . '.destroy',
            $resource . '.cards'
        ]);
    }
}
