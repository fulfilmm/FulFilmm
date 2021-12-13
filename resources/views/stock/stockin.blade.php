@extends('layout.mainlayout')
@section('title','Stock In')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock In</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Out</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('stockin')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="warehouse">Product</label>
                        <select name="product_id" id="warehouse" class="form-control">
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="supplier_id" id="customer" class="form-control">
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="warehouse">Warehouse</label>
                        <select name="warehouse_id" id="warehouse" class="form-control">
                            @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @foreach($sku as $stock)
                <div class="my-2 card">
                    <div class="col-12 my-3">
                        <div class="col-12">
                            <span class="text-muted">SKU:{{$stock->sku}}</span>
                        </div>
                        <div class="row">
                            @foreach($attribute as $att)
                                <div class="col-md-2">
                                    <label for="">{{$att->name}}</label>
                                    <select name="{{$att->name}}[]" id="" class="select" hidden>
                                        @foreach($variant_value as $value)
                                            @if($value->variant_key==$att->id)
                                                <option value="{{$value->id}}">{{$value->value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            @endforeach
                            <input type="hidden" name="sku_id[]" value="{{$stock->id}}">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Qty</label>
                                    <input type="number" name="qty[]" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Alert Qty</label>
                                    <input type="number" name="alert_qty[]" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Purchase Price</label>
                                    <input type="number" name="purchase_price[]" class="form-control" value="0.0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Sale Price</label>
                                    <input type="number" name="sale_price[]" class="form-control" value="0.0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="form-group ">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary text-center">Stock In</button>
                </div>
            </div>
        </form>
    </div>
@endsection