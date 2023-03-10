<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    protected $roles = [
        'Super Admin',
        'Admin Manager',
        'CEO',
        'General Manager',
        'Sales Manager',
        'Stock Manager',
        'Finance Manager',
        'Hr Manager',
        'Customer Service Manager',
        'Agent',
        'Sales',
        'Employee',
        'Accountant',
        'Cashier',
        'Car Admin',
        'Car Driver',
        'Purchaser',
        'Stock Controller',
        'Store Keeper',

    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'employee']);
//            Role::create(['name' => $role, 'guard_name' => 'api']);
        }
    }
}
