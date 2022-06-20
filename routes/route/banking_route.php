<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvancePaymentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TransactionController;
Route::resource('bills',BillController::class);
Route::resource('accounts',AccountController::class);
Route::get('add/revenue', [TransactionController::class, 'addrevenue'])->name('income.create');
Route::get('revenue',[TransactionController::class,'revenue_index'])->name('revenue');
Route::get('expense',[TransactionController::class,'expense_index'])->name('expense');
Route::post('add/revenue', [TransactionController::class, 'store_revenue'])->name('income.store');
Route::get('transactions',[TransactionController::class,'index'])->name('transactions.index');
Route::get('add/expense',[TransactionController::class,'expense'])->name('expense.create');
Route::post('store/expense',[TransactionController::class,'expense_store'])->name('expense.store');
Route::get('transaction/show/{id}',[TransactionController::class,'show'])->name('transactions.show');
Route::get('transaction/export',[TransactionController::class,'export'])->name('transactions.export');
Route::post('transfer/branch',[TransactionController::class,'transer_branch'])->name('transfer.branch');
Route::get('transaction/approve/{id}/{type}',[TransactionController::class,'account_update'])->name('transaction.approve');
Route::get('advance/make/transaction/{id}',[AdvancePaymentController::class,'maketransaction'])->name('advance.maketransaction');
Route::resource('advancepayments',AdvancePaymentController::class)->only('create','store','edit','update','destroy');