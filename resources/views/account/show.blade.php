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
                    <small>{{$account->account_no}}</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 font-weight-600">
                    Bank Account
                    <small>{{$account->number}}</small>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center border-0 border-top-1 font-weight-600">
                    Currency Unit
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
            <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                <div class="col  my-2">
                    <div class="alert-success alert mb-0 shadow">
                        <a href="{{url('revenue')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Incoming</div>
                                    <span class="small">{{$incoming}} {{$account->currency}}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col  my-2">
                    <div class="alert-danger alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Outgoing</div>
                                    <span class="small">{{$outgoing}} {{$account->currency}}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col  my-2">
                    <div class="alert-info alert mb-0 shadow">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-bank fa-lg"></i></div>
                            <div class="flex-fill ms-3 text-truncate">
                                <div class="h6 mb-0">Account Balance</div>
                                <span class="small">{{$account->balance}} {{$account->currency}}</span>
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