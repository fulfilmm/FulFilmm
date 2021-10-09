<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\Login\CustomerAuth;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CompanySetting;
use App\Http\Controllers\CustomerProtal;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MinutesController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPieChartReport;
use App\Http\Controllers\TicketSender;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/api/auth/login',function (){
    return redirect('/');
});
Route::get('/', [HomeController::class, 'index'])->middleware(['auth:employee']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('emplogin');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

});
//Route::resource('saleorders', SaleOrderController::class)->only('create','store')->middleware('custom_auth');

Route::namespace('Auth\Login')->prefix('customer')->as('customers.')->group(function () {
    Route::post('login', [CustomerAuth::class, 'login'])->name('customerlogin');
    Route::post('logout', [CustomerAuth::class, 'logout'])->name('logout');
});
Route::get('settings', [SettingsController::class, 'settings'])->name('settings.settings')->middleware(['auth:employee']);
Route::post('update-profile', [SettingsController::class, 'updateProfile'])->name('settings.profile-update')->middleware(['auth:employee']);

Route::middleware(['auth:employee'])->group(function () {
    Route::get('ticket/comment/delete/{id}', [TicketController::class, 'cmt_delete'])->name('ticket_cmt.delete');
    Route::get('followed/ticket', [TicketController::class, 'followed_ticket'])->name('followed.tickets');
    Route::post('ticket/comment/', [TicketController::class, 'postcomment'])->name('postcomment');
    Route::post('/add/more/follower', [TicketController::class, 'add_more_follower'])->name('addfollower');
    Route::post("/lead/post/comment", [LeadController::class, 'comment'])->name('leads.comment');
    Route::post("/lead/followed/", [LeadController::class, 'lead_follower'])->name('leads.followed');
    Route::post("/update/followed/", [LeadController::class, 'unfollower'])->name('unfollowed');
    Route::get('filter/minute/{id}', [MinutesController::class, 'filter'])->name('filter.minutes');
    Route::post('lead/activity/schedule', [LeadController::class, 'activity_schedule'])->name('activity.schedule');
    Route::get('activity/delete/{id}', [LeadController::class, 'delete_schedule'])->name('delete_schedule');
    Route::post('approval/post/comment/{id}', [CommentController::class, 'approval_cmt'])->name('approval_cmt');
    Route::get('approval/cmt/delete/{id}', [CommentController::class, 'delete_approval_cmt'])->name('approval_cmt.delete');
    Route::resource("invoice_items", InvoiceItemController::class);
    Route::post('discard', [QuotationController::class, 'discard'])->name('quotations.discard');
    Route::post("/tags/create", [LeadController::class, 'tag_add'])->name('tagadd');
    Route::get("/workdone/{id}", [LeadController::class, 'work_done'])->name('work.done');
    Route::post("/invoices/search", [InvoiceController::class, 'search'])->name('invoices.search');
    Route::post('complete/minutes', [MinutesController::class, 'complete'])->name('complete.minutes');
    Route::get('order/to/invoice/{id}', [SaleOrderController::class, 'generate_invoice'])->name('generate_inv');
    Route::post('order/comment', [SaleOrderController::class, 'comment'])->name('orders.comment');
    Route::get('order/comment/{id}', [SaleOrderController::class, 'comment_delete'])->name('order_comment.delete');
    Route::get('order/{status}/{id}', [SaleOrderController::class, 'status_change'])->name('order.status');
    Route::post('order/assign/{id}', [SaleOrderController::class, 'assign'])->name('order.assign');
    Route::resource('saleorders', SaleOrderController::class);
    Route::post('add/category',[TransactionController::class,'add_category']);

    Route::post("/deal/status/change", [DealController::class, 'sale_stage_change'])->name('deals.status_change');
    Route::post("/deal/company/create", [DealController::class, 'company_create'])->name('company_create');
    Route::get('/quotations/sendemail/{id}', [QuotationController::class, 'sendEmail'])->name('sendemail');
    Route::post('/quotations/sendmail', [QuotationController::class, 'email'])->name('quotations.mail');
    Route::get('/quotations/confirm/{id}', [QuotationController::class, 'confirm'])->name('quotations.confirm');
    Route::get('quotations/delete/{id}',[QuotationController::class,'destroy']);
    Route::post('account/enable/{id}',[AccountController::class,'enable'])->name('account.enable');
    Route::get('product/category',[ProductController::class,'category_index'])->name('category');
    Route::get('product/category/delete/{id}',[ProductController::class,'category_delete'])->name('category.delete');
    Route::post('product/category/update/{id}',[ProductController::class,'category_update'])->name('category.update');
    Route::get('product/tax/delete/{id}',[ProductController::class,'tax_delete'])->name('taxes.delete');
    Route::get('product/tax/',[ProductController::class,'tax_index'])->name('taxes');
    Route::get('transaction/category/',[TransactionController::class,'category'])->name('transaction.category');
    Route::post('category/transaction/update/{id}',[TransactionController::class,'update_cat'])->name('transaction_category.update');
    Route::get('category/transaction/delete/{id}',[TransactionController::class,'delete_cat'])->name('transaction_category.delete');


});
//Route::resource('saleorders', SaleOrderController::class)->middleware('auth:employee');

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {

    //Banking System
    Route::resource('accounts',AccountController::class);
    Route::get('add/revenue', [TransactionController::class, 'addrevenue'])->name('income.create');
    Route::get('revenue',[TransactionController::class,'revenue_index'])->name('revenue');
    Route::get('expense',[TransactionController::class,'expense_index'])->name('expense');
    Route::post('add/revenue', [TransactionController::class, 'store_revenue'])->name('income.store');
    Route::get('transactions',[TransactionController::class,'index'])->name('transactions.index');
    Route::get('add/expense',[TransactionController::class,'expense'])->name('expense.create');
    Route::post('store/expense',[TransactionController::class,'expense_store'])->name('expense.store');
    Route::get('transaction/show/{id}',[TransactionController::class,'show'])->name('transactions.show');
    //Product route

    Route::get("/product/duplicate/{id}", [ProductController::class, 'duplicate'])->name('duplicate');
    Route::post("/action/confirm", [ProductController::class, 'action_confirm'])->name('action_confirm');
    Route::post("/tax/create", [ProductController::class, 'tax'])->name('tax.create');
    Route::post("/cat/create", [ProductController::class, 'category'])->name('category.create');
    //ticket route
    Route::post("ticket/assign", [TicketController::class, 'assignee'])->name('tickets.assign');
    Route::post('status/{id}', [TicketController::class, 'status_change'])->name('change_status');
    Route::post("reassign/ticket", [TicketController::class, 'reassign'])->name('reassign');
    Route::get("/piechart/report", [TicketPieChartReport::class, 'index'])->name('piechart');
    Route::post('priority/change/{id}', [TicketController::class, 'priority_change'])->name('priority.change');
    Route::resource('request_tickets', RequestTicket::class);
    Route::get('open/ticket/{id}', [RequestTicket::class, 'openTicket'])->name('openticket');

    //leads route


    Route::get("/myfollowed/lead", [LeadController::class, 'my_followed'])->name('leads.myfollowed');
    Route::get("/qualified/{id}", [LeadController::class, 'qualified'])->name("qualified");

    //deal route

    //quotation.blade.php route


    Route::post("add/new/customer", [DealController::class, 'add_newcustomer'])->name('add_new_customer');

    //invoice
    Route::get("invoice/sendmail/{id}", [InvoiceController::class, 'sending_form'])->name('invoice.sendmail');
    Route::post("invoice/mail/send", [InvoiceController::class, 'email'])->name('send');
    Route::post('invoice/status/{id}', [InvoiceController::class, 'status_change'])->name('invoice.statuschange');
    Route::get("approvals/request/me", [ApprovalController::class, 'request_to_me'])->name('request.me');

    //Meeting

    Route::post('minutes/assign', [MinutesController::class, 'assign_minutes'])->name('assign.minutes');
    Route::get('booking', [RoomController::class, 'booking'])->name('booking');
    Route::post('savebooking', [RoomController::class, 'booking_save'])->name('savebooking');
    Route::get('booking/cancel/{id}', [RoomController::class, 'bookigCancel'])->name('cancel');

    //Setting routes

    Route::get('setting/prefix', [CompanySetting::class, 'edit'])->name('companysettings.prefix');
    Route::post('setting/prefix', [CompanySetting::class, 'update'])->name('companysetting.setprefix');
    Route::get('setting/email', [CompanySetting::class, 'emailSetting'])->name('emailsetting');
    Route::post('setting/email', [CompanySetting::class, 'mailsetting'])->name('mail.setting');

    //resource routes
    Route::resource('approvals', ApprovalController::class)->only('index', 'create', 'store', 'destroy', 'update');
    Route::resource('companies', CompanyController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('cases', CaseTypeController::class);
    Route::resource('companysettings', CompanySetting::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('deals', DealController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');
    Route::resource('employees', EmployeeController::class);
    Route::resource('groups', GroupController::class);
    Route::resource("invoices", InvoiceController::class);
    Route::resource('minutes', MinutesController::class);
    Route::resource('meetings', MeetingController::class)->only('index', 'create', 'store', 'destroy', 'update');
    Route::resource('products', ProductController::class);
    Route::resource('priorities', PriorityController::class);
    Route::resource('quotations', QuotationController::class);
    Route::resource('quotation_items', OrderlineController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('senders', TicketSender::class);
    Route::resource('tickets', TicketController::class)->only('index', 'edit', 'create', 'store', 'destroy', 'update');
    Route::resource('leads', LeadController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');



    //export routes
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('departments/export', [DepartmentController::class, 'export'])->name('departments.export');
    Route::get('employees/export/', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('companies/export', [CompanyController::class, 'export'])->name('companies.export');

    //import routes
    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::post('departments/import', [DepartmentController::class, 'import'])->name('departments.import');
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::post('companies/import', [CompanyController::class, 'import'])->name('companies.import');


    //list routes post
    Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

    //card routes
    Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
    Route::get('customers-card', [CustomerController::class, 'card'])->name('customers.cards');
    Route::get('employees-card', [EmployeeController::class, 'card'])->name('employees.cards');
    Route::get('departments-card', [DepartmentController::class, 'card'])->name('departments.cards');

});

//Route::resource('inqueries',InqueryController::class)->only('create','store');

Route::middleware(['meeting_view_relative_emp', 'auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('meetings', MeetingController::class)->only('show');
    Route::resource('tickets', TicketController::class)->only('show');
    Route::resource('leads', LeadController::class)->only('show');
    Route::resource('deals', DealController::class)->only('show');
    Route::resource('approvals', ApprovalController::class)->only('show');
});
//CustomerProtal Side Route
Route::middleware(['auth:customer'])->group(function () {
    Route::get('customer/home/', [CustomerProtal::class, 'home'])->name('home');
    Route::get('customer/quotation', [CustomerProtal::class, 'quotation'])->name('customer.quotation');
    Route::get('customer/dashboard', [CustomerProtal::class, 'dashboard'])->name('customer.invoice');
    Route::get('customer/order', [CustomerProtal::class, 'dashboard'])->name('customer.orders');
    Route::get('customer/order/{id}', [CustomerProtal::class, 'dashboard'])->name('order.show');
    Route::resource('orders', SaleOrderController::class);
});

Route::get('test', function () {
//    $orders=\App\Models\Orderline::with('product')->get();
//    $total=0;
//    for ($i=0;$i<count($orders);$i++){
//        $total=$total+$orders[$i]->total_amount;
//    }
//    dd(auth('api')->factory()->getTTL() * 60);
    return view('test');
})->name('test');

//Route::get('send', [HomeController::class,'sendNotification']);
//Route::get('piect/search', [TicketPieChartReport::class, 'filter'])->name('piechart.filter');
//list routes post
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

//list routes
Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
Route::resource('request_tickets', RequestTicket::class)->only('create', 'store');

//new
Route::post('deal/schedule',[DealController::class,'schedule'])->name('deals.schedule');
Route::post('deal/post/comment',[DealController::class,'comment'])->name('deals.comment');
Route::get("deal/workdone/{id}", [DealController::class, 'workdone'])->name('schedule.done');