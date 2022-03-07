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
       <div class="col-md-8 offset-md-2">
           <div class="card ">
               <div class="col-12 my-3">
                   <form action="{{route('stockin')}}" method="POST">
                       @csrf
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="warehouse">Product</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" style="max-width: 40%">
                                            <select name="" id="type" class="form-control" style="max-width: 100%">
                                                <option value="Name">Name</option>
                                                <option value="Code">Code</option>
                                            </select>
                                        </div>
                                        <select name="product_id" id="product_id" class="form-control" style="max-width: 70%">
                                        </select>
                                    </div>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="customer">Supplier</label>
                                   <select name="supplier_id" id="customer" class="form-control">
                                       @foreach($customers as $customer)
                                           <option value="{{$customer->id}}">{{$customer->name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="exp_date">Expired Date</label>
                                   <input type="date" class="form-control" name="exp_date" id="exp_date">
                                   @error('exp_date')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="warehouse">Warehouse</label>
                                   <select name="warehouse_id" id="warehouse" class="form-control">
                                       @foreach($warehouses as $warehouse)
                                           <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>

                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="">Quantity</label>
                                   <input type="number" name="qty" class="form-control">
                                   @error('qty')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="value">Purchase Price</label>
                                   <input type="number" name="purchase_price" class="form-control" placeholder="Enter Valuation">
                               </div>
                               @error('purchase_price')
                               <span class="text-danger">{{$message}}</span>
                               @enderror
                           </div>
                       </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="loca">Location</label>
                               <input type="text" class="form-control" name="product_location" placeholder="Enter product location in warehouse">
                           </div>
                       </div>
                       <div class="form-group ">
                           <div class="col-12">
                               <button type="submit" class="btn btn-primary text-center">Stock In</button>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
       </div>
    </div>
    <script>
       $(document).ready(function () {
           $('select').select2();
       });
       $(document).ready(function () {
           $("#product_id").html(" @foreach($products as $product)<option value='{{$product->id}}'>{{$product->product_name}} ({{$product->variant}})</option> @endforeach");
           $("#type").change(function () {
               var val = $(this).val();
               if (val == "Name") {
                   $("#product_id").html(" @foreach($products as $product)<option value='{{$product->id}}'>{{$product->product_name}} ({{$product->variant}})</option> @endforeach");
               } else if (val == "Code") {
                   $("#product_id").html("@foreach($products as $product)<option value='{{$product->id}}'>{{$product->product_code}}</option> @endforeach");
               }
           });
       });
    </script>
@endsection