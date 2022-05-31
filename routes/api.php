<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ComplainTicket;
use App\Http\Controllers\Api\CustomerController;
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
    Route::post('logout',[ApiAuthController::class,'login'])->name('logout');
    Route::resource('api_customers', CustomerController::class);

    Route::resource("api_invoices",InvoiceController::class);
//    Route::apiResource("invoice" , InvoiceDataController::class);

    Route::resource("mobile_invoice", MobileInvoiceController::class);
    Route::get('retail/invoice' , [App\Http\Controllers\Api\Invoice_Mobile\MobileInvoiceController::class,'retail']);

//    Route::resource("invoice_items",InvoiceItemController::class);
//    Route::get("invoice/sendmail/{id}",[InvoiceController::class,'sending_form'])->name('invoice.sendmail');
//    Route::post("invoice/mail/send",[InvoiceController::class,'email'])->name('send');
//    Route::post('invoice/status/{id}',[InvoiceController::class,'status_change'])->name('invoice.statuschange');

    Route::resource('complains',ComplainTicket::class)->only('create','store','index');
    Route::get('test',function (){
       $aa=\Illuminate\Support\Facades\Auth::guard('api')->user()->role->name;
       return response()->json(['role'=>$aa]);
    });

    
    // Api for Ecommerce Application
    Route::apiResource('ecommerce_products_add', ProductAddController::class);
    Route::apiResource('ecommerce_products_promotion', ProductPromotionController::class);
    Route::apiResource('ecommerce_banner', ProductBannerController::class);

    Route::resource('revenues',\App\Http\Controllers\Api\RevenueController::class);
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

