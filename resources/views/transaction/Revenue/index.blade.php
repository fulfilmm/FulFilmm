@extends('layout.mainlayout')
@section('title','Revenue')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Revenue</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Revenue</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                        <a href="{{route('income.create')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i> Add
                            Income</a>
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
                        <th>Invoice ID</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Approve</th>
                        <th>Approver Name</th>
                        <th>Receiver</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($revenues as $transaction)
                            <tr>
                                <td>{{$transaction->account->code}}</td>
                                <td>{{$transaction->account->code.'-'.$transaction->account->name??'N/A'}}</td>
                                <td>
                                    {{\Carbon\Carbon::parse($transaction->transaction_date)->toFormattedDateString()}}
                                </td>
                                <td>@if($transaction->invoice_id!=null)<a href="{{route('invoices.show',$transaction->invoice->id)}}">{{$transaction->invoice->invoice_id}}</a>@else N/A @endif</td>
                                <td>{{$transaction->title}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
                                <td>{{$transaction->cat->name}}</td>
                                <td>
                                    @if($transaction->approve==0)
                                        <a href="{{url('transaction/approve/'.$transaction->id.'/Revenue')}}" class="btn btn-white btn-white btn-sm">Approve</a>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                    @endif
                                </td>
                                <td>{{$transaction->approver->name}}</td>
                                <td>{{$transaction->employee->name}}</td>
                               <td>
                                <a href="{{$transaction->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->invoice_id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                   <a href="{{route('revenue.edit',$transaction->id)}}" class="btn btn-primary btn-sm"><i class="la la-edit"></i></a>
                                   <a href="{{route('revenue.delete',$transaction->id)}}" class="btn btn-primary btn-sm"><i class="la la-trash"></i></a>
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