<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
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

        Employee::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'pkk',
                'department_id' => '1',
                'phone' => '123123',
                'email' => 'admin@gmail.com',
                'work_phone' => 'asdasd',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        $this->call([
            PermissionSeeder::class,

        ]);
        // \App\Models\User::factory(10)->create();
    }
}
