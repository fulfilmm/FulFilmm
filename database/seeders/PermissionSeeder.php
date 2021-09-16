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
        'activities','activity_tasks', 'comments', 'companies', 'customers', 'departments',
        'employees','roles', 'permissions', 'assignments', 'assignment_tasks', 'projects','tickets','cases','priorities',
        'leads','deals','quotations','invoices','invoice_items','approvals','meetings','minutes','inqueries','products','orders', 'groups','project_tasks',
        'companysettings','senders','rooms',
    ];
    public function run()
    {
        //
        foreach ($this->permissions as $permission) {
            $this->createResourcePermissions($permission);
        }

        Permission::create(['name' => 'activities.acknowledge', 'display_name' => "Can acknowledge the activities", 'guard_name' => 'employee']);
        Permission::create(['name' => 'assignment_tasks.toggle', 'display_name' => 'Can toggle the assignment tasks status', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity_tasks.toggle', 'display_name' => 'Can toggle the activity tasks status', "guard_name" => 'employee']);
        Permission::create(['name' => 'project_tasks.toggle', 'display_name' => 'Can toggle the projects tasks status', "guard_name" => 'employee']);
        Permission::create(['name' => 'assignments.changeStatus', 'display_name' => 'Can change the assignment status', "guard_name" => 'employee']);
        //Products
        Permission::create(['name' => 'duplicate', 'display_name' => "Can duplicate  product", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tax.create', 'display_name' => "Can store tax", 'guard_name' => 'employee']);
        Permission::create(['name' => 'category.create', 'display_name' => "Can store category", 'guard_name' => 'employee']);
        Permission::create(['name' => 'action_confirm', 'display_name' => "Can change product status", 'guard_name' => 'employee']);
        //ticket
        Permission::create(['name' => 'change_status', 'display_name' => "Can change ticket status", 'guard_name' => 'employee']);
        Permission::create(['name' => 'postcomment', 'display_name' => "Can write comment for ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'addfollower', 'display_name' => "Can add more ticket follower", 'guard_name' => 'employee']);
        Permission::create(['name' => 'reassign', 'display_name' => "Can reassign ticket ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'piechart', 'display_name' => "Can view piechart report for ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'followed.tickets', 'display_name' => "Can Add Ticket Follower", 'guard_name' => 'employee']);
        Permission::create(['name' => 'tickets.assign', 'display_name' => "Can assign Ticket", 'guard_name' => 'employee']);
        Permission::create(['name' => 'ticket_cmt.delete', 'display_name' => "Can delete comments", 'guard_name' => 'employee']);
        Permission::create(['name' => 'priority.change', 'display_name' => "Can change Priority", 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.index', 'display_name' => "Ticket Request index", 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.show', 'display_name' => "Ticket Request Show", 'guard_name' => 'employee']);
        Permission::create(['name' => 'openticket', 'display_name' => "Open Ticket ", 'guard_name' => 'employee']);

        //lead
        Permission::create(['name' => 'tagadd', 'display_name' => "Can add tag industry", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.myfollowed', 'display_name' => "Can view employee followed in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.comment', 'display_name' => "Can post comments in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'leads.followed', 'display_name' => "Can add new follower in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'unfollowed', 'display_name' => "Can remove follower in lead ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'convert.lead', 'display_name' => "Can change convert to lead status in inQuery", 'guard_name' => 'employee']);
        Permission::create(['name' => 'workdone', 'display_name' => "If Lead Next step complete,can change workdone status ", 'guard_name' => 'employee']);
        Permission::create(['name' => 'qualified', 'display_name' => "If lead qualified ,can change qualified status ", 'guard_name' => 'employee']);
        //deal
        Permission::create(['name' => 'deals.status_change', 'display_name' => "Can change sale stage in Deal", 'guard_name' => 'employee']);
        Permission::create(['name' => 'add_new_customer', 'display_name' => "Can add new customer while deal create", 'guard_name' => 'employee']);
        Permission::create(['name' => 'company_create', 'display_name' => "Can add new company while deal create", 'guard_name' => 'employee']);
        //quotation.blade.php
        Permission::create(['name' => 'quotations.discard', 'display_name' => "Cancel quotation.blade.php", 'guard_name' => 'employee']);
        Permission::create(['name' => 'quotation.blade.php.sendemail', 'display_name' => "Can go to the quotation.blade.php email create page", 'guard_name' => 'employee']);
        Permission::create(['name' => 'quotations.mail', 'display_name' => "Can send to customer the quotation.blade.php email", 'guard_name' => 'employee']);
        //invoice
        Permission::create(['name' => 'invoices.search', 'display_name' => "Can Search invoices", 'guard_name' => 'employee']);
        Permission::create(['name' => 'invoice.sendmail', 'display_name' => "Can go to invoices email preparation view page", 'guard_name' => 'employee']);
        Permission::create(['name' => 'send', 'display_name' => "Can send invoice mail", 'guard_name' => 'employee']);
        Permission::create(['name' => 'invoice.statuschange', 'display_name' => "Can change invoice status", 'guard_name' => 'employee']);
        //approval
        Permission::create(['name' => 'request.me', 'display_name' => "Can view employee approval request to login employee", 'guard_name' => 'employee']);
        Permission::create(['name' => 'approval_cmt', 'display_name' => "Can post comment in approval show", 'guard_name' => 'employee']);
        Permission::create(['name' => 'approval_cmt.delete', 'display_name' => "Can delete comment in approval show", 'guard_name' => 'employee']);
        //project
        Permission::create(['name' => 'projects.accept_proposal', 'display_name' => 'Can accept proposal', "guard_name" => 'employee']);
        Permission::create(['name' => 'projects.status_update', 'display_name' => 'Can udpate project status', "guard_name" => 'employee']);
        //minutes
        Permission::create(['name' => 'assign.minutes', 'display_name' => "Can assign  minutes  in meeting show", 'guard_name' => 'employee']);
        Permission::create(['name' => 'complete.minutes', 'display_name' => 'Can change Minutes Status Complete', "guard_name" => 'employee']);
        Permission::create(['name' => 'filter.minutes', 'display_name' => 'Search Minutes', "guard_name" => 'employee']);
        //setting
        Permission::create(['name' => 'companysettings.prefix', 'display_name' => 'Prefix Setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'companysetting.setprefix', 'display_name' => 'Update Prefix Setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'emailsetting', 'display_name' => 'Email Server setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'mail.setting', 'display_name' => 'Update Email Server setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'booking', 'display_name' => 'Room Booking index', "guard_name" => 'employee']);
        Permission::create(['name' => 'savebooking', 'display_name' => 'Room Booking store', "guard_name" => 'employee']);
        Permission::create(['name' => 'cancel', 'display_name' => 'Room Booking cancel', "guard_name" => 'employee']);
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
