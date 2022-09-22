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
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Advance
                                Payment</a></li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button  class="btn btn-primary btn-sm float-left ml-2" data-toggle="modal" data-target="#advan_pay" type="button" ><i class="fa fa-money " > Make Advance Payment</i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="col-12">
                <div class="row">
                    <div class="col-12" style="overflow: auto">
                        <table class="table " id="advance_pay">
                            <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Advance Balance</th>
                                @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                    <th>Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($advancepayment as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->advance_balance}}</td>
                                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#history{{$item->id}}">Received History</button>
                                            <div id="history{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Advance Payment Received History</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-12">
                                                                <table class="table-hover table-nowrap table">
                                                                    <tr>
                                                                        <th>
                                                                            Customer
                                                                        </th>
                                                                        <th>Amount</th>
                                                                        <th>Received Employee</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                    @foreach($history as $his)
                                                                        @if($his->customer_id==$item->id)
                                                                            <tr>
                                                                                <td>{{$item->name}}</td>
                                                                                <td>{{$his->amount}}</td>
                                                                                <td>{{$his->emp->name}}</td>
                                                                                <td>{{$his->created_at->toFormattedDateString()}}</td>
                                                                            </tr>
                                                                            @endif
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="advan_pay" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Advance Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('advancepayments.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate"  class="form-loading-button needs-validation">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="approver">Approver</label>
                                            <select name="approver_id" id="approver" class="form-control">
                                                @foreach($approver as $approve)
                                                    <option value="{{$approve->id}}">{{$approve->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="payment_type">Payment Method</label>
                                            <select name="payment_type" id="payment_type" class="form-control" style="width: 100%">
                                                <option value="Cash">Cash</option>
                                                <option value="Ebanking">Ebanking</option>
                                                <option value="KBZ Pay">KBZ Pay</option>
                                            </select>
                                            @error('type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="customer">Customer</label>
                                            <select name="customer_id" id="customer" class="form-control">
                                                @foreach($customer as $cust)
                                                    <option value="{{$cust->id}}">{{$cust->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="amount" name="amount" value="{{old('amount')}}">
                                            </div>
                                            @error('amount')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                            <div class="card-footer">
                                <div class="row save-buttons">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                                    class="btn-inner--text">Save</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                var type=$('#type option:selected').val();
                if(type=='Cash'){
                    $('#account_div').hide();
                }else {
                    $('#account_div').show();
                }
                $('#type').change(function () {
                    var select_type=$(this).val();
                    if(select_type=='Cash'){
                        $('#account_div').hide();
                    }else {
                        $('#account_div').show();
                    }
                });
            });
        </script>
    </div>
@endsection
