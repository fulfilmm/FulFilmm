<?php

namespace Database\Seeders;

use App\Models\case_type;
use App\Models\Department;
use App\Models\Employee;
use App\Models\priority;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\status;
use App\Models\ThemeSetting;
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
//        ThemeSetting::create(['name'=>'White','link'=>'style.css','active'=>1]);
//        ThemeSetting::create(['name'=>'Dark','link'=>'darkstyle.css','active'=>0]);
//        ThemeSetting::create(['name'=>'Blue','link'=>'bluestyle.css','active'=>0]);
//        ThemeSetting::create(['name'=>'Purple','link'=>'purplestyle.css','active'=>0]);
//        ThemeSetting::create(['name'=>'Orange','link'=>'orangestyle.css','active'=>0]);
//        ThemeSetting::create(['name'=>'Maroon','link'=>'maroonstyle.css','active'=>0]);
//        products_tax::create(['name'=>'Tax Free','rate'=>0]);
//        products_tax::create(['name'=>'Personal Income Tax','rate'=>5]);
//        Department::create(['name'=>'Sale Department']);
//        Department::create(['name'=>'Customer Sevice Department']);
//        Department::create(['name'=>'Human Resource Management Department']);
//        Department::create(['name'=>'Finance Department']);
//        Department::create(['name'=>'Administration']);
//        Department::create(['name'=>'Marketing Department']);
//        products_category::create(['name'=>'Electronic','parent'=>1]);
//        products_category::create(['name'=>'Beauty','parent'=>1]);
//        products_category::create(['name'=>'Clothes','parent'=>1]);
//        $superadmin = Employee::updateOrCreate(
//            ['email' => 'admin@gmail.com'],
//            [    'empid'=>'Emp-00001',
//                'name' => 'SuperAdmin',
//                'department_id' => '1',
//                'phone' => '123123',
//                'email' => 'admin@gmail.com',
//                'work_phone' => 'asdasd',
//                'can_login' => true,
//                'password' => bcrypt('123123'),
//                'join_date' => '1999-10-20',
//            ]
//        );
//
//        $ticketadmin = Employee::updateOrCreate(
//            ['email' => 'thomascinpu@gmail.com'],
//            [
//                'empid'=>'Emp-00002',
//                'name' => 'TicketAdmin',
//                'department_id' => '1',
//                'phone' => '123123',
//                'email' => 'thomascinpu@gmail.com',
//                'work_phone' => 'asdasd',
//                'can_login' => true,
//                'password' => bcrypt('123123'),
//                'join_date' => '1999-10-20',
//            ]
//        );
//
//        $ticketagent = Employee::updateOrCreate(
//            ['email' => 'ma.sa.kitaite@gmail.com'],
//            [
//                'empid'=>'Emp-00003',
//                'name' => 'Agent',
//                'department_id' => '1',
//                'phone' => '123123',
//                'email' => 'ma.sa.kitaite@gmail.com',
//                'work_phone' => 'asdasd',
//                'can_login' => true,
//                'password' => bcrypt('123123'),
//                'join_date' => '1999-10-20',
//            ]
//        );
//
//        $ceo = Employee::updateOrCreate(
//            ['email' => 'wailinaung@gmail.com'],
//            [
//                'empid'=>'Emp-00004',
//                'name' => 'Ko Wai Lin(CEO)',
//                'department_id' => '1',
//                'phone' => '123123',
//                'email' => 'wailinaung@gmail.com',
//                'work_phone' => 'asdasd',
//                'can_login' => true,
//                'password' => bcrypt('123123'),
//                'join_date' => '1999-10-20',
//            ]
//        );
//
//        case_type::create(['name'=>'Problem One']);
//        case_type::create(['name'=>'Problem Two']);
//        case_type::create(['name'=>'Problem Three']);
//        status::create(['name'=>'New']);
//        status::create(['name'=>'Open']);
//        status::create(['name'=>'Close']);
//        status::create(['name'=>'Pending']);
//        status::create(['name'=>'In Progress']);
//        status::create(['name'=>'Complete']);
//        status::create(['name'=>'Overdue']);
//        priority::create(['priority'=>'Urgent','color'=>'danger','hours'=>0,'minutes'=>10,'seconds'=>0]);
//        priority::create(['priority'=>'High','color'=>'warning','hours'=>0,'minutes'=>30,'seconds'=>0]);
//        priority::create(['priority'=>'Medium','color'=>'info','hours'=>0,'minutes'=>40,'seconds'=>0]);
//        priority::create(['priority'=>'Low','color'=>'success','hours'=>0,'minutes'=>50,'seconds'=>0]);
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RoleAndPermissionSeeder::class,
        ]);



//        Employee::factory(100)->create();
        // \App\Models\User::factory(10)->create();
//        $superadmin->assignRole('Super Admin');
//        $ticketagent->assignRole('Agent');
//        $ticketadmin->assignRole('Ticket Admin');
//        $ceo->assignRole('CEO');


    }
}
