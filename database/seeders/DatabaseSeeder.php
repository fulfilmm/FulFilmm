<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\case_type;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\OfficeBranch;
use App\Models\priority;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\status;
use App\Models\ThemeSetting;
use App\Models\TransactionCategory;
use App\Models\Warehouse;
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
        ThemeSetting::create(['name'=>'White','link'=>'style.css','active'=>1]);
        ThemeSetting::create(['name'=>'Dark','link'=>'darkstyle.css','active'=>0]);
        ThemeSetting::create(['name'=>'Blue','link'=>'bluestyle.css','active'=>0]);
        ThemeSetting::create(['name'=>'Purple','link'=>'purplestyle.css','active'=>0]);
        ThemeSetting::create(['name'=>'Orange','link'=>'orangestyle.css','active'=>0]);
        ThemeSetting::create(['name'=>'Maroon','link'=>'maroonstyle.css','active'=>0]);
        $branch=OfficeBranch::create(['name'=>'Head Office','address'=>'Yangon','type'=>'Branch']);
        Warehouse::create(['warehouse_id'=>'WH-001','name'=>'Main Warehouse','address'=>'Yangon','description'=>'Main Warehouse','branch_id'=>$branch->id]);
        products_tax::create(['name'=>'Tax Free','rate'=>0]);
        products_tax::create(['name'=>'Personal Income Tax','rate'=>5]);
        Department::create(['name'=>'Sale Department']);
        Department::create(['name'=>'Customer Sevice Department']);
        Department::create(['name'=>'Human Resource Management Department']);
        Department::create(['name'=>'Finance Department']);
        Department::create(['name'=>'Administration']);
        Department::create(['name'=>'Marketing Department']);
        Department::create(['name'=>'Warehouse Department']);
        Department::create(['name'=>'CEO Office']);
        Department::create(['name'=>'MD Office']);
        Department::create(['name'=>'Procurement']);
        products_category::create(['name'=>'Electronic','parent'=>1]);
        products_category::create(['name'=>'Beauty','parent'=>1]);
        products_category::create(['name'=>'Clothes','parent'=>1]);
        TransactionCategory::create(['name'=>'Invoice','type'=>1]);
        TransactionCategory::create(['name'=>'Bill','type'=>0]);
        TransactionCategory::create(['name'=>'General Income','type'=>1]);
        TransactionCategory::create(['name'=>'General Expense','type'=>0]);
        $cuscom=Company::create(['name'=>'Customer Company','email'=>'oranger@gmail.com','phone'=>'09786543278','address'=>'Yangon','business_type'=>'Trading']);
        $supcom=Company::create(['name'=>'Supplier Company','email'=>'supplier@gmail.com','phone'=>'09786543278','address'=>'Yangon','business_type'=>'Trading']);
        Account::create(['account_no'=>'0001','name'=>'Main Account','number'=>'2002865657','currency'=>'MMK','enabled'=>1,'branch_id'=>$branch->id]);
        $superadmin = Employee::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [    'empid'=>'Emp-00001',
                'name' => 'Super Admin',
                'department_id' => '1',
                'phone' => '098786546788',
                'email' => 'admin@gmail.com',
                'work_phone' => '098758654',
                'can_login' => true,
                'office_branch_id'=>$branch->id,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        $CEO = Employee::updateOrCreate(
            ['email' => 'wailinaung.mandalay@gmail.com'],
            [    'empid'=>'Emp-00002',
                'name' => 'Ko Wai (CEO)',
                'department_id' => '1',
                'phone' => '09997836738',
                'email' =>'wailinaung.mandalay@gmail.com',
                'work_phone' => '098764656778',
                'can_login' => true,
                'office_branch_id'=>$branch->id,
                'password' => bcrypt('123123'),
                'join_date' => '1999-10-20',
            ]
        );
        Customer::create(['customer_id'=>'CUS-00001', 'name'=>'Mr Chris', 'phone'=>'09867766767', 'email'=>'chris@gmail.com', 'company_id'=>$cuscom->id,'emp_id'=>$superadmin->id,'customer_type'=>'Customer','gender'=>'Male']);
        Customer::create(['customer_id'=>'CUS-00002', 'name'=>'Miss Ma Sa', 'phone'=>'0925986767', 'email'=>'ma.sa.kitaite@gmail.com', 'company_id'=>$supcom->id,'emp_id'=>$superadmin->id,'customer_type'=>'Supplier','gender'=>'Female']);
        case_type::create(['name'=>'Problem One']);
        case_type::create(['name'=>'Problem Two']);
        case_type::create(['name'=>'Problem Three']);
        status::create(['name'=>'New']);
        status::create(['name'=>'Open']);
        status::create(['name'=>'Close']);
        status::create(['name'=>'Pending']);
        status::create(['name'=>'In Progress']);
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



//        Employee::factory(100)->create();
        // \App\Models\User::factory(10)->create();
        $superadmin->assignRole('Super Admin');
        $CEO->assignRole('CEO');



    }
}
