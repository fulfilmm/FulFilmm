<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ComplainTicket;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\MaintainController;
use App\Http\Controllers\Api\MaintainCheckController;
use App\Http\Controllers\Api\Invoice\InvoiceDataController;
use App\Http\Controllers\Api\Invoice\InvoiceDataItemController;

use App\Http\Controllers\Api\Invoice_Mobile\MobileInvoiceController;

use App\Http\Controllers\Api\Ecommerce\ProductAddController;
use App\Http\Controllers\Api\Ecommerce\ProductPromotionController;
use App\Http\Controllers\Api\Ecommerce\ProductBannerController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:api'])->prefix('auth')->group(function () {

    Route::resource('api_products',App\Http\Controllers\Api\ProductController::class);
    Route::resource('api_employees',App\Http\Controllers\Api\EmployeeController::class);
    Route::post('logout',[ApiAuthController::class,'logout'])->name('logout');
    Route::resource('api_customers', CustomerController::class);
    Route::get('mobile_branch',[CompanyController::class,'branches']);
    Route::get('mobile_region',[CompanyController::class,'region']);
    Route::get('mobile_zone',[CompanyController::class,'zone']);
    Route::get('taxes',[MobileInvoiceController::class,'taxes']);

    Route::resource("api_invoices",InvoiceController::class);
    Route::resource('api_companies',CompanyController::class);
