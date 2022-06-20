<?php

use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderlineController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('quotations', QuotationController::class);
    Route::resource('quotation_items', OrderlineController::class);
    Route::resource('leads', LeadController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');
    Route::get("/myfollowed/lead", [LeadController::class, 'my_followed'])->name('leads.myfollowed');
    Route::get("/qualified/{id}", [LeadController::class, 'qualified'])->name("qualified");
    Route::resource('deals', DealController::class)->only('index', 'create', 'edit', 'store', 'destroy', 'update');
    Route::post('deal/schedule', [DealController::class, 'schedule'])->name('deals.schedule');
    Route::get('retail/sale/quotation', [QuotationController::class, 'retailSale'])->name('quotations.retail');
});
Route::middleware(['meeting_view_relative_emp', 'auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::resource('leads', LeadController::class)->only('show');
    Route::resource('deals', DealController::class)->only('show');
});
Route::middleware(['auth:employee'])->group(function () {
    Route::post("/lead/post/comment", [LeadController::class, 'comment'])->name('leads.comment');
    Route::post("/lead/followed/", [LeadController::class, 'lead_follower'])->name('leads.followed');
    Route::post("/update/followed/", [LeadController::class, 'unfollower'])->name('unfollowed');
    Route::post('lead/activity/schedule', [LeadController::class, 'activity_schedule'])->name('activity.schedule');
    Route::get('activity/delete/{id}', [LeadController::class, 'delete_schedule'])->name('delete_schedule');
    Route::post('discard', [QuotationController::class, 'discard'])->name('quotations.discard');
    Route::post("/tags/create", [LeadController::class, 'tag_add'])->name('tagadd');
    Route::get("/workdone/{id}", [LeadController::class, 'work_done'])->name('work.done');
    Route::get("/deal/change/{status}/{id}", [DealController::class, 'sale_stage_change'])->name('deals.status_change');
    Route::post("/deal/company/create", [DealController::class, 'company_create'])->name('company_create');
    Route::get('/quotations/sendemail/{id}', [QuotationController::class, 'sendEmail'])->name('sendemail');
    Route::post('/quotations/sendmail', [QuotationController::class, 'email'])->name('quotations.mail');
    Route::get('/quotations/confirm/{id}', [QuotationController::class, 'confirm'])->name('quotations.confirm');
    Route::get('quotations/delete/{id}',[QuotationController::class,'destroy']);
    Route::post('deal/post/comment',[DealController::class,'comment'])->name('deals.comment');
    Route::get("deal/workdone/{id}", [DealController::class, 'workdone'])->name('schedule.done');
});