<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleReportController;

Route::get('selling/report',[SaleReportController::class,'sale_report'])->name('sale.report');
Route::get('income/report',[ReportController::class,'income'])->name('report.income');
Route::get('cash/inhand/report',[ReportController::class,'cash_in_hand'])->name('report.inhand');
Route::get('cash/inemp/report',[ReportController::class,'cash_in_emp'])->name('report.inemp');
Route::get('expense/report',[ReportController::class,'expense'])->name('report.expense');
Route::get('credit/purchase/report',[ReportController::class,'credit_purchase'])->name('credit.purchase');
Route::get('payment/purchase/report',[ReportController::class,'payment_purchase'])->name('payment.purchase');
Route::get('daily/advancepayment/report',[ReportController::class,'advancedaily'])->name('report.advancepay');
Route::get('reports',[ReportController::class,'reportpage'])->name('reports');
Route::get('report/bills',[ReportController::class,'bill'])->name('report.bill');
Route::get('report/payment',[ReportController::class,'payment'])->name('report.payment');
Route::get('report/payable',[ReportController::class,'payable'])->name('report.payable');
Route::get('report/receivable',[ReportController::class,'receivable'])->name('report.receivable');
Route::get('report/damage',[ReportController::class,'damage'])->name('report.damage');
Route::get('report/foc',[ReportController::class,'foc'])->name('report.foc');