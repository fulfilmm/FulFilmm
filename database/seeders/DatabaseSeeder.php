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
            ->times(10)
            ->create();
        Employee::factory()
            ->time(10)
            ->create();
        // \App\Models\User::factory(10)->create();
    }
}
