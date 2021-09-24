@extends('layout.mainlayout')
@section('title','Account')
@section('content')
    <div class="content container-fluid">
        <div class="page-header mt-2">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account</li>
                    </ul>
                </div>
                <div class="text-right">

                    <a href="{{route('accounts.edit',$account->id)}}" class="btn btn-success btn-sm">Edit</a>
                    <a href="{{route('accounts.create')}}" class="btn btn-success btn-sm">Add New</a>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-xl-3">
            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 font-weight-600">
                    Account Number
                    <small>{{$account->number}}</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 border-top-1 font-weight-600">
                    Currencies
                    <small>{{$account->currency}}</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 border-top-1 font-weight-600">
                    Starting Balance
                    <small>{{$account->opening_balance}} {{$account->currency}}</small>
                </li>
            </ul>
            <ul class="list-group mb-4">
                <li class="list-group-item border-0">
                    <div class="font-weight-600">Bank Name</div>
                    <div>
                        <small>{{$account->bank_name}}</small>
                    </div>
                </li>
                <li class="list-group-item border-0 border-top-1">
                    <div class="font-weight-600">Bank Phone</div>
                    <div>
                        <small>{{$account->bank_phone}}</small>
                    </div>
                </li>
                <li class="list-group-item border-0 border-top-1">
                    <div class="font-weight-600">Bank Address</div>
                    <div>
                        <small>{{$account->bank_address}}</small>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-xl-9">
            <div class="row mb--3">
                <div class="col-md-4">
                    <div class="card bg-gradient-info border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col"><h5 class="text-uppercase  mb-0 text-white">Incoming</h5>
                                    <div class="dropdown-divider"></div>
                                    <span class="h2 font-weight-bold mb-0 text-white">{{$incoming}} {{$account->currency}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col"><h5 class="text-uppercase mb-0 text-white">Outgoing</h5>
                                    <div class="dropdown-divider"></div>
                                    <span class="h2 font-weight-bold mb-0 text-white">{{$outgoing}} {{$account->currency}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col"><h5 class="text-uppercase  mb-0 text-white">Account
                                        Balance</h5>
                                    <div class="dropdown-divider"></div>
                                    <span class="h2 font-weight-bold mb-0 text-white">{{$account->balance}} {{$account->currency}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-wrapper mb-2">
                        <ul id="tabs-icons-text" role="tablist" class="nav nav-pills nav-fill flex-column flex-md-row">
                            <li class="nav-item"><a id="transactions-tab" data-toggle="tab" href="#transactions-content"
                                                    role="tab" aria-controls="transactions-content" aria-selected="true"
                                                    class="nav-link mb-sm-3 mb-md-0 active">
                                    Transactions
                                </a></li>
                            <li class="nav-item"><a id="transfers-tab" data-toggle="tab" href="#transfers-content"
                                                    role="tab" aria-controls="transfers-content" aria-selected="false"
                                                    class="nav-link mb-sm-3 mb-md-0">
                                    Transfers
                                </a></li>
                        </ul>
                    </div>
                    <div class="card">
                        <div id="account-tab-content" class="tab-content">
                            <div id="transactions-content" role="tabpanel" aria-labelledby="transactions-tab"
                                 class="tab-pane fade show active">
                                <div class="table-responsive my-3 col-12">
                                    <table class="table " id="transaction">
                                        <thead>
                                        <tr><th></th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Account</th>
                                            <th>Description</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        @foreach($transaction as $transaction)
                                            @if($transaction->type=='Revenue')
                                                <tr>
                                                    <td><input type="checkbox" name="check"></td>
                                                    <td><a href="{{$transaction->revenue->invoice_id==null?'':route('invoices.show',$transaction->revenue->invoice_id)}}">{{\Carbon\Carbon::parse($transaction->revenue->transaction_date)->toFormattedDateString()}}</a></td>
                                                    <td>{{number_format($transaction->revenue->amount)}}</td>
                                                    <td>{{$transaction->type}}</td>
                                                    <td>{{$transaction->revenue->category}}</td>
                                                    <td>{{$transaction->account->name}}</td>
                                                    <td>{{$transaction->revenue->description}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td><input type="checkbox" name="check"></td>
                                                    <td><a href="">{{\Carbon\Carbon::parse($transaction->expense->transaction_date)->toFormattedDateString()}}</a></td>
                                                    <td>{{number_format($transaction->expense->amount)}}</td>
                                                    <td>{{$transaction->type}}</td>
                                                    <td>{{$transaction->expense->category}}</td>
                                                    <td>{{$transaction->account->name}}</td>
                                                    <td>{{$transaction->expense->description}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="transfers-content" role="tabpanel" aria-labelledby="transfers-tab"
                                 class="tab-pane fade">
                                <div class="table-responsive">
                                    <table id="tbl-transfers" class="table table-flush table-hover">
                                        <thead class="thead-light">
                                        <tr class="row table-head-line">
                                            <th class="col-sm-3">Date</th>
                                            <th class="col-sm-3">Amount</th>
                                            <th class="col-sm-3">From Account</th>
                                            <th class="col-sm-3">To Account</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="card-footer py-4 table-action">
                                    <div class="row">
                                        <div id="datatable-basic_info" role="status" aria-live="polite"
                                             class="col-xs-12 col-sm-12">
                                            <small>No records.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection