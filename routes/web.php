<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTaskController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentTaskController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InqueryController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPieChartReport;
use App\Http\Controllers\TicketSender;
use Illuminate\Support\Facades\Auth;
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



Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {

    //Product route
    Route::get("/products",[ProductController::class,'index'])->name('product.index');
    Route::get("/product/create",[ProductController::class,'create'])->name('product.create');
    Route::post("/product/create",[ProductController::class,'store'])->name('product.store');
    Route::get("/product/edit/{id}",[ProductController::class,'edit'])->name('product.edit');
    Route::post("product/update/{id}",[ProductController::class,'update'])->name('product.update');
    Route::get("/product/delete/{id}",[ProductController::class,'destroy'])->name('product.delete');
    Route::get("product/show/{id}",[ProductController::class,'show'])->name('product.show');
    Route::get("/product/duplicate/{id}",[ProductController::class,'duplicate'])->name('duplicate');
    Route::post("/action/confirm",[ProductController::class,'action_confirm'])->name('action_confirm');
    Route::post("/tax/create",[ProductController::class,'tax'])->name('tax.create');
    Route::post("/cat/create",[ProductController::class,'category'])->name('category.create');

    //ticket route
    Route::post('status/{id}',[TicketController::class,'status_change'])->name('change_status');
    Route::post('ticket/comment/',[TicketController::class,'postcomment'])->name('postcomment');
    Route::post('/add/more/follower',[TicketController::class,'add_more_follower'])->name('addfollower');
    Route::post("reassign/ticket",[TicketController::class,'reassign'])->name('reassign');
    Route::get("/piechart/report",[TicketPieChartReport::class,'index'])->name('piechart');
    Route::get('ticket/senders',[TicketSender::class,'index'])->name("sender_info");
    Route::resource('tickets',TicketController::class);
    Route::resource('cases',CaseTypeController::class);
    Route::resource('priorities',PriorityController::class);
    Route::resource('/inqueries',InqueryController::class);
    Route::get('convert/lead/{id}',[InqueryController::class,'convert_lead'])->name('convert.lead');

    //leads route
    Route::resource('leads',LeadController::class);
    Route::post("/tags/create",[LeadController::class,'tag_add'])->name('tagadd');
    Route::get("/myfollowed/lead",[LeadController::class,'my_followed'])->name('leads.myfollowed');
    Route::post("/lead/post/comment",[LeadController::class,'comment'])->name('leads.comment');
    Route::post("/lead/followed/",[LeadController::class,'lead_follower'])->name('leads.followed');
    Route::post("/update/followed/",[LeadController::class,'unfollower'])->name('unfollowed');
    Route::get("/workdone/{id}",[LeadController::class,'work_done'])->name('workdone');
    Route::get("/qualified/{id}",[LeadController::class,'qualified'])->name("qualified");

  //deal route
    Route::resource('deals',DealController::class);
    Route::post("/deal/status/change",[DealController::class,'sale_stage_change'])->name('deals.status_change');
    Route::post("/deal/company/create",[DealController::class,'company_create'])->name('company_create');

   //quotation route
    Route::resource('quotations',QuotationController::class);
    Route::post('discard',[QuotationController::class,'discard'])->name('quotations.discard');
    Route::post('orders/store',[OrderlineController::class,'store'])->name('orders.store');
    Route::post('orders/update/{id}',[OrderlineController::class,'update'])->name('orders.update');
    Route::get('orders/delete/{id}',[OrderlineController::class,'destroy'])->name('orders.destroy');
    Route::post("add/new/customer",[DealController::class,'add_newcustomer'])->name('add_new_customer');
    Route::get('/quotations/sendemail/{id}',[QuotationController::class,'sendEmail'])->name('quotation.sendemail');
    Route::post('/quotations/sendmail',[QuotationController::class,'email'])->name('quotations.mail');

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
    Route::put('assignments/{id}/changeStatus', [AssignmentController::class,'changeStatus'])->name('assignments.changeStatus');
    Route::resource('assignment_tasks',AssignmentTaskController::class);
    Route::put('assignment_tasks/{id}/toggle',[AssignmentTaskController::class, 'toggleStatus'])->name('assignment_tasks.toggle');
    Route::resource('projects', ProjectController::class);

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
});



//list routes post
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

//list routes
Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
Route::get('ticket/create/guest',[TicketController::class,'create']);
Route::post('ticket/create/guest',[TicketController::class,'store']);
Route::resource('/inqueries',InqueryController::class)->only('create','store');

