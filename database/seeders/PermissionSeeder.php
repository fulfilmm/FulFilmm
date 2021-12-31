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
        'products','permissions','priorities','quotations','quotation_items','roles','rooms','senders','tickets','accounts','expenseclaims','rfqs','purchase_request',
        'purchaseorders','bills'
    ];
    public function run()
    {
        //
        foreach ($this->permissions as $permission) {
            $this->createResourcePermissions($permission);
        }

         //Products
        Permission::create(['name' => 'duplicate', 'display_name' => "Can duplicate  product",'type'=>'products', 'guard_name' => 'employee']);
        Permission::create(['name' => 'tax.create', 'display_name' => "Can store tax",'type'=>'products', 'guard_name' => 'employee']);
        Permission::create(['name' => 'category.create', 'display_name' => "Can store category",'type'=>'products', 'guard_name' => 'employee']);
        Permission::create(['name' => 'action_confirm', 'display_name' => "Can change product status", 'type'=>'products','guard_name' => 'employee']);
        //ticket
        Permission::create(['name' => 'change_status', 'display_name' => "Can change ticket status",'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'reassign', 'display_name' => "Can reassign ticket ", 'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'piechart', 'display_name' => "Can view piechart report for ticket", 'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'tickets.assign', 'display_name' => "Can assign Ticket",'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'priority.change', 'display_name' => "Can change Priority", 'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.index', 'display_name' => "Ticket Request index", 'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'request_tickets.show', 'display_name' => "Ticket Request Show", 'type'=>'tickets', 'guard_name' => 'employee']);
        Permission::create(['name' => 'openticket', 'display_name' => "Open Ticket ", 'type'=>'tickets', 'guard_name' => 'employee']);

        //lead
        Permission::create(['name' => 'leads.myfollowed', 'display_name' => "Can view employee followed in lead ",'type'=>'lead', 'guard_name' => 'employee']);
        Permission::create(['name' => 'qualified', 'display_name' => "If lead qualified ,can change qualified status ",'type'=>'lead', 'guard_name' => 'employee']);
        //deal
        //invoice
        Permission::create(['name' => 'invoice.sendmail', 'display_name' => "Can go to invoices email preparation view page",'type'=>'invoices', 'guard_name' => 'employee']);
        Permission::create(['name' => 'send', 'display_name' => "Can send invoice mail",'type'=>'invoices', 'guard_name' => 'employee']);
        Permission::create(['name' => 'invoice.statuschange', 'display_name' => "Can change invoice status", 'type'=>'invoices', 'guard_name' => 'employee']);
        //approval
        Permission::create(['name' => 'request.me', 'display_name' => "Can view employee approval request to login employee",'type'=>'approvals', 'guard_name' => 'employee']);
       //minutes
        Permission::create(['name' => 'assign.minutes', 'display_name' => "Can assign  minutes  in meeting show",'type'=>'meetings','guard_name' => 'employee']);
        //setting
        Permission::create(['name' => 'companysettings.prefix', 'display_name' => 'Prefix Setting', 'type'=>'setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'companysetting.setprefix', 'display_name' => 'Update Prefix Setting', 'type'=>'setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'emailsetting', 'display_name' => 'Email Server setting', 'type'=>'setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'mail.setting', 'display_name' => 'Update Email Server setting', 'type'=>'setting', "guard_name" => 'employee']);
        Permission::create(['name' => 'booking', 'display_name' => 'Room Booking index', 'type'=>'meetings', "guard_name" => 'employee']);
        Permission::create(['name' => 'savebooking', 'display_name' => 'Room Booking store',  'type'=>'meetings',"guard_name" => 'employee']);
        Permission::create(['name' => 'cancel', 'display_name' => 'Room Booking cancel', 'type'=>'meetings', "guard_name" => 'employee']);
        Permission::create(['name' => 'income.create', 'display_name' => 'Revenue Add Form', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'revenue', 'display_name' => 'Revenue List View', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense', 'display_name' => 'Expense List View', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'income.store', 'display_name' => 'Add New Revenue', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'transactions.index', 'display_name' => 'All Transaction List', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense.create', 'display_name' => 'Expense Create Form', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'expense.store', 'display_name' => 'Add New Expense', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'transactions.show', 'display_name' => 'Transaction Detail View', 'type'=>'transaction', "guard_name" => 'employee']);
        Permission::create(['name' => 'deals.schedule', 'display_name' => 'Add new activity schedule for deal','type'=>'deals', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.index', 'display_name' => 'Activity list view route','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.create', 'display_name' => 'Sale Activity Create','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.show', 'display_name' => 'Sale Activity Details view','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.store', 'display_name' => 'Sale Activity Store','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'read', 'display_name' => 'Sale Activity anknowledge','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.comment', 'display_name' => 'Post Comment in activity','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.addfollowed', 'display_name' => 'Add follower in activity','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name' => 'activity.unfollowed', 'display_name' => 'Remove follower in activity','type'=>'activity', "guard_name" => 'employee']);
        Permission::create(['name'=>'transfer.index','display_name'=>'Stock Transfer Record','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'stocks','display_name'=>'Stock','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'permission.store','display_name'=>'Permission Store','type'=>'permissions','guard_name'=>'employee']);
        Permission::create(['name'=>'permission.create','display_name'=>'Permission Create','type'=>'permissions','guard_name'=>'employee']);
        Permission::create(['name'=>'showstockin','display_name'=>'Stock In Create Form','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'stockin','display_name'=>'Stock In store','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'showstockout','display_name'=>'Stock Out From','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'stockout','display_name'=>'Stock Out','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'stocks.index','display_name'=>'Stock Transaction Index','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'show.transfer','display_name'=>'Stocks Transfer Form','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'stocks.transfer','display_name'=>'Stocks Transfer','type'=>'Stocks','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.index','display_name'=>'Sale target index','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.create','display_name'=>'Sale target create','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.store','display_name'=>'Sale target store','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.edit','display_name'=>'Sale target edit','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.update','display_name'=>'Sale target update','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.show','display_name'=>'Sale target show','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'saletargets.destory','display_name'=>'Sale target destory','type'=>'saletargets','guard_name'=>'employee']);
        Permission::create(['name'=>'sale.dashboard','display_name'=>'Sale Dashboard','type'=>'Sale','guard_name'=>'employee']);
        Permission::create(['name'=>'search.saledashboard','display_name'=>'Sale Dashboard filter','type'=>'Sale','guard_name'=>'employee']);
        Permission::create(['name'=>'report.saleprformance','display_name'=>'Sale Person report','type'=>'Sale','guard_name'=>'employee']);
        Permission::create(['name'=>'exp_claim.status','display_name'=>'Expense Claim Status Change','type'=>'expenseclaims','guard_name'=>'employee']);
        Permission::create(['name'=>'cash.claim','display_name'=>'Expense Claim Cash status Change','type'=>'expenseclaims','guard_name'=>'employee']);
        Permission::create(['name'=>'exp_claim.comment','display_name'=>'Expense Claim comment','type'=>'expenseclaims','guard_name'=>'employee']);
        Permission::create(['name'=>'exp_claim.comment_delete','display_name'=>'Expense Claim comment delete','type'=>'expenseclaims','guard_name'=>'employee']);
        Permission::create(['name'=>'pr.status','display_name'=>'Purchase Request Status change','type'=>'purchase_request','guard_name'=>'employee']);
        Permission::create(['name'=>'rfq.prepare','display_name'=>'Purchase Request to RFQs','type'=>'rfqs','guard_name'=>'employee']);
        Permission::create(['name'=>'inventory.index','display_name'=>'Inventory Index','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'receiptprocess','display_name'=>'Product Receive List','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'receipt.show','display_name'=>'Product Receive view','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'product.validate','display_name'=>'Validate Product Receive qty','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'receipt.rededit','display_name'=>'Edit Product Receive data','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'supplierbills','display_name'=>'Bill create from customer view','type'=>'bills','guard_name'=>'employee']);
        Permission::create(['name'=>'billitems.store','display_name'=>'Add bill item','type'=>'bills','guard_name'=>'employee']);
        Permission::create(['name'=>'billitems.update','display_name'=>'Update bill item','type'=>'bills','guard_name'=>'employee']);
        Permission::create(['name'=>'purchase.orders','display_name'=>'Po direct create from RFQ','type'=>'purchaseorders','guard_name'=>'employee']);
        Permission::create(['name'=>'purchaseorders.confirm','display_name'=>'Purchase order confirm','type'=>'purchaseorders','guard_name'=>'employee']);
        Permission::create(['name'=>'to.stock','display_name'=>'Add to stock from PO','type'=>'inventory','guard_name'=>'employee']);
        Permission::create(['name'=>'po.bill','display_name'=>'Bill direct create form PO','type'=>'bills','guard_name'=>'employee']);
        Permission::create(['name'=>'delivery.bill','display_name'=>'Bill direct create form delivery','type'=>'bills','guard_name'=>'employee']);

    }

    private function createResourcePermissions($resource)
    {
        Permission::create(['name' => $resource . '.index', 'display_name' => "View all $resource", 'type'=>$resource,'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.create', 'display_name' => "Show create form for $resource",'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.store', 'display_name' => "Store the $resource", 'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.show', 'display_name' => "View detail of the $resource", 'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.edit', 'display_name' => "Show Edit form for the $resource",'type'=>$resource,  'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.update', 'display_name' => "Update the $resource", 'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.destroy', 'display_name' => "Delete the $resource",'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.export', 'display_name' => "Export the $resource", 'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.import', 'display_name' => "Import the $resource", 'type'=>$resource, 'guard_name' => 'employee']);
        Permission::create(['name' => $resource . '.cards', 'display_name' => "View the $resource card", 'type'=>$resource, 'guard_name' => 'employee']);

    }
}
