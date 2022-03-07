@extends('layout.mainlayout')
@section('title','Shipment')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Delivery</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Delivery</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 my-3">
            <form action="{{route('deliveries.store')}}" method="POST">
                @csrf
                <div class="card shadow">
                    <div class="card-header">Delivery Assign</div>
                    <div class="col-12 my-3">
                        <div class="row">
                            <input type="hidden" name="draft_time" value="{{\Carbon\Carbon::now()}}">
                            <input type="hidden" name="emp_id"
                                   value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Delivery ID</label>
                                    <input type="text" class="form-control" name="delivery_id" value="{{$delivery_id}}">
                                    @error('delivery_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Invoice ID</label>
                                    <select name="invoice_id" id="invoice" class="select2 form-control">
                                        <option value="">Select Invoice ID</option>
                                        @foreach($invoices as $invoice)
                                            <option value="{{$invoice->id}}" {{old('invoice_id')==$invoice->id?'selected':''}}>{{$invoice->invoice_id}}</option>
                                        @endforeach
                                    </select>
                                    @error('invoice_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Courier Name</label>
                                    <select name="courier_id" id="" class="form-control select2">
                                        @foreach($courier as $deli)
                                            <option value="{{$deli->id}}" {{old('courier_id')==$deli->id?'selected':''}}>{{$deli->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('courier_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="customer_name">Customer</label>
                                    <input type="text" class="form-control" id="customer_name" readonly>
                                    <input type="hidden" name="customer_id" id="customer_id">
                                    @error('customer_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="pickup_date">Pick Up Date</label>
                                    <input type="date" class="form-control" name="pickup_date" id="pickup_date">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Warehouse From</label>
                                    <select name="warehouse_id" id="" class="form-control select2">
                                        @foreach($warehouse as $key=>$val)
                                            <option value="{{$key}}" {{old('warehouse_id')==$key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('warehouse_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Delivery Address</label>
                                    <input type="text" id="address" class="form-control" name="shipping_address"
                                           value="{{old('shipping_address')}}">
                                </div>
                                @error('shipping_address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="phone">Receiver Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Delivery Date</label>
                                    <input type="date" class="form-control" name="delivery_date"
                                           value="{{old('delivery_date')}}">
                                </div>
                                @error('delivery_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="">Delivery Fee</label>
                                    <input type="number" class="form-control" name="delivery_fee" id="deli_fee"
                                           value="{{old('delivery_fee')}}">
                                </div>
                                @error('delivery_fee')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="estimate_date">Estimated Date</label>
                                    <input type="text" class="form-control" name="estimate_date"
                                           placeholder="Within 3 Days">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="reach_date">Reach Date And Time</label>
                                    <input type="text" id="reach_date" class="form-control" name="reach_date"
                                           placeholder="Will Reach Date and time">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="invoice_type">Invoice Type</label>
                                    <input type="text" class="form-control" name="invoice_type" id="delivery_type">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-6 flex-column">
                                <div class="form-group">
                                    <label for="amount">Amount To Request</label>
                                    <input type="text" class="form-control" id="amount" name="amount">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12 flex-column">
                                <div class="form-group">
                                    <label for="remark">Remark</label>
                                    <textarea name="remark" id="remark" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="uuid" value="{{\Illuminate\Support\Str::uuid()}}">
                            <div class="col-md-12 text-center">
                                <button type="reset" class="btn btn-danger ">Cancel</button>
                                <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('input[type="text"]').addClass('shadow-sm');
           $('input[type="date"]').addClass('shadow-sm');
           $('textarea').addClass('shadow-sm');
        });
        $(document).ready(function () {
            var inv_id=$('#invoice option:selected').val();
            @foreach($invoices as $invoice)
            if(inv_id=='{{$invoice->id}}'){
                $('#customer_name').val('{{$invoice->customer->name}}');
                $('#customer_id').val('{{$invoice->customer->id}}');
                $('#phone').val('{{$invoice->customer->phone}}')
            }
            @endforeach
            $('#invoice').on('change',function () {
                var inv_id=$('#invoice option:selected').val();
                @foreach($invoices as $invoice)
                if(inv_id=='{{$invoice->id}}'){
                    $('#customer_name').val('{{$invoice->customer->name}}');
                    $('#customer_id').val('{{$invoice->customer->id}}');
                    $('#phone').val('{{$invoice->customer->phone}}');
                    $('#address').val('{{$invoice->customer_address}}');
                    $('#deli_fee').val('{{$invoice->delivery_fee}}');
                    $('#delivery_type').val('{{$invoice->invoice_type}}');
                    $('#amount').val('{{$invoice->grand_total}}');
                }else {
                    $('#customer_name').val('');
                    $('#customer_id').val('');
                    $('#phone').val('');
                    $('#address').val('');
                    $('#deli_fee').val('');
                    $('#delivery_type').val('');
                    $('#amount').val('');
                }
                @endforeach
            })
        });
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#reach_date').datetimepicker();
        });
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
@endsection