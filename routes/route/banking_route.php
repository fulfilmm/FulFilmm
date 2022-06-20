<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvancePaymentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('bills', BillController::class);
    Route::resource('accounts', AccountController::class);
    Route::get('add/revenue', [TransactionController::class, 'addrevenue'])->name('income.create');
    Route::get('revenue', [TransactionController::class, 'revenue_index'])->name('revenue');
    Route::get('expense', [TransactionController::class, 'expense_index'])->name('expense');
    Route::post('add/revenue', [TransactionController::class, 'store_revenue'])->name('income.store');
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('add/expense', [TransactionController::class, 'expense'])->name('expense.create');
    Route::post('store/expense', [TransactionController::class, 'expense_store'])->name('expense.store');
    Route::get('transaction/show/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('transaction/export', [TransactionController::class, 'export'])->name('transactions.export');
    Route::post('transfer/branch', [TransactionController::class, 'transer_branch'])->name('transfer.branch');
    Route::get('transaction/approve/{id}/{type}', [TransactionController::class, 'account_update'])->name('transaction.approve');
    Route::get('advance/make/transaction/{id}', [AdvancePaymentController::class, 'maketransaction'])->name('advance.maketransaction');
    Route::resource('advancepayments', AdvancePaymentController::class)->only('create', 'store', 'edit', 'update', 'destroy');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('revenue/delete/{id}',[TransactionController::class,'revenue_delete'])->name('revenue.delete');
    Route::get('revenue/edit/{id}',[TransactionController::class,'revenue_edit'])->name('revenue.edit');
    Route::post('revenue/update/{id}',[TransactionController::class,'revenue_update'])->name('revenue.update');
    Route::get('expense/delete/{id}',[TransactionController::class,'expense_delete'])->name('expense.delete');
    Route::get('expense/edit/{id}',[TransactionController::class,'expense_edit'])->name('expense.edit');
    Route::post('expense/update/{id}',[TransactionController::class,'expense_update'])->name('expense.update');
    Route::post('add/category',[TransactionController::class,'add_category']);
    Route::post('account/enable/{id}',[AccountController::class,'enable'])->name('account.enable');
    Route::get('transaction/category/',[TransactionController::class,'category'])->name('transaction.category');
    Route::post('category/transaction/update/{id}',[TransactionController::class,'update_cat'])->name('transaction_category.update');
    Route::get('category/transaction/delete/{id}',[TransactionController::class,'delete_cat'])->name('transaction_category.delete');
    Route::resource('revenuebudget',\App\Http\Controllers\RevenueBudgetController::class);
    Route::resource('expensebudget',\App\Http\Controllers\ExpenseBudgetController::class);
    Route::resource('chartofaccount',\App\Http\Controllers\ChartOfAccountController::class);
    Route::get('coatype',[\App\Http\Controllers\ChartOfAccountController::class,'coatype_index'])->name('coatype.index');
    Route::post('coatype',[\App\Http\Controllers\ChartOfAccountController::class,'coatype'])->name('coatype.store');
    Route::post('coatype/update/{id}',[\App\Http\Controllers\ChartOfAccountController::class,'type_update'])->name('coatype.update');
    Route::get('coatype/delete/{id}',[\App\Http\Controllers\ChartOfAccountController::class,'type_destory'])->name('coatype.delete');
});