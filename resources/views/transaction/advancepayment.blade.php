@extends('layout.mainlayout')
@section('title','Advance Payment')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Advance Payment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Advance Payment</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                            <div class="col-12" style="overflow: auto">
                                <table class="table " id="advance_pay">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Account No.</th>
                                        <th>Customer</th>
                                        <th>Receiver Employee</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($advancepayment as $item)
                                         <tr>
                                             <td>{{$item->created_at->toFormattedDateString()}}</td>
                                             <td><a href="{{route('saleorders.show',$item->order_id)}}">{{$item->order->order_id}}</a></td>
                                             <td>{{$item->amount}}</td>
                                             <td>{{$item->type}}</td>
                                             <td>{{$item->account->name??'N/A'}}</td>
                                             <td><a href="{{route('customers.show',$item->customer_id)}}">{{$item->customer->name}}</a></td>
                                             <td><a href="{{route('employees.show',$item->emp_id)}}">{{$item->emp->name}}</a></td>
                                             <td><a href="{{route('advance.maketransaction',$item->id)}}" class="btn btn-primary btn-sm">Transfer</a></td>
                                         </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
        </div>
    </div>
@endsection
