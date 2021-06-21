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
        'activities', 'activity_tasks', 'comments', 'companies', 'customers', 'departments',
        'employees', 'groups', 'roles', 'permissions', 'assignments', 'assignment_tasks', 'projects','tickets','cases','priorities',
        'leads','deals','quotations'
    ];
    public function run()
    {
        //
        foreach ($this->permissions as $permission) {
            $this->createResourcePermissions($permission);
        }

        Permission::create(['name' => 'activities.acknowledge', 'display_name' => "Can acknowledge the activities", 'guard_name' => 'employee']);
        Permission::create(['name' => 'assignment_tasks.toggle', 'display_name' => 'Can toggle the assignment tasks status', "guard_name" => 'employee']);
        Permission::create(['name' => 'assignments.changeStatus', 'display_name' => 'Can change the assignment status', "guard_name" => 'employee']);
        Permission::create(['name' => 'inqueries.index', 'display_name' => "Can view all inquery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'inqueries.edit', 'display_name' => "Can Edit all inquery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'inqueries.update', 'display_name' => "Can Update all inquery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'inqueries.show', 'display_name' => "Can view Details inquery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'inqueries.destroy', 'display_name' => "Can Delete all inquery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.index', 'display_name' => "Can view all product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.create', 'display_name' => "Can Go to product create page", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.show', 'display_name' => "Can view Details product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.edit', 'display_name' => "Can  edit product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.update', 'display_name' => "Can update  product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.delete', 'display_name' => "Can delete  product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'duplicate', 'display_name' => "Can duplicate  product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'product.store', 'display_name' => "Can store product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tax.create', 'display_name' => "Can store tax", 'guard_name' => 'employee']);
        Permission::create(['name' => 'category.create', 'display_name' => "Can store category", 'guard_name' => 'employee']);
        Permission::create(['name' => 'action_confirm', 'display_name' => "Can change product status", 'guard_name' => 'employee']);
        Permission::create(['name' => 'change_status', 'display_name' => "Can change ticket status", 'guard_name' => 'employee']);
        Permission::create(['name' => 'postcomment', 'display_name' => "Can write comment for ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'addfollower', 'display_name' => "Can add more ticket follower", 'guard_name' => 'employee']);
        Permission::create(['name' => 'reassign', 'display_name' => "Can reassign ticket ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'piechart', 'display_name' => "Can view piechart report for ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'sender_info', 'display_name' => "Can view ticket sender information", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tagadd', 'display_name' => "Can add tag industry", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.myfollowed', 'display_name' => "Can view employee followed in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.comment', 'display_name' => "Can post comments in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.followed', 'display_name' => "Can add new follower in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'unfollowed', 'display_name' => "Can remove follower in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'convert.lead', 'display_name' => "Can change convert to lead status in inQuery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'workdone', 'display_name' => "If Lead Next step complete,can change workdone status ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'qualified', 'display_name' => "If lead qualified ,can change qualified status ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'deals.status_change', 'display_name' => "Can change sale stage in Deal", 'guard_name' => 'employee']);
        Permission::create(['name' => 'add_new_customer', 'display_name' => "Can add new customer while deal create", 'guard_name' => 'employee']);
        Permission::create(['name' => 'company_create', 'display_name' => "Can add new company while deal create", 'guard_name' => 'employee']);
        Permission::create(['name' => 'quotations.discard', 'display_name' => "Cancel quotation", 'guard_name' => 'employee']);
        Permission::create(['name' => 'orders.store', 'display_name' => "Can store new Order in quotation", 'guard_name' => 'employee']);
        Permission::create(['name' => 'orders.update', 'display_name' => "Can update  Order in quotation", 'guard_name' => 'employee']);
        Permission::create(['name' => 'orders.destroy', 'display_name' => "Cancel Order in quotation", 'guard_name' => 'employee']);
        Permission::create(['name' => 'quotation.sendemail', 'display_name' => "Can go to the quotation email create page", 'guard_name' => 'employee']);
        Permission::create(['name' => 'quotations.mail', 'display_name' => "Can send to customer the quotation email", 'guard_name' => 'employee']);
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
    }
}
