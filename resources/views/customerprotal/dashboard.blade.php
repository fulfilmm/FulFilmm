@extends('layouts.app')
@section('title','Dashboard')
@section('noti')
    <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{count($new_deli)}}</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                {{--                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    @foreach($new_deli as $alert)
                        <li class="notification-message">
                            <a href="{{route('deliveries.show',$alert->id)}}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details">{{$alert->employee->name??\Illuminate\Support\Facades\Auth::guard('employee')->user()->name}}
                                            <span class="noti-title">Assigned to you {{$alert->delivery_id}}</span></p>
                                        <p class="noti-time"><span class="notification-time">{{\Carbon\Carbon::parse($alert->created_at)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($alert->created_at)))}}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endsection
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/customercss/backend.css'))}}">
    <link rel="stylesheet" href="https://templates.iqonic.design/datum/laravel/public/css/custom.css">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-between">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb p-0">
                            <li class="breadcrumb-item "><a href="https://templates.iqonic.design/datum/laravel/public/customer"><h3>Welcome {{\Illuminate\Support\Facades\Auth::guard('customer')->user()->name}}</h3></a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb--3">
        <div class="col-md-3">
            <div class="card  border-0" style="background-color: #9fe984">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase  mb-0 text-white">General Paid</h5>
                            <div class="dropdown-divider"></div>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$data['paid_total']}}MMK</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background-color: #7de9e0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase text-muted mb-0 text-white">Open Invoice</h5>
                            <div class="dropdown-divider"></div>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$data['open']}} MMK</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card  border-0" style="background-color: #fc9d75">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase mb-0 text-white">Overdue Invoice</h5>
                            <div class="dropdown-divider"></div>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$data['overdue']}}MMK</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card  border-0" style="background-color: #d1d1ff">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-uppercase mb-0 text-white">Ticket</h5>
                            <div class="dropdown-divider"></div>
                            <span class="h2 font-weight-bold mb-0 text-white">{{$data['tickets']??''}} Tickets</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav tab-nav-pane nav-tabs pt-2 mb-0">
                        <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2 active" href="#invoice">Invoices</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="invoice" class="tab-pane fade show active">
                            {{--<div class="d-flex justify-content-between align-items-center p-3">--}}
                            {{--<h5>Invoice List</h5>--}}
                            {{--<button class="btn btn-secondary btn-sm">--}}
                            {{--<svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                            {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />--}}
                            {{--</svg>--}}
                            {{--Export--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <div class="table-responsive">
                                <table class="table data-table mb-0">
                                    <thead class="table-color-heading">
                                    <tr class="text-muted">
                                        <th scope="col">ID</th>
                                        <th scope="col">Date </th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--@dd($data['invoice'])--}}
                                    @foreach($data['invoice'] as $invoice)
                                        <tr>
                                            <td>{{$invoice->invoice_id}}</td>
                                            <td>{{$invoice->invoice_date}}</td>
                                            <td>
                                                {{$invoice->other_information}}
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    {{$invoice->status}}
                                                </p>
                                            </td>
                                            <td class="text-right">{{$invoice->grand_total}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backend Bundle JavaScript -->
    {{--<script src="https://templates.iqonic.design/datum/laravel/public/js/backend-bundle.min.js"></script>--}}
    <script src="{{url(asset('js/customerprotal_js/chart01.js'))}}"></script>

@endsection