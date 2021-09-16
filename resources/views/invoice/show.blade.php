@extends('layout.mainlayout')
@section('title','Invoice Detail ')
@section('content')
    {{--<link rel="stylesheet" href="{{url(asset('css/invoice_css/custom.css'))}}">--}}
    {{--<link rel="stylesheet" href="{{url(asset('css/invoice_css/element.css'))}}">--}}
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <!-- Page Content -->
    <div class="container-fluid" ">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Invoice</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="header" class="">
        <div class=" content-layout">
            <div class="header-body">
                <div class="row py-4 align-items-center">
                    <div class="col-xs-12 col-sm-4 col-md-5 align-items-center"><h2
                                class="d-inline-flex mb-0 long-texts">Invoice: {{$detail_inv->invoice_id}}</h2></div>
                    <div class="col-xs-12 col-sm-8 col-md-7">
                        <div class="text-right">
                            <div class="dropup header-drop-top">
                                <button type="button" data-toggle="dropdown" aria-expanded="false"
                                        class="btn btn-white btn-sm"><i class="fa fa-chevron-down"></i>&nbsp; More
                                    Actions
                                </button>
                                <div role="menu" class="dropdown-menu">
                                    <div class="dropdown-divider"></div>
                                    <a href="https://app.akaunting.com/142258/sales/invoices/1201302/print"
                                       target="_blank" class="dropdown-item">
                                        Print
                                    </a> <a href="https://app.akaunting.com/142258/sales/invoices/1201302/pdf"
                                            class="dropdown-item">
                                        Download PDF
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" title="Delete" class="dropdown-item action-delete">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <a href="https://app.akaunting.com/142258/sales/invoices/create"
                               class="btn btn-white btn-sm">
                                Add New
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="font-size: inherit !important;">
        <div class="col-md-2">
            Status
            <br> <strong><span class="float-left"><span class="badge badge-primary">
                       {{$detail_inv->status}}
                    </span></span></strong> <br><br></div>
        <div class="col-md-6">
            Customer
            <br> <strong><span class="float-left"><a href="https://app.akaunting.com/142258/sales/customers/1005081">
                      {{$detail_inv->customer->name}}
                    </a></span></strong> <br><br></div>
        <div class="col-md-2">
            Amount due
            <br> <strong><span class="float-left">
                    157,500.00 K                </span></strong> <br><br></div>
        <div class="col-md-2">
            Due on
            <br> <strong><span class="float-left">
                    {{\Illuminate\Support\Carbon::parse($detail_inv->due_date)->toFormattedDateString()}}               </span></strong> <br><br></div>
    </div>
    {{--</div>--}}
    {{--<div class="col-auto float-right ml-auto">--}}
    {{--<div class="btn-group btn-group-sm">--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    <!-- /Page Header -->
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="card">--}}
    {{--<div class="card-body">--}}
    {{--<div class="row">--}}
    {{--<div class="col-sm-6 m-b-20">--}}
    {{--<img src="img/logo2.png" class="inv-logo" alt="">--}}
    {{--<ul class="list-unstyled">--}}
    {{--<li>{{$company->name ?? ''}}</li>--}}
    {{--<li>{{$company->address??''}},</li>--}}
    {{--<li>GST No:</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--<div class="col-sm-6 m-b-20">--}}
    {{--<div class="invoice-details">--}}
    {{--<h3 class="text-uppercase">Invoice #</h3>--}}
    {{--<ul class="list-unstyled">--}}
    {{--<li>Date: <span></span></li>--}}
    {{--<li>Due date: <span></span></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">--}}
    {{--<h5>Invoice to:</h5>--}}
    {{--<ul class="list-unstyled">--}}
    {{--<li><h5><strong></strong></h5></li>--}}
    {{--<li><span></span></li>--}}
    {{--<li></li>--}}
    {{--<li>Coosada, AL, 36020</li>--}}
    {{--<li>United States</li>--}}
    {{--<li></li>--}}
    {{--<li><a href="#"></a></li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    										{{--<div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">--}}
    											{{--<span class="text-muted">Payment Details:</span>--}}
    											{{--<ul class="list-unstyled invoice-payment-details">--}}
    												{{--<li><h5>Total Due: <span class="text-right">$8,750</span></h5></li>--}}
    												{{--<li>Bank name: <span>Profit Bank Europe</span></li>--}}
    												{{--<li>Country: <span>United Kingdom</span></li>--}}
    												{{--<li>City: <span>London E1 8BF</span></li>--}}
    												{{--<li>Address: <span>3 Goodman Street</span></li>--}}
    												{{--<li>IBAN: <span>KFH37784028476740</span></li>--}}
    												{{--<li>SWIFT code: <span>BPT4E</span></li>--}}
    											{{--</ul>--}}
    										{{--</div>--}}
    {{--</div>--}}
    {{--<div class="table-responsive">--}}
    {{----}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--<div>--}}
    {{--<div class="row invoice-payment">--}}
    {{--<div class="col-sm-7">--}}
    {{--</div>--}}
    {{--<div class="col-sm-5">--}}
    {{--<div class="m-b-20">--}}
    {{--<div class="table-responsive no-border">--}}
    {{--<table class="table mb-0">--}}
    {{--<tbody>--}}
    {{--<tr>--}}
    {{--<th>Total:</th>--}}
    {{--<td class="text-right text-primary"><h5></h5></td>--}}
    {{--</tr>--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
   {{----}}
    {{--</div>--}}

    <div class="card">
        <div class="card-body">
            <div data-timeline-content="axis" data-timeline-axis-style="dashed" class="timeline timeline-one-side">
                <div class="timeline-block"><span class="timeline-step badge-primary"><i class="la la-plus text-white"></i></span>
                    <div class="timeline-content"><h2 class="font-weight-500">
                            Create Invoice
                        </h2>
                        <small>
                            Status:
                        </small>
                        <small>
                            Created on {{$detail_inv->created_at->toFormattedDateString()}}
                        </small>
                        <div class="mt-3"><a href="https://app.akaunting.com/142258/sales/invoices/1201302/edit"
                                             class="btn btn-primary btn-sm btn-alone header-button-top">
                                Edit
                            </a></div>
                    </div>
                </div>
                <div class="timeline-block"><span class="timeline-step badge-danger"><i
                                class="la la-envelope text-white"></i></span>
                    <div class="timeline-content"><h2 class="font-weight-500">
                            Send Invoice
                        </h2>
                        <small>
                            Status:
                        </small>
                        <small>
                            Not sent
                        </small>
                        <div class="mt-3"><a href="https://app.akaunting.com/142258/sales/invoices/1201302/sent"
                                             class="btn btn-white btn-sm header-button-top">
                                Mark Sent
                            </a>
                            <a href="{{route('invoice.sendmail',$detail_inv->id)}}"><button type="button"
                                    class="el-tooltip btn btn-danger btn-sm btn-tooltip disabled header-button-top"
                                    aria-describedby="el-tooltip-9140" tabindex="0">
                                Send Email
                            </button>
                            </a>
                            <a href="https://app.akaunting.com/142258/signed/invoices/1201302?signature=4b75ab08f681bfb43e37e90a7d50fcd207d2819ebe4d53671d59e93d7018998a"
                               target="_blank" class="btn btn-white btn-sm header-button-top">
                                Share
                            </a></div>
                    </div>
                </div>
                <div class="timeline-block"><span class="timeline-step badge-success"><i
                                class="la la-money text-white"></i></span>
                    <div class="timeline-content"><h2 class="font-weight-500">
                            Get Paid
                        </h2>
                        <small>
                            Status:
                        </small>
                        <small>
                            Awaiting payment
                        </small>
                        <div class="mt-3"><a href="https://app.akaunting.com/142258/sales/invoices/1201302/paid"
                                             class="btn btn-white btn-sm header-button-top">
                                Mark Paid
                            </a>
                            <button id="button-payment" class="btn btn-success btn-sm header-button-bottom">
                                Add Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pb-4 mx-0 card-header-border">
                        <div class="col-lg-12 mb-3">
                            <img class="avatar avatar-50 is-squared"
                                 src="https://templates.iqonic.design/datum/laravel/public/images/logo-dark.png">
                        </div>
                        <div class="col-lg-6">
                            <div class="text-left">
                                <h5 class="font-weight-bold mb-2">Invoice number</h5>
                                <p class="mb-0">{{$detail_inv->invoice_id}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right">
                                <h5 class="font-weight-bold mb-2">Invoice Date</h5>
                                <p class="mb-0">{{\Illuminate\Support\Carbon::parse($detail_inv->invoice_date)->toFormattedDateString()}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4 pb-5 mx-0">
                        <div class="col-lg-6">
                            <div class="text-left">
                                <h5 class="font-weight-bold mb-3">Invoice From</h5>
                                <p class="mb-0 mb-1">Chris Wood</p>
                                <p class="mb-0 mb-1">4183 Forest Avenue</p>
                                <p class="mb-0 mb-1">New York</p>
                                <p class="mb-0 mb-1">10011</p>
                                <p class="mb-0 mb-2">USA</p>
                                <p class="mb-0 mb-2">chris.wood@blueberry.com</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-right">
                                <h5 class="font-weight-bold mb-3">Invoice To</h5>
                                <p class="mb-0 mb-1">{{$detail_inv->customer->company->name}}</p>
                                <p class="mb-0 mb-1">{{$detail_inv->customer->name}}</p>
                                <p class="mb-0 mb-1">{{$detail_inv->customer->address}}</p>
                                <p class="mb-0 mb-2">{{$detail_inv->customer->phone}}</p>
                                <p class="mb-0 mb-2">{{$detail_inv->customer->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ITEM</th>
                                                <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                                <th>UNIT COST</th>
                                                <th>Tax(%)</th>
                                                <th>Discount</th>
                                                <th>Discount Type</th>
                                                <th>QUANTITY</th>
                                                <th class="text-right">TOTAL</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($invoic_item as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->product->name}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$item->description}}</td>
                                                    <td>{{$item->unit_price}}
                                                    <td>{{$item->tax_id}}%</td>
                                                    <td>{{$item->discount}}</td>
                                                    <td>{{$item->discount_type}}</td>
                                                    <td>{{$item->quantity}}</td>
                                                    <td class="text-right">{{$item->total}}</td>
                                                    <td class="text-right">{{$item->currency_unit}}</td>
                                                </tr>
                                        @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-end mb-2">
                                        Total: <p class="ml-2 mb-0 font-weight-bold">{{$invoic_item[0]->currency_unit}}{{$grand_total}}</p>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex flex-wrap justify-content-between align-items-center p-4">
                                <div class="flex align-items-start flex-column">
                                    <h6>Notes</h6>
                                    <p class="mb-0 my-2">{{$detail_inv->other_information}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card">
                    <div id="accordion-histories-header" data-toggle="collapse" data-target="#accordion-histories-body"
                         aria-expanded="true" aria-controls="accordion-histories-body" class="card-header"><h4
                                class="mb-0">Histories</h4></div>
                    <div id="accordion-histories-body" aria-labelledby="accordion-histories-header"
                         class="hide collapse show" style="">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                <tr class="row table-head-line">
                                    <th class="col-xs-4 col-sm-3">
                                        Date
                                    </th>
                                    <th class="col-xs-4 col-sm-3 text-left">
                                        Status
                                    </th>
                                    <th class="col-xs-4 col-sm-6 text-left long-texts">
                                        Description
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="row align-items-center border-top-1 tr-py">
                                    <td class="col-xs-4 col-sm-3">
                                        08 Sep 2021
                                    </td>
                                    <td class="col-xs-4 col-sm-3 text-left">
                                        Draft
                                    </td>
                                    <td class="col-xs-4 col-sm-6 text-left long-texts">
                                        INV-00009 added!
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="accordion">
                <div class="card">
                    <div id="accordion-transactions-header" data-toggle="collapse"
                         data-target="#accordion-transactions-body" aria-expanded="false"
                         aria-controls="accordion-transactions-body" class="card-header collapsed"><h4 class="mb-0">
                            Transactions</h4></div>
                    <div id="accordion-transactions-body" aria-labelledby="accordion-transactions-header"
                         class="hide collapse" style="">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover">
                                <thead class="thead-light">
                                <tr class="row table-head-line">
                                    <th class="col-xs-4 col-sm-3">
                                        Date
                                    </th>
                                    <th class="col-xs-4 col-sm-3">
                                        Amount
                                    </th>
                                    <th class="col-sm-3 d-none d-sm-block">
                                        Account
                                    </th>
                                    <th class="col-xs-4 col-sm-3">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="4">
                                        <div id="datatable-basic_info" role="status" aria-live="polite"
                                             class="text-muted nr-py">
                                            No records.
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /Page Content -->
@endsection