//    Route::apiResource("invoice" , InvoiceDataController::class);
    Route::resource("mobile_invoice", MobileInvoiceController::class);
    Route::get('invoice/{id}/items/{type}',[\App\Http\Controllers\Api\Invoice_Mobile\MobileInvoiceItemController::class,'show']);
    Route::post('invoice/cancel/{id}',[MobileInvoiceController::class,'cancel']);
    Route::get('retail/invoice' , [App\Http\Controllers\Api\Invoice_Mobile\MobileInvoiceController::class,'retail']);
    Route::post('delete/shop',[\App\Http\Controllers\Api\SaleWayController::class,'remove_shop']);
    Route::post('add/new/shop',[\App\Http\Controllers\Api\SaleWayController::class,'add_shop']);
    Route::resource('sale_group',\App\Http\Controllers\Api\SaleGroupController::class);
    Route::post('add/sale_group/member',[\App\Http\Controllers\Api\SaleGroupController::class,'add_member']);
    Route::post('remove/sale_group/member',[\App\Http\Controllers\Api\SaleGroupController::class,'remove_member']);
    Route::resource('assign_saleway',\App\Http\Controllers\Api\WayAssignController::class);
    Route::post('check/in/{id}',[\App\Http\Controllers\Api\WayAssignController::class,'check']);
    Route::resource('shops',\App\Http\Controllers\Api\ShopRegister::class);
    Route::resource('complains',ComplainTicket::class)->only('create','store','index');
    Route::resource('expense_claims',\App\Http\Controllers\Api\ExpenseClaimController::class);
    Route::post('exp_claims_receive/{id}',[\App\Http\Controllers\Api\ExpenseClaimController::class,'receive']);
    Route::get('sales/dashboard',[\App\Http\Controllers\Api\SaleDashboardController::class,'dashboard']);
    Route::resource('api_assignments',\App\Http\Controllers\Api\AssignmentController::class);
    Route::get('api_assignments/follower/{id}',[\App\Http\Controllers\Api\AssignmentController::class,'followedAssignment']);
    Route::get('transaction/category/',[MobileInvoiceController::class,'transactionCategory']);
    Route::post('makePyament',[MobileInvoiceController::class,'makePayment']);
    Route::post('order/status/change/{status}/{id}',[\App\Http\Controllers\Api\OrderController::class,'status_change']);
    Route::post('order/assign/{id}',[\App\Http\Controllers\Api\OrderController::class,'assign']);
    Route::resource('api_departments',\App\Http\Controllers\Api\DepartmentController::class);
    Route::resource('group',\App\Http\Controllers\Api\GroupController::class);
    Route::resource('approval',\App\Http\Controllers\Api\ApprovalController::class);
    Route::resource('meeting',\App\Http\Controllers\Api\MeetingController::class);
    Route::get('expclaim/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'expenseClaimComment']);
    Route::get('assignment/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'assignmentCommentGet']);
    Route::get('order/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'orderCommentGet']);
    Route::get('activity/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'saleactivityCommentGet']);
    Route::post('expclaim/post/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'expclaimCommmentPost']);
    Route::post('assignment/post/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'assignmentCommentPost']);
    Route::post('order/post/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'orderCommentPost']);
    Route::post('activity/post/comment/{id}',[\App\Http\Controllers\Api\CommentController::class,'saleactivityCommentPost']);
    Route::resource('warehouse',\App\Http\Controllers\Api\WarehouseController::class);
    Route::get('meeting/member/{id}',[\App\Http\Controllers\Api\MeetingController::class,'meeting_members']);
    Route::get('meeting/minutes/{id}',[\App\Http\Controllers\Api\MeetingController::class,'minutes']);
    Route::resource('bookroom',\App\Http\Controllers\Api\BookRoomController::class);
    Route::get('allbooked',[\App\Http\Controllers\Api\BookRoomController::class,'allBooked']);
    Route::get('room',[\App\Http\Controllers\Api\BookRoomController::class,'getRoom']);
    Route::get('invited/meeting',[\App\Http\Controllers\Api\MeetingController::class,'inviteMeeting']);


    Route::get('test',function (){
       $aa=\Illuminate\Support\Facades\Auth::guard('api')->user()->role->name;
       return response()->json(['role'=>$aa]);
    });

    
    // Api for Ecommerce Application
    Route::apiResource('ecommerce_products_add', ProductAddController::class);
    Route::apiResource('ecommerce_products_promotion', ProductPromotionController::class);
    Route::apiResource('ecommerce_banner', ProductBannerController::class);

    Route::resource('revenues',\App\Http\Controllers\Api\RevenueController::class);
    Route::get('home',[\App\Http\Controllers\Api\HomeController::class,'index']);
    Route::get('categories',[App\Http\Controllers\Api\ProductController::class,'category']);
    Route::get('product/category/{id}/{sale_type}',[App\Http\Controllers\Api\ProductController::class,'product_category']);
    Route::get('products/{sale_type}',[App\Http\Controllers\Api\ProductController::class,'allProduct']);
    Route::resource('mobile_orders',\App\Http\Controllers\Api\OrderController::class);
    Route::resource('api_employees',\App\Http\Controllers\Api\EmployeeController::class);
    Route::resource('myexpense',\App\Http\Controllers\Api\MyexpenseController::class);
    Route::resource('api_expense_claim',\App\Http\Controllers\Api\ExpenseClaimController::class);
    Route::resource('api_salesactivities',\App\Http\Controllers\Api\SalesActivityController::class);
    Route::resource('quotation',\App\Http\Controllers\Api\QuotationController::class);
    Route::get('products/price/{sale_type}/{p_id}/{qty}',[\App\Http\Controllers\Api\ProductController::class,'getPrice']);
//    Route::
});

//Api for Car
Route::apiResource("car_data", CarController::class);
Route::apiResource("maintainance", MaintainController::class);
Route::apiResource("maintain_check", MaintainCheckController::class);
// Api for Invoice
Route::apiResource("invoice" , InvoiceDataController::class);
Route::get('invoice/sendmail/{id}',[InvoiceDataController::class , 'sending_form']);
Route::post("invoice/mail/send" , [InvoiceDataController::class, 'email']);
Route::post('invoice/status/{id}', [InvoiceDataController::class, 'status_change']);
Route::get('retail/invoice/create' , [InvoiceDataController::class, 'retail_inv']);
Route::post('/auth/login',[ApiAuthController::class,'login'])->name('login');


