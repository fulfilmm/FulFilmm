<?php

use App\Http\Controllers\CaseTypeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\RequestTicket;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPieChartReport;
use App\Http\Controllers\TicketSender;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:employee', 'authorize', 'ownership'])->group(function () {
    Route::post("ticket/assign", [TicketController::class, 'assignee'])->name('tickets.assign');
    Route::post('status/{id}', [TicketController::class, 'status_change'])->name('change_status');
    Route::post("reassign/ticket", [TicketController::class, 'reassign'])->name('reassign');
    Route::get("/piechart/report", [TicketPieChartReport::class, 'index'])->name('piechart');
    Route::post('priority/change/{id}', [TicketController::class, 'priority_change'])->name('priority.change');
    Route::resource('request_tickets', RequestTicket::class);
    Route::get('open/ticket/{id}', [RequestTicket::class, 'openTicket'])->name('openticket');
    Route::post("add/new/customer", [DealController::class, 'add_newcustomer'])->name('add_new_customer');
    Route::resource('comments', CommentController::class);
    Route::resource('cases', CaseTypeController::class);
    Route::resource('priorities', PriorityController::class);
    Route::resource('senders', TicketSender::class);
    Route::resource('tickets', TicketController::class)->only('index', 'edit', 'create', 'store', 'destroy', 'update');
});
Route::middleware(['meeting_view_relative_emp', 'auth:employee', 'authorize', 'ownership'])->group(function () {

    Route::resource('tickets', TicketController::class)->only('show');


});
Route::middleware(['auth:employee'])->group(function () {
    Route::get('ticket/comment/delete/{id}', [TicketController::class, 'cmt_delete'])->name('ticket_cmt.delete');
    Route::get('followed/ticket', [TicketController::class, 'followed_ticket'])->name('followed.tickets');
    Route::post('ticket/comment/', [TicketController::class, 'postcomment'])->name('postcomment');
    Route::post('/add/more/follower', [TicketController::class, 'add_more_follower'])->name('addfollower');
});
Route::resource('request_tickets', RequestTicket::class)->only('create', 'store');