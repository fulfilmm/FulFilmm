<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvancePaymentController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\Login\CustomerAuth;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CompanySetting;
use App\Http\Controllers\CustomerProtal;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DiscountPromotionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExpenseClaimController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MinutesController;
use App\Http\Controllers\OfficeBranchController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProductBrand;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\RFQController;
use App\Http\Controllers\RFQItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleActivityController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\SaleTargetController;
use App\Http\Controllers\SellingUnitController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\WarehouseController;
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
use App\Http\Controllers\ShippmentController;

use App\Http\Controllers\CarBooking\CarsController;
use App\Http\Controllers\CarBooking\MaintainController;
use App\Http\Controllers\Invoice\InvoiceDataController;

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
Route::get('employee/login',[AuthController::class,'employeelogin']);
Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('emplogin');

});
//Route::resource('saleorders', SaleOrderController::class)->only('create','store')->middleware('custom_auth');

Route::namespace('Auth\Login')->group(function () {
    Route::post('login', [CustomerAuth::class, 'login'])->name('customers.customerlogin');
    Route::post('logout', [CustomerAuth::class, 'logout'])->name('customers.logout');
});
Route::get('settings', [SettingsController::class, 'settings'])->name('settings.settings')->middleware(['auth:employee']);
Route::post('update-profile', [SettingsController::class, 'updateProfile'])->name('settings.profile-update')->middleware(['auth:employee']);

