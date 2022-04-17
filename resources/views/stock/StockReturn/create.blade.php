@extends('layout.mainlayout')
@section('title','Stock Return')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock Return Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock Return Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-5">
                    <form action="{{route('stockreturn.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select  name="mainproduct" id="product" class="form-control select2" onchange="giveSelection(this.value)">
                                        @foreach($products as $item)
                                            <option value="{{$item->id}}" {{old('mainproduct')==$item->id?'selected':''}} >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('variant_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="variant">Variant</label>
                                    <select name="variant_id" id="variant" class="form-control select2" >
                                        @foreach($variants as $item)
                                            <option value="{{$item->id}}" {{old('variant_id')==$item->id?'selected':''}} data-option="{{$item->product_id}}">{{$item->variant}}</option>
                                        @endforeach
                                    </select>
                                    @error('variant_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="type">Stock Return Type</label>
                                    <select name="warehouse_return" id="return_type" class="form-control">
                                        <option value="0">Customer Return</option>
                                        <option value="1">Warehouse Return</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12" id="customer_div">
                                <div class="form-group">
                                    <label for="customer">Customer</label>
                                    <select name="customer_id" id="customer" class="form-control select2">
                                        <option value="">None</option>
                                        @foreach($customers as $item)
                                            <option value="{{$item->id}}" {{old('customer_id')==$item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="employee">Employee</label>
                                    <select name="emp_id" id="employee" class="form-control select2">
                                        @foreach($employees as $item)
                                            <option value="{{$item->id}}" {{old('emp_id')==$item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('emp_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12" id="from_warehouse">
                                <div class="form-group">
                                    <label for="warehouse">Return From Warehouse</label>
                                    <select name="transfer_warehouse" id="warehouse_return" class="form-control select2">
                                        <option value="">None</option>
                                        @foreach($warehouse as $item)
                                            <option value="{{$item->id}}" {{old('warehouse_id')==$item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="warehouse">Warehouse</label>
                                    <select name="warehouse_id" id="warehouse" class="form-control select2">
                                        @foreach($warehouse as $item)
                                            <option value="{{$item->id}}" {{old('warehouse_id')==$item->id?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" id="qty" class="form-control" name="qty" value="{{old('qty')}}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="unit_id">Unit</label>
                                    <select name="sell_unit" id="unit_id" class="form-control select2">
                                        @foreach($units as $item)
                                            <option value="{{$item->id}}" {{old('unit_id')==$item->id?'selected':''}} data-option="{{$item->product_id}}">{{$item->unit}}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="inv">Invoice</label>
                                    <select name="inv_id" id="inv" class="form-control select2">
                                        <option value="">None</option>
                                        @foreach($invoices as $item)
                                            <option value="{{$item->id}}" {{old('inv_id')==$item->id?'selected':''}}>{{$item->invoice_id}}</option>
                                        @endforeach
                                    </select>
                                    @error('inv_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="attach">Attachment</label>
                                    <input type="file" name="attachment" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="description" id="desc" cols="30" rows="3" class="form-control">
                                    {{old('description')}}
                                </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
            $('#from_warehouse').hide();
            $('#return_type').change(function () {
                var warehouse_id=$('#return_type option:selected').val();
                if(warehouse_id==1){
                    $('#from_warehouse').show();
                    $('#customer_div').hide();
                }else{
                    $('#from_warehouse').hide();
                    $('#customer_div').show();
                }
            });
        });

        var product = document.querySelector('#product');
        var unit = document.querySelector('#unit_id');
        var variant=document.querySelector('#variant');
        var options2 = unit.querySelectorAll('option');
        var options3=variant.querySelectorAll('option');
        function giveSelection(selValue) {
            unit.innerHTML='';
            variant.innerHTML='';
            for(var i = 0; i < options2.length; i++) {
                if(options2[i].dataset.option === selValue) {
                    unit.appendChild(options2[i]);

                }
            }
            for(var j = 0; j < options3.length; j++) {
                if(options3[j].dataset.option === selValue) {
                    variant.appendChild(options3[j]);

                }
            }
        }
        giveSelection(product.value);
    </script>
@endsection
