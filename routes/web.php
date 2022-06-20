<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login\EmployeeAuthController as AuthController;


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

Route::get('/', [HomeController::class, 'index'])->middleware(['auth:employee']);
Route::resource('bank_transfers',\App\Http\Controllers\BankTransferController::class);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::get('employee/login',[AuthController::class,'employeelogin']);
Route::namespace('Auth\Login')->prefix('employees')->as('employees.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('emplogin');

});

    include('route/banking_route.php');
    include('route/stock_route.php');
    include('route/complaint_route.php');
    include('route/crm_route.php');
    include('route/customer_route.php');
    include('route/invoice_route.php');
    include('route/operation_route.php');
    include('route/people_route.php');
    include('route/purchase_route.php');
    include('route/report_route.php');
    include('route/sales_route.php');
    include('route/setting_route.php');
    include('route/customerprotal_route.php');
    include('route/caradmin_route.php');

Route::get('test', function () {
    return view('test');
})->name('test');
//Route::get('stockout/show/{id}',[StockTransactionController::class,'show_stockout'])->name('stockout.show');

