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
        'approvals','cases','comments','companysettings', 'companies', 'customers','deals','departments',
        'employees','groups','invoices','leads','meetings','minutes',
        'products','permissions','priorities','quotations','quotation_items','roles','rooms','senders','tickets','accounts'
    ];
    public function run()
    {
        //
        foreach ($this->permissions as $permission) {
            $this->createResourcePermissions($permission);
        }

         //Products
        Permission::create(['name' => 'duplicate', 'display_name' => "Can duplicate  product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tax.create', 'display_name' => "Can store tax", 'guard_name' => 'employee']);
        Permission::create(['name' => 'category.create', 'display_name' => "Can store category", 'guard_name' => 'employee']);
        Permission::create(['name' => 'action_confirm', 'display_name' => "Can change product status", 'guard_name' => 'employee']);
        //ticket
        Permission::create(['name' => 'change_status', 'display_name' => "Can change ticket status", 'guard_name' => 'employee']);
        Permission::create(['name' => 'reassign', 'display_name' => "Can reassign ticket ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'piechart', 'display_name' => "Can view piechart report for ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tickets.assign', 'display_name' => "Can assign Ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'priority.change', 'display_name' => "Can change Priority", 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.index', 'display_name' => "Ticket Request index", 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.show', 'display_name' => "Ticket Request Show", 'guard_name' => 'employee']);
        Permission::create(['name' => 'openticket', 'display_name' => "Open Ticket ", 'guard_name' => 'employee']);

        //lead
        Permission::create(['name' => 'leads.myfollowed', 'display_name' => "Can view employee followed in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'qualified', 'display_name' => "If lead qualified ,can change qualified status ", 'guard_name' => 'employee']);
        //deal
        //invoice
        Permission::create(['name' => 'invoice.sendmail', 'display_name' => "Can go to invoices email preparation view page", 'guard_name' => 'employee']);
        Permission::create(['name' => 'send', 'display_name' => "Can send invoice mail", 'guard_name' => 'employee']);
        Permission::create(['name' => 'invoice.statuschange', 'display_name' => "Can change invoice status", 'guard_name' => 'employee']);
        //approval
        Permission::create(['name' => 'request.me', 'display_name' => "Can view employee approval request to login employee", 'guard_name' => 'employee']);
       //minutes
        Permission::create(['name' => 'assign.minutes', 'display_name' => "Can assign  minutes  in meeting show", 'guard_name' => 'employee']);
        //setting
        Permission::create(['name' => 'companysettings.prefix', 'display_name' => 'Prefix Setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'companysetting.setprefix', 'display_name' => 'Update Prefix Setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'emailsetting', 'display_name' => 'Email Server setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'mail.setting', 'display_name' => 'Update Email Server setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'booking', 'display_name' => 'Room Booking index', "guard_name" => 'employee']);
        Permission::create(['name' => 'savebooking', 'display_name' => 'Room Booking store', "guard_name" => 'employee']);
        Permission::create(['name' => 'cancel', 'display_name' => 'Room Booking cancel', "guard_name" => 'employee']);
        Permission::create(['name' => 'income.create', 'display_name' => 'Revenue Add Form', "guard_name" => 'employee']);
        Permission::create(['name' => 'revenue', 'display_name' => 'Revenue List View', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense', 'display_name' => 'Expense List View', "guard_name" => 'employee']);
        Permission::create(['name' => 'income.store', 'display_name' => 'Add New Revenue', "guard_name" => 'employee']);
        Permission::create(['name' => 'transactions.index', 'display_name' => 'All Transaction List', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense.create', 'display_name' => 'Expense Create Form', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense.store', 'display_name' => 'Add New Expense', "guard_name" => 'employee']);
        Permission::create(['name' => 'transactions.show', 'display_name' => 'Transaction Detail View', "guard_name" => 'employee']);
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
        Permission::create(['name' => $resource . '.cards', 'display_name' => "View the $resource card", 'guard_name' => 'employee']);

    }
}
