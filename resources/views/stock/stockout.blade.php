@extends('layout.mainlayout')
@section('title','Stock Out')
@section('content')
    <div class="container-fluid">
        <form action="{{route('stockout')}}" method="POST">
            @csrf
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="product">Product Name<span class="text-danger"> * </span></label>
                        <select id="product" class="form-control" onchange="giveSelection(this.value)">
                            @foreach($main_product as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                        @error('variantion_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="variantion_id">Variant <span class="text-danger"> * </span></label>
                        <select name="variantion_id" id="variantion_id" class="form-control">
                            @foreach($products as $product)
                                <option value="{{$product->id}}"
                                        data-option="{{$product->product_id}}">{{$product->variant}}</option>
                            @endforeach
                        </select>
                        @error('variantion_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
                        @error('emp_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="approver">Approver <span class="text-danger"> * </span></label>
                        <select name="approver_id" id="approver" class="form-control">
                            @foreach($emps as $emp)
                                @if($emp->role->name=='Stock Manager')
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('approver_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
                        @error('type')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
                        @error('customer_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
                        @error('warehouse_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
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
                        <select name="sell_unit" id="unit" class="form-control select col-4">
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}"
                                        {{$unit->unit_convert_rate==1?'selected':''}} data-option="{{$unit->product_id}}">{{$unit->unit}}</option>
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
        var product = document.querySelector('#product');
        var unit = document.querySelector('#unit');
        var variant=document.querySelector('#variantion_id');
        var options3=variant.querySelectorAll('option');
        var options2 = unit.querySelectorAll('option');
        function giveSelection(selValue) {
            unit.innerHTML = '';
            variant.innerHTML='';
            // variant.appendChild('<option value="2" data-option="1" data-select2-id="4">Black</option>')
            for (var i = 0; i < options2.length; i++) {
                if (options2[i].dataset.option === selValue) {
                    unit.appendChild(options2[i]);

                }
            }
            for (var i = 0; i < options3.length; i++) {
                if (options3[i].dataset.option === selValue) {
                    variant.appendChild(options3[i]);

                }
            }
        }

        giveSelection(product.value);

        $('#type').change(function () {
            var type = $(this).val();
            if (type == 'Damage' || type == 'FOC') {
                $('#customer_div').hide();
            } else {
                $('#customer_div').show();
            }
        });
        $(document).ready(function () {
            $('#inv_id').html('<option value="">None</option>')
            $('#type').change(function () {
                var type = $(this).val();
                if (type == 'Invoice') {
                    $('#inv_id').html('@foreach($invoice as $key=>$val) <option value="{{$key}}">{{$val}}</option> @endforeach')
                } else {
                    $('#inv_id').html('<option value="">None</option>')
                }
            });
        });
        ClassicEditor.create($('#desc')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
@endsection