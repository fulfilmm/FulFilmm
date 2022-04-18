@extends('layout.mainlayout')
@section('title','Expense')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('expense.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                        Expense</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">
                <table class="table " id="transaction">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Account</th>
                        <th>Date</th>
                        <th>Bill ID</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Supplier</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Approver Name</th>
                        <th>Issuer</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
{{--                    @dd($expenses)--}}
                    @foreach($expenses as $transaction)
                        <tr>
                            <td>{{$transaction->account->code}}</td>
                            <td>{{$transaction->account->code.'-'.$transaction->account->name??'N/A'}}</td>
                            <td>
                                {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                            </td>
                            <td>
                                @if($transaction->bill_id!=null)
                                    <a href="{{route('bills.show',$transaction->bill_id)}}">{{$transaction->bill->bill_id}}</a>@else
                                    N/A @endif</td>
                            <td>{{$transaction->title}}</td>
                            <td>{{number_format($transaction->amount)}}</td>
                            <td>{{$transaction->supplier->name}}</td>
                            <td>{{$transaction->cat->name}}</td>
                            <td>
                                @if($transaction->approve==0)
                                    <a href="{{url('transaction/approve/'.$transaction->id.'/expense')}}"
                                       class="btn btn-white btn-white btn-sm">Approve</a>
                                @else
                                    <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                @endif
                            </td>
                            <td>{{$transaction->approver->name}}</td>
                            <td>{{$transaction->employee->name}}</td>
                            <td style="width: 150px;">
                                <div class="row">
                                    <a href="{{$transaction->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->invoice_id)}}"
                                       class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                    <a href="{{route('expense.edit',$transaction->id)}}" class="btn btn-primary btn-sm"><i
                                                class="la la-edit"></i></a>
                                    <a href="{{route('expense.delete',$transaction->id)}}"
                                       class="btn btn-primary btn-sm"><i class="la la-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#start').datetimepicker();
            jQuery('#end').datetimepicker();
        });
    </script>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
@endsection