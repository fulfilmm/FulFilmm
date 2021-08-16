<?php

namespace Database\Seeders;

use App\Models\case_type;
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

        $superadmin = Employee::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'SuperAdmin',
                'department_id' => '1',
                'phone' => '123123',
                'email' => 'admin@gmail.com',
                'work_phone' => 'asdasd',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        $superadmin->assignRole('Super Admin');
        $ticketadmin = Employee::updateOrCreate(
            ['email' => 'thomascinpu@gmail.com'],
            [
                'name' => 'TicketAdmin',
                'department_id' => '1',
                'phone' => '123123',
                'email' => 'admin@gmail.com',
                'work_phone' => 'asdasd',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        $ticketadmin->assignRole('Ticket Admin');
        $ticketagent = Employee::updateOrCreate(
            ['email' => 'thomascinpu@gmail.com'],
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
        $ticketagent->assignRole('Agent');
        $ceo = Employee::updateOrCreate(
            ['email' => 'wailinaung@gmail.com'],
            [
                'name' => 'Ko Wai Lin(CEO)',
                'department_id' => '1',
                'phone' => '123123',
                'email' => 'admin@gmail.com',
                'work_phone' => 'asdasd',
                'can_login' => true,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        $ceo->assignRole('CEO');
        case_type::create(['name'=>'Problem One']);
        case_type::create(['name'=>'Problem Two']);
        case_type::create(['name'=>'Problem Three']);
        status::create(['name'=>'New']);
        status::create(['name'=>'Open']);
        status::create(['name'=>'Close']);
        status::create(['name'=>'Pending']);
        status::create(['name'=>'Progress']);
        status::create(['name'=>'Complete']);
        status::create(['name'=>'Overdue']);
        priority::create(['priority'=>'Urgent','color'=>'danger','hours'=>0,'minutes'=>10,'seconds'=>0]);
        priority::create(['priority'=>'High','color'=>'warning','hours'=>0,'minutes'=>30,'seconds'=>0]);
        priority::create(['priority'=>'Medium','color'=>'info','hours'=>0,'minutes'=>40,'seconds'=>0]);
        priority::create(['priority'=>'Low','color'=>'success','hours'=>0,'minutes'=>50,'seconds'=>0]);
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleAndPermissionSeeder::class,
        ]);



        Employee::factory(10)->create();
        // \App\Models\User::factory(10)->create();


    }
}
