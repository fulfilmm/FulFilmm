@extends("layout.mainlayout")
@section('title','Product Edit')
@section("content")
    <style>
        input[type="file"] {
            display: block;
        }

        .imageThumb {
            max-height: 90px;
            max-width: 150px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }

        .pip {
            display: inline-block;
            margin: 10px 10px 10px 0;
        }

        .remove {
            display: block;
            background: #edeff2;
            border: 1px solid black;
            color: black;
            text-align: center;
            cursor: pointer;
        }

        .remove:hover {
            background: white;
            color: black;
        }

    </style>
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route("products.update",$product->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">General Product Detail</div>
                <div class="col-12 my-3">
                    <div class="row">
                        <div class="form-group col-md-4 col-12">
                            <label for="">Product Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="name" value="{{$product->name}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Product Code</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="main_product_code" value="{{$product->product_code}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-12" id="tax_div">
                            <div class="form-group">
                                <label for="">Tax</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <select name="tax" id="product_tax" class="form-control" >
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}" {{$product->tax==$tax->id?'selected':''}}>{{$tax->name}}({{$tax->rate}}%)</option>
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select name="supplier_id" id="supplier" class="select">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" {{$product->supplier_id==$supplier->id?'selected':''}}>{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">Model No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="model_no" value="{{$product->model_no}}" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">Serial No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="serial_no" value="{{$product->serial_no}}" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">SKU</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="sku" value="{{$product->sku}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Part No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="part_no" value="{{$product->part_no}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Unit</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="unit" value="{{$product->unit}}" >
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Currency</label>
                            <select name="currency" id="" class="select">
                                <option value="MMK">MMK</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class=" col-md-4 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Main Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                                    </div>
                                    <select name="cat_id" id="product_cat" class="form-control" >
                                        @foreach($category as $cat)
                                            @if($cat->parent==1)
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4 col-12 " id="cat_div">
                            <div class="form-group">
                                <label for="">Sub Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                                    </div>
                                    <select name="cat_id" id="sub_cat" class="form-control" >
                                        <option value=""></option>
                                    </select>
                                    {{--<a href="" data-toggle="modal" data-target="#cat_add" class="btn btn-outline-dark"><i--}}
                                    {{--class="fa fa-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="stock_type">Stock Type</label>
                                <select name="stock_type" id="stock_type" class="form-control">
                                    <option value="Service"> Service</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="enable" value="1"
                                       checked>
                                <label class="custom-control-label" for="customSwitch1">Enabled</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12 ">
                            <label for="description">Detail</label>
                            <textarea name="detail" class="form-control" id="detail" >{{$product->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <label for="">Standard Details</label>
           @foreach($product_variant as $variant)
                <div class="card">
                    <input type="hidden" name="variant_id[]" value="{{$variant->id}}">
                    <div class="col-12 my-3">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <input type="hidden" name="field_count[]" value="field">
                                <div class="form-group"><div class="label">Description</div>
                                    <textarea name="description[]" class="form-control" id="" cols="30" >{{$variant->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group"><label for="price">Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                                        </div><input type="number" class="form-control" name="price[]" value="{{$variant->price}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                                        </div>
                                        <input type="number" class="form-control" name="purchase_price[]" id="purchase_price" value="{{$variant->purchase_price}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                       @foreach($stock_variant as $stock)
                                        <input type="number" class="form-control" name="qty[]" id="qty" value="{{$stock->variant_id==$variant->id?$stock->stock_balance:''}}"readonly>
                                           @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="fom-group">
                                    <label for="">Warehouse</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-home"></i></span>
                                        </div>
                                        <select name="warehouse_id[]" id="" class="form-control">
                                            @foreach($warehouses as $warehouse)
                                                <option value="{{$warehouse->id}}" {{$variant->warehouse_id==$warehouse->id?'selected':''}}>{{$warehouse->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Product Code</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="product_code[]" value="{{$variant->product_code}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Discount Rate</label>
                                    <input type="number" class="form-control" name="discount_rate[]" value="{{$variant->discount_rate}}">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Alert Quantity</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-bell"></i></span>
                                        </div>
                                        @foreach($stock_variant as $stock)
                                        <input type="text" class="form-control" name="alert_qty[]" value="{{$stock->variant_id==$variant->id?$stock->alert_qty:''}}" readonly>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 ">
                                <div class="form-group">
                                    <label>Exp Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="exp_date" name="exp_date[]" value="{{\Carbon\Carbon::parse($variant->exp_date)->format('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12"></div>
                            <div class="col-md-12 col-12 mt-3">
                                <label for="">Variant Type</label>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Size</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="size[]" value="{{$variant->size}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Color</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="color[]" value="{{$variant->color}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Other</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="other[]" value="{{$variant->other}}">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><div class="form-group col-md-4 offset-md-3">
                                    <img id="output" class="rounded mt-3" src="{{$variant->image?url(asset('product_picture/'.$variant->image)):url(asset("/img/profiles/avatar-01.jpg"))}}" width="100px" height="100px;">
                                </div>
                                <div class="form-group col-md-3 col-6 offset-md-4">
                                    <label for="">Picture</label>
                                    <input type="file" accept="image/*" name="picture[]"  class=" offset-md-1" onchange="loadFile(event)" >
                                </div>
                            </div>
                            <div class="col-12 border-bottom"></div>
                        </div>
                    </div>
                </div>
               @endforeach
            <div  id="variation">

            </div>
            <div class="fom-group">
                <button type="button" class="btn btn-info" id="add_row">Add Variation</button>
            </div>
            <button type="submit" class="btn btn-primary text-center col-md-2 col-2 offset-md-5 my-3">Save</button>
        </form>
    </div>

    @include('product.catadd')
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        $('#add_row').click(function () {
            $('#variation').append('<div class="card my-3" id="add_variation"><div class="col-12"><div class="row">' +
                    ' <input type="hidden" name="variant_id[]">'+
                '<div class="col-md-12 col-12 mt-3">' +
                '<input type="hidden" name="field_count[]" value="field">' +
                '<div class="form-group">' +
                '<label>Description</label>' +
                '<textarea name="description[]" class="form-control" id="" cols="30"></textarea>' +
                '</div></div>' +
                '<div class="col-md-4 col-6">' +
                '<div class="form-group"><label for="price">Price</label>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-money"></i></span></div><input type="number" class="form-control" name="price[]"></div></div></div>' +
                '<div class="col-md-4 col-12">' +
                '<div class="form-group"><label for="purchase_price">Purchase Price</label>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-money"></i></span></div><input type="number" class="form-control" name="purchase_price[]" id="purchase_price"></div></div></div>' +
                '<div class="col-md-4 col-12"><div class="form-group">' +
                '<label for="qty">Quantity</label>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-pencil"></i></span></div><input type="number" class="form-control" name="qty[]" id="qty"></div></div></div>' +
                '<div class="col-md-4 col-12"><div class="fom-group"><label for="">Warehouse</label></div>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-home"></i></span></div>' +
                '<select name="warehouse_id[]" id="" class="form-control">' +
                '@foreach($warehouses as $warehouse)<option value="{{$warehouse->id}}">{{$warehouse->name}}</option>@endforeach</select></div></div><div class="col-md-4 col-12"><div class="form-group"><label>Product Code</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-pencil"></i></span></div><input type="text" class="form-control" name="product_code[]"></div></div></div><div class="col-md-4 col-12"><div class="form-group"><label>Discount Rate</label><input type="number" class="form-control" name="discount_rate[]"></div></div><div class="col-md-4 col-12"><div class="form-group"><label>Alert Quantity</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-bell"></i></span></div><input type="text" class="form-control" name="alert_qty[]"></div></div></div><div class="col-md-4 col-12 "><div class="form-group"><label>Exp Date</label><div class="input-group"><input type="date" class="form-control" id="exp_date" name="exp_date[]"></div></div></div>'+
                '<div class="col-md-4 col-12"></div><div class="col-12 col-md-12 mt-3"><label>Variant Type</label></div>'+
                '<div class="col-md-4 col-12">' +
                '<div class="form-group">' +
                '<label>Size</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fa fa-pencil"></i></span>' +
                '</div>' +
                '<input type="text" class="form-control" name="size[]">' +
                '</div>' +
                '</div></div>'+
                '<div class="col-md-4 col-12"><div class="form-group"><label>Color</label>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-pencil"></i></span>' +
                '                                        </div><input type="text" class="form-control" name="color[]"></div></div></div>'+
                '<div class="col-md-4 col-12"><div class="form-group"><label>Other</label>' +
                '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-pencil"></i></span>' +
                '                                        </div><input type="text" class="form-control" name="other[]"></div></div></div>'+
                '<div class="text-center">\n' +

                '                <div class="form-group col-md-4 offset-md-3">\n' +
                '                    <img id="output" class="rounded mt-3" src="{{url(asset("/img/profiles/avatar-01.jpg"))}}" width="100px" height="100px;">\n' +
                '                </div>\n' +
                '                <div class="form-group col-md-3 col-6 offset-md-4">\n' +
                '                    <label for="">Picture</label>\n' +
                '                    <input type="file" accept="image/*" name="picture[]"  class=" offset-md-1" onchange="loadFile(event)" >\n' +
                '                </div>\n' +
                '            </div><div class="col-12 my-3"><button id="remove_guest" type="button" class="btn btn-danger col-md-1"><i class="fa fa-trash"></i></button></div></div></div></div>');
        });
        $(document).on('click', '#remove_guest', function () {
            $(this).closest('#add_variation').remove();
        });
        $(document).ready(function () {
            $("#product_cat").change(function () {
                var val = $(this).val();
                {{--@php $val=document.write(val)' @endphp--}}
                $("#sub_cat").html("@foreach($category as $cat) @if($cat->parent_id==1)<option value='{{$cat->id}}'>{{$cat->name}}</option> @endif @endforeach");
            });
        });
        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        function openSelect(file) {
            $(file).trigger('click');
        }

        $(document).ready(function () {

            $('#product_tax').select2({
                    "language": {},
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }
            );
            $('#product_cat').select2({
                    "language": {},
                    escapeMarkup: function (markup) {
                        return markup;
                    }
                }
            );

        });

    </script>
@endsection
