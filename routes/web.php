<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTaskController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentTaskController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CompanySetting;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InqueryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MinutesController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPieChartReport;
use App\Http\Controllers\TicketSender;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\SettingsController;
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

Route::resource('rooms',RoomController::class);
Route::get('rooms.booking',[RoomController::class,'booking'])->name('booking');
Route::post('rooms.savebooking',[RoomController::class,'booking_save'])->name('savebooking');
Route::get('booking/cancel/{id}',[RoomController::class,'bookigCancel'])->name('cancel');

Route::get('/', [HomeController::class, 'index'])->middleware(['auth:employee']);

Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('emplogin');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('settings', [SettingsController::class, 'settings'])->name('settings.settings')->middleware(['auth:employee']);
Route::post('update-profile', [SettingsController::class, 'updateProfile'])->name('settings.profile-update')->middleware(['auth:employee']);

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {

    //Product route
    Route::resource('products',ProductController::class);
    Route::get("/product/duplicate/{id}",[ProductController::class,'duplicate'])->name('duplicate');
    Route::post("/action/confirm",[ProductController::class,'action_confirm'])->name('action_confirm');
    Route::post("/tax/create",[ProductController::class,'tax'])->name('tax.create');
    Route::post("/cat/create",[ProductController::class,'category'])->name('category.create');

    //ticket route
    Route::post("ticket/assign",[TicketController::class,'assignee'])->name('tickets.assign');
    Route::get('ticket/comment/delete/{id}',[TicketController::class,'cmt_delete'])->name('ticket_cmt.delete');
    Route::get('followed/ticket',[TicketController::class,'followed_ticket'])->name('followed.tickets');
    Route::resource('senders',TicketSender::class);
    Route::post('status/{id}',[TicketController::class,'status_change'])->name('change_status');
    Route::post('ticket/comment/',[TicketController::class,'postcomment'])->name('postcomment');
    Route::post('/add/more/follower',[TicketController::class,'add_more_follower'])->name('addfollower');
    Route::post("reassign/ticket",[TicketController::class,'reassign'])->name('reassign');
    Route::get("/piechart/report",[TicketPieChartReport::class,'index'])->name('piechart');
    Route::resource('tickets',TicketController::class)->only('index','edit','create','store','destroy','update');
    Route::resource('cases',CaseTypeController::class);
    Route::resource('priorities',PriorityController::class);
    Route::post('priority/change/{id}',[TicketController::class,'priority_change'])->name('priority.change');
    Route::resource('inqueries',InqueryController::class);
    Route::get('convert/lead/{id}',[InqueryController::class,'convert_lead'])->name('convert.lead');
    Route::resource('request_tickets',RequestTicket::class);
    Route::get('open/ticket/{id}',[RequestTicket::class,'openTicket'])->name('openticket');

    //leads route
    Route::resource('leads',LeadController::class)->only('index','create','edit','store','destroy','update');;
    Route::post("/tags/create",[LeadController::class,'tag_add'])->name('tagadd');
    Route::get("/myfollowed/lead",[LeadController::class,'my_followed'])->name('leads.myfollowed');
    Route::post("/lead/post/comment",[LeadController::class,'comment'])->name('leads.comment');
    Route::post("/lead/followed/",[LeadController::class,'lead_follower'])->name('leads.followed');
    Route::post("/update/followed/",[LeadController::class,'unfollower'])->name('unfollowed');
    Route::get("/workdone/{id}",[LeadController::class,'work_done'])->name('workdone');
    Route::get("/qualified/{id}",[LeadController::class,'qualified'])->name("qualified");

  //deal route
    Route::resource('deals',DealController::class)->only('index','create','edit','store','destroy','update');;
    Route::post("/deal/status/change",[DealController::class,'sale_stage_change'])->name('deals.status_change');
    Route::post("/deal/company/create",[DealController::class,'company_create'])->name('company_create');

   //quotation route
    Route::resource('quotations',QuotationController::class);
    Route::post('discard',[QuotationController::class,'discard'])->name('quotations.discard');
    Route::resource('orders',OrderlineController::class)->only('store','update','destroy');
    Route::post("add/new/customer",[DealController::class,'add_newcustomer'])->name('add_new_customer');
    Route::get('/quotations/sendemail/{id}',[QuotationController::class,'sendEmail'])->name('quotation.sendemail');
    Route::post('/quotations/sendmail',[QuotationController::class,'email'])->name('quotations.mail');
  //invoice
    Route::resource("invoices",InvoiceController::class);
    Route::post("/invoices/search",[InvoiceController::class,'search'])->name('invoices.search');
    Route::resource("invoice_items",InvoiceItemController::class);
    Route::get("invoice/sendmail/{id}",[InvoiceController::class,'sending_form'])->name('invoice.sendmail');
    Route::post("invoice/mail/send",[InvoiceController::class,'email'])->name('send');
    Route::post('invoice/status/{id}',[InvoiceController::class,'status_change'])->name('invoice.statuschange');

    //Approval
    Route::resource('approvals', ApprovalController::class)->only('index','create','store','destroy','update');;
    Route::get("approvals/request/me",[ApprovalController::class,'request_to_me'])->name('request.me');
    Route::post('approval/post/comment/{id}',[CommentController::class,'approval_cmt'])->name('approval_cmt');
    Route::get('approval/cmt/delete/{id}',[CommentController::class,'delete_approval_cmt'])->name('approval_cmt.delete');

    //Meeting
    Route::resource('meetings',MeetingController::class)->only('index','create','store','destroy','update');
    Route::resource('minutes',MinutesController::class);
    Route::post('minutes/assign',[MinutesController::class,'assign_minutes'])->name('assign.minutes');
    Route::post('complete/minutes',[MinutesController::class,'complete'])->name('complete.minutes');
    Route::get('filter/minute/{id}',[MinutesController::class,'filter'])->name('filter.minutes');

    //Setting routes
    Route::resource('companysettings',CompanySetting::class);
    Route::get('setting/prefix',[CompanySetting::class,'edit'])->name('companysettings.prefix');
    Route::post('setting/prefix',[CompanySetting::class,'update'])->name('companysetting.setprefix');
    Route::get('setting/email',[CompanySetting::class,'emailSetting'])->name('emailsetting');
    Route::post('setting/email',[CompanySetting::class,'mailsetting'])->name('mail.setting');

    //resource routes
    Route::resource('roles', RoleController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);

    Route::resource('companies', CompanyController::class);

    Route::resource('customers', CustomerController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('activity_tasks', ActivityTaskController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('assignments',AssignmentController::class);
    Route::resource('project_tasks',ProjectTaskController::class);
    Route::resource('assignment_tasks',AssignmentTaskController::class);

    Route::put('assignments/{id}/changeStatus', [AssignmentController::class,'changeStatus'])->name('assignments.changeStatus');

    Route::put('assignment_tasks/{id}/toggle',[AssignmentTaskController::class, 'toggleStatus'])->name('assignment_tasks.toggle');
    Route::put('activity_tasks/{id}/toggle',[ActivityTaskController::class, 'toggleStatus'])->name('activity_tasks.toggle');
    Route::resource('projects', ProjectController::class)->except([
        'show'
    ]);

    Route::get('/projects/{project}/accept-proposal', [ProjectController::class, 'acceptProposal'])->name('projects.accept_proposal');
    Route::get('/projects/{project}/status-update', [ProjectController::class, 'statusUpdate'])->name('projects.status_update');
    Route::get('/projects/{project}/tasks/{task_id?}', [ProjectController::class,'show'])->name('projects.show');
    Route::put('project_tasks/{id}/toggle',[ProjectTaskController::class, 'toggleStatus'])->name('project_tasks.toggle');

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

    Route::put('activities/{id}/acknowledge', [ActivityController::class, 'acknowledge'])->name('activities.acknowledge');


    //list routes post
    Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

    //card routes
    Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
    Route::get('customers-card', [CustomerController::class, 'card'])->name('customers.cards');
    Route::get('employees-card', [EmployeeController::class, 'card'])->name('employees.cards');
    Route::get('departments-card', [DepartmentController::class, 'card'])->name('departments.cards');

});

//list routes post
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

//list routes
Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
Route::resource('request_tickets',RequestTicket::class)->only('create','store');
;
Route::resource('inqueries',InqueryController::class)->only('create','store');



Route::middleware(['meeting_view_relative_emp','auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('meetings',MeetingController::class)->only('show');
    Route::resource('tickets',TicketController::class)->only('show');
    Route::resource('leads',LeadController::class)->only('show');
    Route::resource('deals',DealController::class)->only('show');
    Route::resource('approvals',ApprovalController::class)->only('show');
});

Route::get('test',function (){
    $orders=\App\Models\Orderline::with('product')->get();
    $total=0;
    for ($i=0;$i<count($orders);$i++){
        $total=$total+$orders[$i]->total_amount;
    }
   return view('quotation.mail',compact('orders','total'));
});