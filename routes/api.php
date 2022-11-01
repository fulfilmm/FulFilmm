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
    Route::get('invoice/{id}/items',[\App\Http\Controllers\Api\Invoice_Mobile\MobileInvoiceItemController::class,'show']);
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
    Route::get('sales/dashboard',[\App\Http\Controllers\Api\SaleDashboardController::class,'dashboard']);
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


