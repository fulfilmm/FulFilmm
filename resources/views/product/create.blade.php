@extends("layout.mainlayout")
@section('title','Product Create')
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
        <form action="{{route("products.store")}}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Product Code</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                </div>
                                <input type="text" class="form-control" name="main_product_code">
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
                                            <option value="{{$tax->id}}">{{$tax->name}}({{$tax->rate}}%)</option>
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
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
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
                                <input type="text" class="form-control" name="model_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">Serial No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="serial_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12 ">
                            <label for="">SKU</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="sku" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Part No.</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="part_no" >
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label for="">Unit</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                                </div>
                                <input type="text" class="form-control" name="unit" >
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Currency</label>
                            <select name="unit" id="" class="select">
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
                                    <select name="mian_cat" id="mian_cat" class="form-control" onchange="giveSelection(this.value)" >
                                        <option value="">Select Category</option>
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
                                    <select name="sub_cat" id="sub_cat" class="form-control" >
                                        <option value="">Select Sub Category</option>
                                        @foreach($category as $cat)
                                            @if($cat->parent==0)
                                                <option value="{{$cat->id}}" data-option="{{$cat->parent_id}}">{{$cat->name}}</option>
                                            @endif
                                        @endforeach
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
                            <textarea name="detail" class="form-control" id="detail" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
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
                '<div class="col-md-4 col-12"><div class="form-group"><label>Product Code</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-pencil"></i></span></div><input type="text" class="form-control" name="product_code[]"></div></div></div>' +
                '<div class="col-md-4 col-12"><div class="form-group"><label>Discount Rate</label><input type="number" class="form-control" name="discount_rate[]"></div></div>' +
                '<div class="col-md-4 col-12 "><div class="form-group"><label>Exp Date</label><div class="input-group"><input type="date" class="form-control" id="exp_date" name="exp_date[]"></div></div></div>' +
                '<div class="col-md-4 col-12"><div class="form-group"><label for="">Picture</label><input type="file" name="picture[]"></div></div>'+
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
                '</div><input type="text" class="form-control" name="color[]"></div></div></div>'+
                '<div class="col-md-4 col-12"><div class="form-group"><label>Other</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fa fa-pencil"></i></span>' +
                '</div><input type="text" class="form-control" name="other[]"></div></div></div>'+
                '<div class="col-12 my-3"><button id="remove_guest" type="button" class="btn btn-danger col-md-1"><i class="fa fa-trash"></i></button></div></div></div></div>');
        });
        $(document).on('click', '#remove_guest', function () {
            $(this).closest('#add_variation').remove();
        });
        $(document).ready(function () {
            $(document).on('change','#product_cat',function () {
                var cat_id = $('#product_cat option:selected').val();
                @foreach($category as $cat)
                if (cat_id == "{{$cat->parent_id}}"){
                    $("#sub_cat").html("<option value={{$cat->id}}>{{$cat->name}}<option>");
                }
                @endforeach
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
        var sel1 = document.querySelector('#main_cat');
        var sel2 = document.querySelector('#sub_cat');
        var options2 = sel2.querySelectorAll('option');

        function giveSelection(selValue) {
            sel2.innerHTML = '';
            for(var i = 0; i < options2.length; i++) {
                if(options2[i].dataset.option === selValue) {
                    sel2.appendChild(options2[i]);
                }
            }
        }

        giveSelection(sel1);
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
