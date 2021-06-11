<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\priority;
use App\Models\status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Department::factory()
            ->times(5)
            ->create();

        $employee = Employee::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'department_id' => '1',
                'phone' => '123123',
                'email' => 'admin@gmail.com',
                'work_phone' => 'asdasd',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        status::create(['name'=>'New']);
        status::create(['name'=>'Open']);
        status::create(['name'=>'Close']);
        status::create(['name'=>'Pending']);
        status::create(['name'=>'Progress']);
        status::create(['name'=>'Complete']);
        priority::create(['priority'=>'Urgent','color'=>'danger','hours'=>'0','minutes'=>0,'seconds'=>0]);
        priority::create(['priority'=>'High','color'=>'warning','hours'=>'0','minutes'=>0,'seconds'=>0]);
        priority::create(['priority'=>'Medium','color'=>'info','hours'=>'0','minutes'=>0,'seconds'=>0]);
        priority::create(['priority'=>'Low','color'=>'success','hours'=>'0','minutes'=>0,'seconds'=>0]);
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleAndPermissionSeeder::class,
        ]);

        $employee->assignRole('Manager');

        Employee::factory(10)->create();
        // \App\Models\User::factory(10)->create();


    }
}
