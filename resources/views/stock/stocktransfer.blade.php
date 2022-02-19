@extends('layout.mainlayout')
@section('title','Stock Transfer')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock Transfer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Transfer</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('stocks.transfer')}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warehouse">Current Warehouse <span class="text-danger"> * </span></label>
                        <select name="current_warehouse_id" id="current_warehouse" class="form-control">
                            @foreach($warehouse as $key=>$val)
                                <option value={{$key}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warehouse">Transfer Warehouse <span class="text-danger"> * </span></label>
                        <select name="transfer_warehouse_id" id="warehouse" class="form-control">
                            @foreach($warehouse as $key=>$val)
                                <option value={{$key}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="variantion_id">Product <span class="text-danger"> * </span></label>
                        <select name="variantion_id" id="variantion_id" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->product->name}} ({{$product->variant??''}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="qty">Quantity <span class="text-danger"> * </span></label>
                        <input type="number" name="qty" class="form-control">
                    </div>
                    @error('qty')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <div class="form-group ">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary text-center">Stock Transfer</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection