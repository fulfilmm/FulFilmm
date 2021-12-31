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
                                   <select name="product_id" id="warehouse" class="form-control">
                                       @foreach($products as $product)
                                           <option value="{{$product->id}}">{{$product->product->name}}
                                               @if($product->color!=null||$product->size!=null||$product->other!=null)
                                                   ({{$product->color}} {{$product->size}} {{$product->other}})
                                               @endif
                                           </option>
                                       @endforeach
                                   </select>
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
                               </div>
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
@endsection