@extends('layout.mainlayout')
@section('title','Stock Out')
@section('content')
    <div class="container-fluid">
        {{--<div class="page-header mt-3">--}}
            {{--<div class="row align-items-center">--}}
                {{--<div class="col">--}}
                    {{--<h3 class="page-title">Stock Out</h3>--}}
                    {{--<ul class="breadcrumb">--}}
                        {{--<li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>--}}
                        {{--<li class="breadcrumb-item active">Stock</li>--}}
                        {{--<li class="breadcrumb-item active">Out</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <form action="{{route('stockout')}}" method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="variantion_id">Product <span class="text-danger"> * </span></label>
                        <select name="variantion_id" id="variantion_id" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->product->name}} ({{$product->variant}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="emp">Employee <span class="text-danger"> * </span></label>
                        <select name="emp_id" id="emp" class="form-control">
                            @foreach($emps as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="approver">Approver <span class="text-danger"> * </span></label>
                        <select name="approver_id" id="approver" class="form-control">
                            @foreach($emps as $emp)
                                @if($emp->role->name=='Manager')
                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type">Stock Out Type <span class="text-danger"> * </span></label>
                        <select name="type" id="type" class="form-control">
                            <option value="">Select Type</option>
                            @foreach($type as $item)
                            <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4" id="customer_div">
                    <div class="form-group">
                        <label for="customer">Customer <span class="text-danger"> * </span></label>
                        <select name="customer_id" id="customer" class="form-control">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="warehouse">Warehouse <span class="text-danger"> * </span></label>
                        <select name="warehouse_id" id="warehouse" class="form-control">
                            @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->name}}{{$warehouse->is_virtual?'(Virtual Warehouse)':''}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="qty">Quantity <span class="text-danger"> * </span></label>
                        <div class="input-group">
                            <input type="number" id="qty" name="qty" class="form-control" value="{{old('qty')}}">
                        </div>
                    </div>
                    @error('qty')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select name="sell_unit" id="" class="form-control select col-4">
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}" {{$unit->unit_convert_rate==1?'selected':''}}>{{$unit->unit}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inv">Invoice ID</label>
                        <select name="invoice_id" id="inv_id" class="form-control select2">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="courier">Courier <span class="text-danger"> * </span></label>
                        <select name="courier_id" id="courier" class="form-control">
                            <option value="">Select Courier</option>
                            @foreach($couriers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="description" id="desc" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
               <div class="col-12">
                   <div class="form-group ">
                       <div class="col-12">
                           <button type="submit" class="btn btn-primary text-center">Stock Out</button>
                       </div>

                   </div>
               </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function () {
           $('select').select2();
        });
        $('#type').change(function () {
           var type=$(this).val();
           if(type=='Damage'||type=='FOC'){
               $('#customer_div').hide();
           }else {
               $('#customer_div').show();
           }
        });
        $(document).ready(function () {
            $('#inv_id').html('<option value="">None</option>')
           $('#type').change(function () {
               var type=$(this).val();
               if(type=='Invoice'){
                   $('#inv_id').html('@foreach($invoice as $key=>$val) <option value="{{$key}}">{{$val}}</option> @endforeach')
               }else{
                   $('#inv_id').html('<option value="">None</option>')
               }
           }) ;
        });
        ClassicEditor.create($('#desc')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
@endsection