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
                        <th>GL Account</th>
                        <th>Date</th>
                        <th>Bill ID</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Account</th>
                        <th>Approve</th>
                        <th>Approver Name</th>
                        <th>{{isset($revenue)?'Receiver':(isset($expense)?'Issuer':'Receiver/Issuer')}}</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--                    @dd($expenses)--}}
                    @foreach($expenses as $transaction)
                        <tr>
                            <td >@foreach($coa as $coaitem) {{$coaitem->id==$transaction->expense->category?$coaitem->code:''}}  @endforeach</td>
                            <td style="min-width: 150px;">@foreach($coa as $coaitem) {{$coaitem->id==$transaction->expense->category?$coaitem->name:''}}  @endforeach</td>
                            <td style="min-width: 150px;">
                                <a href="{{route('transactions.show',$transaction->id)}}">{{\Carbon\Carbon::parse($transaction->expense->transaction_date)->toFormattedDateString()}}</a>
                            </td>
                            <td style="min-width: 150px;">
                                    @if($transaction->expense->bill_id!=null)
                                        @foreach($bill as $b)
                                            @if($b->id==$transaction->expense->bill_id)
                                                <a href="{{$transaction->expense->bill_id==null?route('transactions.show',$transaction->id):route('bills.show',$transaction->expense->bill_id)}}">{{$b->bill_id}}</a>
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif

                            </td>
                            <td style="min-width: 150px;">{{$transaction->expense->title}}</td>
                            <td style="min-width: 150px;">{{number_format($transaction->expense->amount)}}</td>
                            <td style="min-width: 150px;"><span class="badge" style="background-color: #ff4969">{{$transaction->type}}</span></td>
                            <td style="min-width: 150px;">{{$transaction->account->name}}</td>
                            <td style="min-width: 150px;">
                                @if($transaction->expense->approve==0)
                                    <a href="{{url('transaction/approve/'.$transaction->expense->id.'/Expense')}}"
                                       class="btn btn-white btn-white btn-sm ">Approve</a>
                                @else
                                    <button type="button" class="btn btn-success btn-sm disabled">Approved</button>
                                @endif
                            </td>
                            <td style="min-width: 150px;">@foreach($employees as $item) {{$item->id==$transaction->expense->approver_id?$item->name:''}}  @endforeach</td>
                            <td style="min-width: 150px;">
                                <a href="{{route('employees.show',$transaction->expense->emp_id)}}">@foreach($employees as $item) {{$item->id==$transaction->expense->emp_id?$item->name:''}}  @endforeach </a>
                            </td>
                            <td>
                                <a href="{{$transaction->expense->invoice_id==null?route('transactions.show',$transaction->id):route('invoices.show',$transaction->expense->invoice_id)}}"
                                   class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
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