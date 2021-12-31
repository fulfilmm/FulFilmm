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
        <div class="col-12">
            <form action="{{route('deliveries.store')}}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" name="draft_time" value="{{\Carbon\Carbon::now()}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Delivery ID</label>
                            <input type="text" class="form-control" name="delivery_id" value="{{$delivery_id}}">
                            @error('delivery_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Customer</label>
                            <select name="customer_id" id="" class="form-control select2">
                                <option value="">Select Customer</option>
                               @foreach($customer as $cust)
                                <option value="{{$cust->id}}" {{old('customer_id')==$cust->id?'selected':''}}>{{$cust->name}}</option>
                                   @endforeach
                            </select>
                            @error('customer_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Invoice ID</label>
                            <select name="invoice_id" id="invoice" class="select2 form-control">
                               @foreach($invoices as $invoice)
                                <option value="{{$invoice->id}}" {{old('invoice_id')==$invoice->id?'selected':''}}>{{$invoice->invoice_id}}</option>
                                   @endforeach
                            </select>
                            @error('invoice_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Delivery Date</label>
                            <input type="date" class="form-control" name="delivery_date" value="{{old('delivery_date')}}">
                        </div>
                        @error('delivery_date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Delivery Fee</label>
                            <input type="number" class="form-control" name="delivery_fee" value="{{old('delivery_fee')??0.0}}">
                        </div>
                        @error('delivery_fee')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
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
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="">Delivery Address</label>
                            <input type="text" id="address" class="form-control" name="shipping_address" value="{{old('shipping_address')}}">
                        </div>
                        @error('shipping_address')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimate_date">Estimated Date</label>
                            <input type="text" class="form-control" name="estimate_date" placeholder="Within 3 Days">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reach_date">Reach Date</label>
                            <input type="text" id="reach_date" class="form-control" name="reach_date" placeholder="Will Reach Date and time">
                        </div>
                    </div>
                    <input type="hidden" name="uuid" value="{{\Illuminate\Support\Str::uuid()}}">
                    <div class="col-md-12">
                        <button type="reset" class="btn btn-danger ">Cancel</button>
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#reach_date').datetimepicker();
        });
        $(document).ready(function () {
           $('#invoice').change(function () {
               var inv_id=$(this).val();
               @foreach($invoices as $invoice)
                   if(inv_id=="{{$invoice->id}}"){
                       var address="{{$invoice->customer_address}}";
                       $('#address').val(address);
               }
               @endforeach
           }) ;
        });
    </script>
    @endsection