Route::middleware(['auth:employee'])->group(function () {
    Route::post('employee/logout', [AuthController::class, 'logout'])->name('employee.logout');
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

    Route::get("/deal/change/{status}/{id}", [DealController::class, 'sale_stage_change'])->name('deals.status_change');
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
    Route::get('/contact/qualified/',[CustomerController::class,'qualified_contact'])->name('qualified_contact');
    Route::post('change/contact/type',[CustomerController::class,'ChangeContactType'])->name('changeContct');
    Route::post('deal/post/comment',[DealController::class,'comment'])->name('deals.comment');
    Route::get("deal/workdone/{id}", [DealController::class, 'workdone'])->name('schedule.done');
    Route::resource('warehouses',WarehouseController::class);
    Route::get('suppliers',[CustomerController::class,'supplier'])->name('suppliers');
    Route::get('theme/color',[SettingsController::class,'theme_setting'])->name('theme.setting');
    Route::post('theme/color',[SettingsController::class,'theme_color'])->name('theme.color');
    Route::resource('deliveries',ShippmentController::class);
    Route::post('delivery/comment',[ShippmentController::class,'comment'])->name('delivery.comment');
    Route::post('/pr/item/add',[PurchaseItemController::class,'store'])->name('purchaseitem.store');
    Route::post('/pr/item/update/{id}',[PurchaseItemController::class,'update'])->name('purchaseitem.update');
    Route::post('pr/comment',[PurchaseRequestController::class,'comment'])->name('pr.comment');
    Route::get('pr/comment/delet/{id}',[PurchaseRequestController::class,'cmt_delete'])->name('pr_comment.delete');
    Route::post('/pr/item/delete',[PurchaseItemController::class,'delete'])->name('pritem.delete');
    Route::post('/rfq/item/add',[RFQItemController::class,'store'])->name('rfqitem.store');
    Route::post('/rfq/item/update/{id}',[RFQItemController::class,'update'])->name('rfqitem.update');
    Route::post('/rfq/item/delete',[RFQItemController::class,'destroy'])->name('rfqitem.delete');
    Route::get('/rfq/sendmail/{vendor_id}',[RFQController::class,'prepareemail'])->name('rfq.preparemail');
    Route::post('rfqs/send',[RFQController::class,'sendmail'])->name('rfq.sendmail');
    Route::get('/rfq/status/change/{id}/{status}',[RFQController::class,'statuschange'])->name('rfq.statuschange');
    Route::get('/rfq/receive/product/{id}',[RFQController::class,'productReceive'])->name('rfq.productreceive');
    Route::post('/po/item/add',[PurchaseOrderItemController::class,'store'])->name('poitem.store');
    Route::post('/po/item/update/{id}',[PurchaseOrderItemController::class,'update'])->name('poitem.update');
    Route::post('/po/item/delete',[PurchaseOrderItemController::class,'destroy'])->name('poitem.delete');
    Route::get('employee/change/password',[EmployeeController::class,'password_edit'])->name('password.edit');
    Route::post('employee/update/password/{id}',[EmployeeController::class,'password_update'])->name('emp_password.update');
    Route::get('notification/index',[\App\Http\Controllers\NotificationController::class,'index'])->name('notifications.index');
    Route::get('notification/delete/{id}',[\App\Http\Controllers\NotificationController::class,'destroy'])->name('notifications.delete');
    Route::get('notification/{uuid}',[\App\Http\Controllers\NotificationController::class,'show'])->name('notifications.show');



    //**  Route By Nyan  */
    //Car Booking System
    Route::get('/car-list', [CarsController::class, 'index']) -> name('carList');
    Route::get('/car-list/{any}' , [CarsController::class,'show']) -> where('any', '.*');
    // Route::get('/car-maintain/{id}' , [CarsController::class,'maintain']);
    // Route::get('/car-record/{id}' , [CarsController::class,'record']);
    Route::get('/download/{contract}' , [CarsController::class, 'download']);
    Route::get('/download/car-list/attach/{data}' , [CarsController::class, 'downloadAttach']);

    Route::get('/maintainance' , [ MaintainController::class, 'index']) -> name('maintain');
    Route::get('/maintain/{any}' , [MaintainController::class, 'show']) -> where('any', '.*');
    Route::get('/download/maintain/attaches/{data}' , [MaintainController::class, 'download']);
    Route::get('/download/maintain_record/attaches/{data}' , [MaintainController::class, 'downloadRecord']);

    //** end */

    //Invoice Route
    Route::get('/invoice_vue' , [InvoiceDataController::class, 'index']) -> name('invoice_vue.index');
    Route::get('invoice/{any}', [InvoiceDataController::class,'show']) -> where('any', '.*'); 


    //new route (do not have permission table)

    Route::resource('revenuebudget',\App\Http\Controllers\RevenueBudgetController::class);
    Route::resource('expensebudget',\App\Http\Controllers\ExpenseBudgetController::class);
    Route::resource('chartofaccount',\App\Http\Controllers\ChartOfAccountController::class);
    Route::get('coatype',[\App\Http\Controllers\ChartOfAccountController::class,'coatype_index'])->name('coatype.index');
    Route::post('coatype',[\App\Http\Controllers\ChartOfAccountController::class,'coatype'])->name('coatype.store');
    Route::post('coatype/update/{id}',[\App\Http\Controllers\ChartOfAccountController::class,'type_update'])->name('coatype.update');
    Route::get('coatype/delete/{id}',[\App\Http\Controllers\ChartOfAccountController::class,'type_destory'])->name('coatype.delete');

    Route::post('emp/add/office',[OfficeBranchController::class,'add_emp'])->name('empadd.office');
    Route::get('branch/report/{branch_id}',[OfficeBranchController::class,'report'])->name('branch.report');
    Route::get('stock/transfer/receipt/{id}',[StockTransactionController::class,'confirm'])->name('stock_transfer.confirm');
    Route::post('stock/transfer/validate/{id}',[StockTransactionController::class,'transfer_validate'])->name('stock_transfer.validate');
    Route::resource('expense_record',\App\Http\Controllers\ExpensesRecordController::class);
    Route::get('revenue/delete/{id}',[TransactionController::class,'revenue_delete'])->name('revenue.delete');
    Route::get('revenue/edit/{id}',[TransactionController::class,'revenue_edit'])->name('revenue.edit');
    Route::post('revenue/update/{id}',[TransactionController::class,'revenue_update'])->name('revenue.update');
    Route::get('expense/delete/{id}',[TransactionController::class,'expense_delete'])->name('expense.delete');
    Route::get('expense/edit/{id}',[TransactionController::class,'expense_edit'])->name('expense.edit');
    Route::post('expense/update/{id}',[TransactionController::class,'expense_update'])->name('expense.update');
    Route::get('inv/cancel/{id}',[InvoiceController::class,'cancel'])->name('invoice.cancel');
    Route::resource('sale_return',\App\Http\Controllers\SaleReturnController::class);
    Route::resource('salezone',\App\Http\Controllers\SaleZoneController::class);
    Route::get('daily/report',[ReportController::class,'daily'])->name('daily.report');
    Route::resource('region',\App\Http\Controllers\RegionController::class);
    Route::get('expired/product',[StockTransactionController::class,'expired_product'])->name('expired.products');
    Route::get('expired/alert/product',[StockTransactionController::class,'alert_product'])->name('alert.products');
    Route::get('payments',[BillController::class,'payment'])->name('payment');
    Route::get('mobile/warehouse/return',[\App\Http\Controllers\StockReturnController::class,'mobilereturn'])->name('stockreturn.mobile');
    Route::resource('moneytransfer',\App\Http\Controllers\CashTransferRecordController::class);
    Route::post('remove/shop',[\App\Http\Controllers\SaleWayController::class,'remove_shop'])->name('remove.shop');
    Route::post('add/shop',[\App\Http\Controllers\SaleWayController::class,'add_shop'])->name('add.shop');
    Route::resource('salegroup',\App\Http\Controllers\SaleGroupController::class);
    Route::post('add/sale/group/memeber',[\App\Http\Controllers\SaleGroupController::class,'add_member'])->name('add.member');
    Route::post('remove/sale/group/memeber',[\App\Http\Controllers\SaleGroupController::class,'remove_member'])->name('remove.member');
    Route::resource('assignsaleway',\App\Http\Controllers\WayAssignController::class);
    Route::post('check/in/{id}',[\App\Http\Controllers\WayAssignController::class,'check'])->name('check');
    Route::resource('shop',\App\Http\Controllers\ShopRegister::class);
    Route::resource('saleway',\App\Http\Controllers\SaleWayController::class);
    Route::post('transfer/branch',[TransactionController::class,'transer_branch'])->name('transfer.branch');
    Route::get('best/sell/products',[ReportController::class,'bestsell_products'])->name('best.sell');
    Route::resource('head_office',\App\Http\Controllers\HeadOfficeController::class);



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
    Route::get('customers/export/excel', [CustomerController::class, 'export'])->name('customers.export');
    Route::get('departments/export/data', [DepartmentController::class, 'export'])->name('departments.export');
    Route::get('employees/export/data', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('companies/export/data', [CompanyController::class, 'export'])->name('companies.export');

    //import routes
    Route::post('customers/import/data', [CustomerController::class, 'import'])->name('customers.import');
    Route::post('departments/import/data', [DepartmentController::class, 'import'])->name('departments.import');
    Route::post('employees/import/data', [EmployeeController::class, 'import'])->name('employees.import');
    Route::post('companies/import/data', [CompanyController::class, 'import'])->name('companies.import');


    //list routes post
    Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');

    //card routes
    Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
    Route::get('customers-card', [CustomerController::class, 'card'])->name('customers.cards');
    Route::get('employees-card', [EmployeeController::class, 'card'])->name('employees.cards');
    Route::get('departments-card', [DepartmentController::class, 'card'])->name('departments.cards');

    Route::post('deal/schedule',[DealController::class,'schedule'])->name('deals.schedule');
    Route::get('sale/activity',[SaleActivityController::class,'index'])->name('activity.index');
    Route::get('sale/activity/create',[SaleActivityController::class,'create'])->name('activity.create');
    Route::post('sale/activity/create',[SaleActivityController::class,'store'])->name('activity.store');
    Route::get('sale/activity/show/{id}',[SaleActivityController::class,'show'])->name('activity.show');
    Route::post('sale/activity/comment',[SaleActivityController::class,'post_comment'])->name('activity.comment');
    Route::post('sale/activity/addfollower',[SaleActivityController::class,'follower'])->name('activity.addfollowed');
    Route::post('sale/activity/unfollow',[SaleActivityController::class,'unfollower'])->name('activity.unfollowed');
    Route::get('activity/read/{id}',[SaleActivityController::class,'read'])->name('read');
    //stock
    Route::get('stockin',[StockTransactionController::class,'stockin_form'])->name('showstockin');
    Route::post('stockin',[StockTransactionController::class,'stock_in'])->name('stockin');
    Route::get('stockout',[StockTransactionController::class,'stockout_form'])->name('showstockout');
    Route::post('stockout',[StockTransactionController::class,'stockout'])->name('stockout');
    Route::get('stocks/index',[StockTransactionController::class,'index'])->name('stocks.index');
    Route::get('stock/transfer',[StockTransactionController::class,'transfer'])->name('show.transfer');
    Route::post('transfer',[StockTransactionController::class,'stock_transfer'])->name('stocks.transfer');
    Route::get('transfer/index',[StockTransactionController::class,'transfer_record'])->name('transfer.index');
    Route::get('stocks',[StockTransactionController::class,'stock'])->name('stocks');
    Route::post('stock/import',[StockTransactionController::class,'import'])->name('stocks.import');
    Route::get('stock/batch/{p_id}',[StockTransactionController::class,'batch'])->name('stock.batch');
    Route::get('ecommerce/stock/index',[StockTransactionController::class,'ecommerce_stock'])->name('ecommerce_stock');
    //sale dashboard
    Route::resource('saletargets',SaleTargetController::class);
    Route::get('sale/dashboard',[SaleTargetController::class,'index'])->name('sale.dashboard');
    Route::get('sale/performance',[ReportController::class,'SalePerformance'])->name('report.saleprformance');
    Route::get('sale/dashbord/search',[SaleTargetController::class,'search'])->name('search.saledashboard');
    //finance
    Route::resource('expenseclaims',ExpenseClaimController::class);
    Route::get('expenseclaims/status/{status}/{id}',[ExpenseClaimController::class,'status'])->name('exp_claim.status');
    Route::get('expclaims/cash/claim/{id}',[ExpenseClaimController::class,'CashClaim'])->name('cash.claim');
    Route::post('expenseclaims/comment/{id}',[ExpenseClaimController::class,'comment'])->name('exp_claim.comment');
    Route::get('expenseclaims/comment/delete/{id}',[ExpenseClaimController::class,'commentDelete'])->name('exp_claim.comment_delete');
    Route::get('add/permission',[RoleController::class,'permission_create'])->name('permission.create');
    Route::post('add/permission',[RoleController::class,'permission_store'])->name('permission.store');
    //

    //


    Route::resource('purchase_request',PurchaseRequestController::class);//
    Route::post('pr/status/{id}',[PurchaseRequestController::class,'status_change'])->name('pr.status');


    Route::resource('rfqs',RFQController::class);//
    Route::get('prepare/rfqs/{id}',[RFQController::class,'prepare_rfq'])->name('rfq.prepare');

    Route::get('inventory',[InventoryController::class,'index'])->name('inventory.index');
    Route::get('rfq/receipt/process/',[InventoryController::class,'recipt_proceslist'])->name('receiptprocess');
    Route::get('receipt/show/{id}',[InventoryController::class,'show'])->name('receipt.show');
    Route::post('receipt/product/validate/{id}',[InventoryController::class,'product_validate'])->name('product.validate');
    Route::get('reedit/{id}',[InventoryController::class,'reedit'])->name('receipt.rededit');

    Route::resource('bills',BillController::class);//
    Route::post('bill/item/store',[\App\Http\Controllers\BillItemController::class,'store'])->name('billitems.store');
    Route::post('bill/item/update/{id}',[\App\Http\Controllers\BillItemController::class,'update'])->name('billitems.update');
    Route::get('bill/item/delete/{id}',[\App\Http\Controllers\BillItemController::class,'destroy'])->name('destroy.billitem');
    Route::get('purchase/order/create/{rfq_id}',[\App\Http\Controllers\PurchaseOrderController::class,'rfq_to_po_create'])->name('purchase.orders');
    Route::resource('purchaseorders',\App\Http\Controllers\PurchaseOrderController::class);//

    Route::get('po/confirm/{id}',[\App\Http\Controllers\PurchaseOrderController::class,'confirm'])->name('purchaseorders.confirm');
    Route::get('add/to/stock/{id}',[InventoryController::class,'receipt'])->name('to.stock');
    Route::get('po/to/bill/create/{po_id}',[BillController::class,'po_to_bill'])->name('po.bill');
    Route::get('delivery/to/bill/create/{deli_id}',[BillController::class,'deli_bill'])->name('delivery.bill');
    Route::get('requestation/cc',[ApprovalController::class,'cc_requestation'])->name('requestation.cc');
    Route::get('requestation/search',[ApprovalController::class,'requestatin_search'])->name('requestation.search');
    Route::get('approval/search',[ApprovalController::class,'approval_search'])->name('approval.search');
    Route::get('cc/search',[ApprovalController::class,'cc_search'])->name('cc.search');
    Route::get('product/variant/create',[ProductController::class,'create_variant'])->name('create.variant');
    Route::post('product/variant/store',[ProductController::class,'variant_add'])->name('variant.store');
    Route::post('product/variant/update/{id}',[ProductController::class,'update_variant'])->name('variant.update');
    Route::get('barcode/generate',[\App\Http\Controllers\BarcodeController::class,'barcode'])->name('barcode.generate');
    Route::get('barcode/create',[\App\Http\Controllers\BarcodeController::class,'barcodecreate'])->name('barcode.create');
    Route::resource('sellingunits',SellingUnitController::class);
    Route::resource('discount_promotions',DiscountPromotionController::class);
    Route::get('variant/show/{id}',[ProductController::class,'show_variant'])->name('show.variant');
    Route::get('stockout/index',[StockTransactionController::class,'stockoutindex'])->name('stock.out.index');

    Route::get('stockout/approve/{id}',[StockTransactionController::class,'approve'])->name('stockout.approve');
    Route::get('stock/export',[StockTransactionController::class,'export'])->name('stock.export');
    Route::get('product/price/index',[SellingUnitController::class,'price_list'])->name('add.index');
    Route::post('product/price/store',[SellingUnitController::class,'store_price'])->name('store.price');
    Route::get('add/price',[SellingUnitController::class,'price_add'])->name('add_price');
    Route::get('price/edit/{id}',[SellingUnitController::class,'price_edit'])->name('edit_price');
    Route::get('product/price/delete/{id}',[SellingUnitController::class,'price_destory'])->name('sellprice.destroy');
    Route::post('product/price/update/{id}',[SellingUnitController::class,'update_price'])->name('sellprice.update');
    Route::get('retail/invoice/create',[InvoiceController::class,'retail_inv'])->name('invoice.rental');
    Route::get('foc/index',[ProductController::class,'focproduct'])->name('foc.index');
    Route::get('demage/index',[StockTransactionController::class,'damage'])->name('damage.index');
    Route::post('stock/update/{p_id}',[StockTransactionController::class,'update'])->name('stock.update');
    Route::get('stock/update/history/{id}',[StockTransactionController::class,'history'])->name('update.history');
    Route::get('stock/transaction/search',[StockTransactionController::class,'stockfilter'])->name('stock.search');
    Route::get('price/{status}/{id}',[SellingUnitController::class,'price_active'])->name('price.active');
    Route::resource('advancepayments',AdvancePaymentController::class)->only('create','store','edit','update','destroy');
    Route::resource('officebranch',OfficeBranchController::class);
    Route::get('transaction/approve/{id}/{type}',[TransactionController::class,'account_update'])->name('transaction.approve');
    Route::get('advance/make/transaction/{id}',[AdvancePaymentController::class,'maketransaction'])->name('advance.maketransaction');
//Report route
    Route::get('selling/report',[SaleReportController::class,'sale_report'])->name('sale.report');
    Route::get('income/report',[ReportController::class,'income'])->name('report.income');
    Route::get('cash/inhand/report',[ReportController::class,'cash_in_hand'])->name('report.inhand');
    Route::get('cash/inemp/report',[ReportController::class,'cash_in_emp'])->name('report.inemp');
    Route::get('expense/report',[ReportController::class,'expense'])->name('report.expense');
    Route::get('credit/purchase/report',[ReportController::class,'credit_purchase'])->name('credit.purchase');
    Route::get('payment/purchase/report',[ReportController::class,'payment_purchase'])->name('payment.purchase');
    Route::get('stock/report',[ReportController::class,'stock'])->name('report.stock');
    Route::get('daily/advancepayment/report',[ReportController::class,'advancedaily'])->name('report.advancepay');
    Route::get('reports',[ReportController::class,'reportpage'])->name('reports');
    Route::get('stock/in/report',[ReportController::class,'stockin'])->name('report.stockin');
    Route::get('stock/out/report',[ReportController::class,'stockout'])->name('report.stockout');
    Route::get('report/bills',[ReportController::class,'bill'])->name('report.bill');
    Route::get('report/payment',[ReportController::class,'payment'])->name('report.payment');
    Route::get('report/payable',[ReportController::class,'payable'])->name('report.payable');
    Route::get('report/receivable',[ReportController::class,'receivable'])->name('report.receivable');
    Route::get('report/stockreturn',[ReportController::class,'stockreturn'])->name('report.return');
    Route::get('report/stocktansfer',[ReportController::class,'stocktransfer'])->name('report.transfer');
    Route::get('report/damage',[ReportController::class,'damage'])->name('report.damage');
    Route::get('report/foc',[ReportController::class,'foc'])->name('report.foc');




    Route::get('retail/sale/quotation',[QuotationController::class,'retailSale'])->name('quotations.retail');
    Route::resource('product_brand',ProductBrandController::class);
//    Route::post('/add/emp/branch',[OfficeBranchController::class,'addemp'])->name('addemp');
    Route::get('product/export',[ProductController::class,'export'])->name('product.export');
    Route::post('product/import',[ProductController::class,'import'])->name('product.import');
    Route::get('employee/search',[EmployeeController::class,'search'])->name('employee.search');
    Route::get('sent/mail/{po_id}',[\App\Http\Controllers\PurchaseOrderController::class,'send'])->name('po_mail.prepare');
    Route::post('po/mail/send',[\App\Http\Controllers\PurchaseOrderController::class,'sending'])->name('po_mail.sent');
    Route::get('main/customer',[CustomerController::class,'customer'])->name('customer');


    Route::get('inv/view/{type}',[InvoiceController::class,'invoice_view'])->name('invoice.list');
    Route::resource('binlookup',\App\Http\Controllers\BinLookUpController::class);
    Route::resource('stockreturn',\App\Http\Controllers\StockReturnController::class);
    Route::get('inv/export/{type}',[InvoiceController::class,'export'])->name('invoices.export');
    Route::resource('discount',\App\Http\Controllers\AmountDiscountController::class);
    Route::get('transaction/export',[TransactionController::class,'export'])->name('transactions.export');

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
Route::middleware(['guadcheck'])->group(function () {
    Route::resource('deliveries', ShippmentController::class);
    Route::resource('advancepayments',AdvancePaymentController::class)->only('index','show');
    Route::get('delivery/transaction',[ShippmentController::class,'transaction'])->name('delivery.transaction');


});
Route::middleware(['auth:customer'])->group(function () {
    Route::get('customer/home/', [CustomerProtal::class, 'home'])->name('home');
    Route::get('customer/quotation', [CustomerProtal::class, 'quotation'])->name('customer.quotation');
    Route::get('customer/password/change/',[CustomerProtal::class,'change_password'])->name('customers.changepassword');
    Route::get('customer/order', [CustomerProtal::class, 'dashboard'])->name('customer.orders');
    Route::get('customer/order/{id}', [CustomerProtal::class, 'dashboard'])->name('order.show');
    Route::resource('orders', SaleOrderController::class);
    Route::post('customer/password/update/{id}',[CustomerProtal::class,'password_update'])->name('password.update');
    Route::post('delivery/comment',[ShippmentController::class,'comment'])->name('delivery.comment');
    Route::get('delivery/state/{state}/{id}',[ShippmentController::class,'statuschange'])->name('delivery.state');
    Route::get('customer/invoice',[CustomerProtal::class,'invoice'])->name('customer.invoice');
    Route::get('customer/invoice/show/{id}',[CustomerProtal::class,'invoice_show'])->name('customer.invoice_show');
    Route::get('customer/ticket',[CustomerProtal::class,'ticket'])->name('customer.ticket');
    Route::get('customer/ticket/show/{id}',[CustomerProtal::class,'ticket_show'])->name('customer.ticket_show');


});
Route::get('password/reset',[EmployeeController::class,'reset_form'])->name('reset.password');
Route::post('password/reset',[EmployeeController::class,'password_reset'])->name('password.reset');
Route::get('test', function () {
//    $provided = [
//        'Shirt' => [
//            'color' => ['green', 'red','white'],
//            'size' => ['Small', 'Medium'],
//            'other'=>['']
//        ],
//    ]; // Reduced the provided data to reduce the output for sample purposes.
////dd($provided);
//    $result = [];
//    foreach ($provided as $type => $attributes) {
//        foreach ($attributes['size'] as $color) {
//            foreach ($attributes['color'] as $size) {
//                foreach ($attributes['other'] as $oth) {
//                    $result[] = compact( 'color', 'size','oth');
//                }
//            }
//        }
//    }
//
//    dd($result);
//    dd(str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT));
    return view('test');
})->name('test');

//Route::get('send', [HomeController::class,'sendNotification']);
//Route::get('piect/search', [TicketPieChartReport::class, 'filter'])->name('piechart.filter');
//list routes post
Route::put('roles/assign-permission/{id}', [RoleController::class, 'assignPermission'])->name('roles.assignPermission');
Route::get('companies-card', [CompanyController::class, 'card'])->name('companies.cards');
Route::resource('request_tickets', RequestTicket::class)->only('create', 'store');
Route::get('delivery/customer/receipt/{id}',[ShippmentController::class,'receipt'])->name('receipt.confirm');
//list routes


Route::get('delivery/tracking/{uuid}',[ShippmentController::class,'tracking'])->name('tracking');

//new
Route::resource('bank_transfers',\App\Http\Controllers\BankTransferController::class);







//Route::get('stockout/show/{id}',[StockTransactionController::class,'show_stockout'])->name('stockout.show');
