@extends('layout.mainlayout')
@section('title',$type.'Invoice Create')
@section('content')
    <style>
        hr {
            border: none;
            border-top: 1px dashed #f00;
            color: #fff;
            background-color: #fff;
            height: 1px;
            width: 100%;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create {{$type}} Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Invoice</li>
                        <li class="breadcrumb-item float-right">New</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-9">
                <div class="card shadow">
                    <div class="col-12">
                        <div class="row justify-content-between mt-4">
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="">Invoice Type</label>
                                    <select name="invoice_type" id="inv_type" class="form-control">
                                        <option value="General Invoice" {{isset($order_data)?($order_data->invoice_type=='General Invoice'?'selected':''):($data!=null?($data[0]['invoice_type']?'selected':''):'')}}>
                                            General Invoice
                                        </option>
                                        <option value="Cash On Delivery(COD)" {{isset($order_data)?($order_data->invoice_type=='Cash On Delivery(COD)'?'selected':''):($data!=null?($data[0]['invoice_type']?'selected':''):'')}}>
                                            Cash On Delivery
                                        </option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="inv_date">Invoice date <span class="text-danger">*</span></label>
                                    <input class="form-control shadow-sm" type="date" id="inv_date"
                                           value="{{isset($data[0]['inv_date'])?$data[0]['inv_date']:\Carbon\Carbon::now()->format('Y-m-d')}}">

                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input class="form-control shadow-sm" type="date" id="due_date"
                                           value="{{isset($data[0]['due_date'])?$data[0]['due_date']:\Carbon\Carbon::now()->format('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control shadow-sm" name="title" id="title"
                                           value="{{$data[0]['title']??''}}">
                                    <span class="text-danger title_err"></span>
                                </div>
                            </div>
                            <input type="hidden" id="invoice_id" class="form-control" value="{{$request_id[0]}}"
                                   readonly>

                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="bill_address">Order ID</label>
                                    <input type="text" class="form-control shadow-sm"
                                           value="{{isset($order_data)?$order_data->order_id:''}}" readonly>
                                    <input type="hidden" name="order_id" id="order_id" value="{{$order_data->id??''}}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="client_id">Client <span class="text-danger">*</span></label>
                                    <select class="form-control" id="client_id">
                                        <option value="">Select Client</option>
                                        @foreach($allcustomers as $client)
                                            <option value="{{$client->id}}" {{isset($order_data)?($client->id==$order_data->customer_id?'selected':''):($data!=null?($data[0]['client_id']?'selected':''):'')}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger client_id_err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="client_email">Email</label>
                                    <input class="form-control shadow-sm" type="email" id="client_email"
                                           value="{{$order_data->email??$data[0]['client_email']??''}}" required>
                                    <span class="text-danger client_email_err"></span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="client_address">Shipping Address <span
                                                class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" id="client_address"
                                           value="{{$order_data->address??$data[0]['client_address']??''}}">
                                    <span class="text-danger client_address_err"></span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="bill_address">Billing Address <span
                                                class="text-danger"> * </span></label>
                                    <input type="text" class="form-control shadow-sm" id="bill_address"
                                           value="{{$order_data->billing_address??$data[0]['bill_address']??''}}">
                                    <span class="text-danger bill_address_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <h4>Other Information</h4>
                                    <textarea class="form-control shadow-sm"
                                              id="more_info">{{$data[0]['more_info']??''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card shadow">
                    <div class="col-12">
                        <div class="form-group mt-4">
                            <label for="payment">Payment Type</label>
                            <select name="" id="payment" class="form-control">
                                <option value="Cash" {{isset($order_data)?($order_data->payment_method=='Cash'?'selected':''):($data!=null?($data[0]['payment_method']?'selected':''):'')}}>
                                    Cash
                                </option>
                                <option value="Bank" {{isset($order_data)?($order_data->payment_method=='Bank'?'selected':''):($data!=null?($data[0]['payment_method']?'selected':''):'')}}>
                                    Bank
                                </option>
                                <option value="KBZ Pay" {{isset($order_data)?($order_data->payment_method=='KBZ Pay'?'selected':''):($data!=null?($data[0]['payment_method']?'selected':''):'')}}>
                                    KBZPay
                                </option>
                                <option value="Wave Money" {{isset($order_data)?($order_data->payment_method=='Wave Money'?'selected':''):($data!=null?($data[0]['payment_method']?'selected':''):'')}}>
                                    Wave Money
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bill_address">Warehouse<span class="text-danger"> * </span></label>
                            <select name="" id="warehouse" class="form-control select2"
                                    onchange="giveSelection(this.value)">
                                @foreach($warehouse as $item)
                                    <option value="{{$item->warehouse_id}}">{{$item->warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 mt-4">
                            <input type="radio" class="mr-1" name="delionoff" id="on" value="on" checked><label for="">Delivery
                                Fee</label><br>
                            <input type="radio" class="mr-1" name="delionoff" id="off" value="off"><label for="">Not
                                Delivery Fee</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="col-12 my-3">
                        <button class="btn btn-primary m-r-10 my-3 col-12" type="button" id="saveAndsend">Save & Send
                        </button>
                        <button class="btn btn-primary my-3 col-12" type="button" id="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12 col-sm-12 ">
                <div class="card shadow">
                    <div class="col-12">
                        <h4 class="mt-3">Invoice Items</h4>
                        <div class="table-responsive">
                            @if(!isset($order_data))
                                <div class="row">
                                    <div class="col-md-8 col-12 my-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-4 col-4">
                                                <button type="button" title="Search By Product Name" id="p_name"
                                                        class="btn btn-white shadow-sm"><i class="la la-cube"></i>
                                                </button>
                                                <button type="button" title="Search By Product Code" id="p_code"
                                                        class="btn btn-white shadow-sm"><i class="la la-barcode"></i>
                                                </button>
                                                <button type="button" title="Give FOC" id="foc_button"
                                                        class="btn btn-white shadow-sm">FOC
                                                </button>
                                            </div>
                                            <div class="col-6 col-md-6" id="product_name">
                                                <div class="input-group">
                                                    <select name="" id="variant" class="form-control"
                                                            style="width: 80%">
                                                        <option value="" data-option="{{$item->warehouse_id}}">Search
                                                            Product Name
                                                        </option>
                                                        @foreach($aval_product as $item)
                                                            <option value="{{$item->variant->id}}"
                                                                    data-option="{{$item->warehouse_id}}">{{$item->variant->product_name}}
                                                                ( {{$item->variant->variant}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary col-md-12" id="add_item">Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6" id="product_code">
                                                <div class="input-group">
                                                    <select name="" id="code" class="form-control" style="width: 80%">
                                                        <option value="">Search Product Code</option>
                                                        @foreach($aval_product as $item)
                                                            <option value="{{$item->variant->id}}"
                                                                    data-option="{{$item->warehouse_id}}">{{$item->variant->product_code}} </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary col-md-12" id="add_item_code">
                                                            Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6" id="foc">
                                                <div class="input-group">
                                                    <select name="" id="foc_id" class="form-control input-group-sm"
                                                            style="width: 80%">
                                                        <option value="">Select FOC Item</option>
                                                        @foreach($focs as $item)
                                                            <option value="{{$item->variant_id}}">{{$item->variant->product_name}}
                                                                ({{$item->variant->variant}})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary col-md-12" id="foc_item">Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Discount With Amount</label><br>
                                            <input type="radio" name="amount_discount" checked value="1">
                                            <label for="">ON</label>
                                            <input type="radio" name="amount_discount" value="0">
                                            <label for="">Off</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-hover table-white table-bordered" id="order_table">
                                <thead>
                                <th colspan="3">Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Discount/Promotion</th>
                                <th>Total</th>
                                <th>Action</th>
                                </thead>
                                <tbody id="tbody">
                                @foreach($orderline as $order)
                                    <tr>
                                        <td style="min-width: 200px;" colspan="3">
                                            <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                            <div class="row">
                                                <input type="hidden" name="product_id" id="product_{{$order->id}}"
                                                       value="{{$order->product_id}}">
                                                @php
                                                    $img=json_decode($order->variant->image);
                                                @endphp
                                                @if($img!=null)
                                                    <div class="col-md-4">
                                                        <img src="{{url(asset('product_picture/'.$img[0]??''))}}"
                                                             alt="" style="max-width: 50px;max-height: 50px;">
                                                        {{--<span class="text-sm" style="font-size: 6px">@foreach($aval_product as $item) @if($item->variant_id==$order->variant_id) Aval: {{$item->available}} @endif @endforeach </span>--}}
                                                    </div>
                                                @else
                                                    <div class="col-md-4">
                                                        <img src="{{url(asset('img/profiles/avatar-01.jpg'))}}"
                                                             alt="" style="max-width: 50px;max-height: 50px;">
                                                        {{--<span class="badge badge-warning" style="font-size: 9px;">@foreach($aval_product as $item) @if($item->variant_id==$order->variant_id) Available: {{$item->available}} @endif @endforeach </span>--}}
                                                    </div>

                                                @endif

                                                <div class="col-8">
                                                    <div>
                                                        <span class="font-weight-bold">{{$order->variant->product_name}}</span><br>
                                                    </div>
                                                    <p class="m-0 mt-1">
                                                        {{$order->variant->variant}}
                                                        {!! $order->variant->description !!}

                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="quantity" id="quantity_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{$order->quantity}}" min="0"
                                                   max="3" {{isset($order_data)?'readonly':''}}>
                                        </td>
                                        <td>
                                            <div class="col-12">
                                                <div class="row">
                                                    <input type="number" id="price_{{$order->id}}"
                                                           class="form-control update_item_{{$order->id}}"
                                                           value="{{$order->foc?0:$order->unit_price}}" min="0"
                                                           oninput="validity.valid||(value='');"
                                                           style="min-width: 120px;">

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="" class="select_update" id="unit{{$order->id}}"
                                                    style="min-width: 100px">

                                                @foreach($unit_price as $item)
                                                    @if($order->variant->product_id==$item->product_id)
                                                        <option value="{{$item->id}}" {{$item->id==$order->sell_unit?'selected':''}}>{{$item->unit}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            @if($order->foc)
                                                <input type="text" class="form-control" value="FOC">
                                            @else
                                                <select name="" id="dis_pro{{$order->id}}"
                                                        class="form-control select_update">
                                                    <option value="0">Select Discount</option>
                                                    @foreach($dis_promo as $item)

                                                        @if($order->variant_id==$item->variant_id)
                                                            <option value="{{$item->rate}}" {{$item->rate==$order->discount_promotion?'selected':''}}>{{$item->rate}}
                                                                %
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="total" id="total_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}} total"
                                                   value="{{$order->foc?0:$order->total}}">
                                        </td>

                                        <td>
                                            @if(!isset($order_data))
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        id="remove{{$order->id}}"><i class="fa fa-trash-o "></i>
                                                </button>
                                                @include('invoice.item_remove')
                                            @endif
                                        </td>

                                    </tr>
                                    {{--                                @dd($unit_price)--}}
                                    <script>
                                        $(".update_item_{{$order->id}}").keyup(function () {
                                            var unit_id = $('#unit{{$order->id}} option:selected').val();
                                            @foreach($prices as $item)
                                            if (unit_id == "{{$item->unit_id}}") {
                                                if ('{{$order->variant->pricing_type}}' == 1) {
                                                    var qty = $('#quantity_{{$order->id}}').val();
                                                    if (parseInt("{{$item->min}}") <= qty) {
                                                        var price = "{{$item->price}}";
                                                    }

                                                } else {
                                                    if ('{{$item->multi_price}}' == 0) {

                                                        var price = "{{$item->price}}";

                                                    }
                                                }
                                            }
                                            @endforeach


                                            @if($order->foc)
                                            $('#price_{{$order->id}}').val(0);
                                            $('#total_{{$order->id}}').val(0);
                                            @else
                                            $('#price_{{$order->id}}').val(price);
                                            var quantity = $('#quantity_{{$order->id}}').val();
                                            var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                            var sub_total = quantity * price;
                                            var amount = (dis_pro / 100) * sub_total;
                                            var total = sub_total - amount;

                                            $('#total_{{$order->id}}').val(total);
                                            var sum = 0;
                                            $('.total').each(function () {
                                                sum += parseFloat($(this).val());
                                            });
                                            $('#total').val(sum);
                                            @endif

                                        });
                                        $(document).ready(function () {

                                            var unit_id = $('#unit{{$order->id}} option:selected').val();
                                            @foreach($prices as $item)
                                            if (unit_id == "{{$item->unit_id}}") {
                                                if ('{{$order->variant->pricing_type}}' == 1) {
                                                    var qty = $('#quantity_{{$order->id}}').val();
                                                    if (parseInt("{{$item->min}}") <= qty) {
                                                        var price = "{{$item->price}}";
                                                    }

                                                } else {
                                                    if ('{{$item->multi_price}}' == 0) {
                                                        var price = "{{$item->price}}";
                                                    }

                                                }
                                            }
                                            @endforeach


                                            @if($order->foc)
                                            $('#price_{{$order->id}}').val(0);
                                            $('#total_{{$order->id}}').val(0);
                                            @else
                                            $('#price_{{$order->id}}').val(price);
                                            var quantity = $('#quantity_{{$order->id}}').val();
                                            var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                            var sub_total = quantity * price;
                                            var amount = (dis_pro / 100) * sub_total;
                                            var total = sub_total - amount;
                                            $('#total_{{$order->id}}').val(total);
                                            var sum = 0;
                                            $('.total').each(function () {
                                                sum += parseFloat($(this).val());
                                            });
                                            $('#total').val(sum);
                                            @endif
                                            $('.select_update').change(function () {
                                                var unit_id = $('#unit{{$order->id}} option:selected').val();
                                                @foreach($prices as $item)
                                                if (unit_id == "{{$item->unit_id}}") {
                                                    if ('{{$order->variant->pricing_type}}' == 1) {
                                                        var qty = $('#quantity_{{$order->id}}').val();
                                                        if (parseInt("{{$item->min}}") <= qty) {
                                                            var price = "{{$item->price}}";
                                                        }

                                                    } else {
                                                        if ('{{$item->multi_price}}' == 0) {
                                                            var price = "{{$item->price}}";
                                                        }
                                                    }
                                                }
                                                @endforeach
                                                @if($order->foc)
                                                $('#price_{{$order->id}}').val(0);
                                                $('#total_{{$order->id}}').val(0);
                                                @else
                                                $('#price_{{$order->id}}').val(price);
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total = quantity * price;
                                                var amount = (dis_pro / 100) * sub_total;
                                                var total = sub_total - amount;
                                                $('#total_{{$order->id}}').val(total);
                                                var sum = 0;
                                                $('.total').each(function () {
                                                    sum += parseFloat($(this).val());
                                                });
                                                $('#total').val(sum);
                                                var product = $('#product_{{$order->id}}').val();
                                                var sell_unit = $('#unit{{$order->id}} option:selected').val();
                                                var discount_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                                @endif
                                                $.ajax({
                                                    data: {
                                                        "product_id": product,
                                                        'quantity': quantity,
                                                        'unit_price': price,
                                                        "total": total,
                                                        'sell_unit': sell_unit,
                                                        'discount_pro': discount_pro
                                                    },
                                                    type: 'PUT',
                                                    url: "{{route('invoice_items.update',$order->id)}}",
                                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                    success: function (data) {
                                                        console.log(data);
                                                        if (!$.isEmptyObject(data.out_of_stock)) {
                                                            swal('Empty Item', data.out_of_stock);

                                                        }

                                                    }
                                                });
                                            });
                                        });
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                @if($order->foc)
                                                $('#price_{{$order->id}}').val(0);
                                                $('#total_{{$order->id}}').val(0);
                                                        @else
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();
                                                var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total = quantity * price;
                                                var amount = (dis_pro / 100) * sub_total;
                                                var total = sub_total - amount;
                                                $('#total_{{$order->id}}').val(total);
                                                var sum = 0;
                                                $('.total').each(function () {
                                                    sum += parseFloat($(this).val());
                                                });
                                                $('#total').val(sum);
                                                @endif
                                            });
                                        });
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                var product = $('#product_{{$order->id}}').val();
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();
                                                var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total = quantity * price;
                                                var amount = (dis_pro / 100) * sub_total;
                                                var total = sub_total - amount;
                                                var sell_unit = $('#unit{{$order->id}} option:selected').val();
                                                var discount_pro = $('#dis_pro{{$order->id}} option:selected').val();
                                                $.ajax({
                                                    data: {
                                                        "product_id": product,
                                                        'quantity': quantity,
                                                        'unit_price': price,
                                                        "total": total,
                                                        'sell_unit': sell_unit,
                                                        'discount_pro': discount_pro
                                                    },
                                                    type: 'PUT',
                                                    url: "{{route('invoice_items.update',$order->id)}}",
                                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                    success: function (data) {
                                                        console.log(data);
                                                        if (!$.isEmptyObject(data.out_of_stock)) {

                                                                swal({title: "Not Enough Quantity", text: data.out_of_stock, type:
                                                                        "success"}).then(function(){
                                                                        location.reload();
                                                                    }

                                                            );

                                                        }

                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                @endforeach


                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Total</span></th>
                                    <td id="total_div" colspan="2"><input class="form-control" type="number" id="total">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Discount</span></th>

                                    <td id="discount_div" colspan="2"><div class="input-group">
                                            <input class="form-control" type="text"
                                                   id="discount" value="0.0">
                                            <div class="input-group-append">
                                                <button class="btn btn-white" id="percentage"></button>
                                            </div>

                                        </div></td>
                                </tr>
                                <tr id="delivery">
                                    <th colspan="7" class="text-right"><span class="mt-5">Delivery Fee</span></th>
                                    <td colspan="2">
                                        <input type="number" class="form-control" name="delivery_fee" id="deli_fee"
                                               value="0.0">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Tax</span></th>
                                    <td colspan="2">
                                        <select name="" id="tax" class="form-control select_update" style="width: 100%">
                                            @foreach($taxes as $tax)
                                                <option value="{{$tax->id}}">{{$tax->name}} ({{$tax->rate}} %)</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="tax_amount" name="tax_mount">
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Grand Total</span></th>
                                    <td colspan="2" id="grand_total_div">
                                        <input class="form-control" type="text" id="grand_total">
                                    </td>
                                    <td></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--                            <input type="hidden" id="generate_id" value="{{$generate_id}}">--}}
    </div>
    <script>
        $(document).ready(function () {
            var tax = $('#tax option:selected').val();
            var sum =$('#total').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ='{{$tax->rate}}';
                    @endforeach
            var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
            // var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            var grand=(parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount));
            if(isNaN(grand)){
                $('#total').val('0');
                $('#grand_total').val('0.0');
            }else {
                var on_off=$('input[name="amount_discount"]:checked').val();
                if(on_off==1){

                  if('{{$amount_discount->isEmpty()}}'){
                      $('#grand_total').val(grand);
                  }else{
                      @foreach($amount_discount as $item)
                      if(sum > parseFloat('{{$item->min_amount}}') && sum < parseFloat('{{$item->max_amount}}')){
                          var discount=(parseInt('{{$item->rate}}')/100)*sum;
                          var sub_total=grand - discount;
                          $('#percentage').show();
                          $('#discount').val(discount);
                          $('#percentage').text('{{$item->rate}}'+'%');
                          $('#grand_total').val(sub_total);
                      }
                      @endforeach
                  }
                }else {
                    $('#discount').val('0.0');
                    $('#percentage').hide();
                    $('#grand_total').val(grand);
                }
            }

            $('select').change(function () {
                var tax = $('#tax option:selected').val();
                var sum =$('#total').val();
                @foreach($taxes as $tax)
                if (tax == "{{$tax->id}}")
                    var tax_rate ='{{$tax->rate}}';
                        @endforeach
                var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
                // var discount = $('#discount').val();
                var deli_fee = $('#deli_fee').val();
                var on_off=$('input[name="amount_discount"]:checked').val();
                var grand=(parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount));
                if(on_off==1){
                    if('{{$amount_discount->isEmpty()}}'){
                        $('#grand_total').val(grand);
                    }else{
                        @foreach($amount_discount as $item)
                        if(sum > parseFloat('{{$item->min_amount}}') && sum < parseFloat('{{$item->max_amount}}')){
                            var discount=(parseInt('{{$item->rate}}')/100)*sum;
                            var sub_total=grand - discount;
                            $('#percentage').show();
                            $('#discount').val(discount);
                            $('#percentage').text('{{$item->rate}}'+'%');
                            $('#grand_total').val(sub_total);
                        }
                        @endforeach
                    }
                }else {
                    $('#discount').val('0.0');
                    $('#percentage').hide();
                    $('#grand_total').val(grand);
                }

            });
            $('input[name="amount_discount"]').change(function () {
                var tax = $('#tax option:selected').val();
                var sum =$('#total').val();
                @foreach($taxes as $tax)
                if (tax == "{{$tax->id}}")
                    var tax_rate ='{{$tax->rate}}';
                        @endforeach
                var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
                // var discount = $('#discount').val();
                var deli_fee = $('#deli_fee').val();
                var on_off=$('input[name="amount_discount"]:checked').val();
                var grand=(parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount));
                if(on_off==1){
                    if('{{$amount_discount->isEmpty()}}'){
                        $('#grand_total').val(grand);
                    }else{
                        @foreach($amount_discount as $item)
                        if(sum > parseFloat('{{$item->min_amount}}') && sum < parseFloat('{{$item->max_amount}}')){
                            var discount=(parseInt('{{$item->rate}}')/100)*sum;
                            var sub_total=grand - discount;
                            $('#percentage').show();
                            $('#discount').val(discount);
                            $('#percentage').text('{{$item->rate}}'+'%');
                            $('#grand_total').val(sub_total);
                        }
                        @endforeach
                    }
                }else {

                    $('#discount').val('0.0');
                    $('#percentage').hide();
                    $('#grand_total').val(grand);
                }

            });
            $('input').keyup(function () {
                var tax = $('#tax option:selected').val();
                var sum =$('#total').val();
                @foreach($taxes as $tax)
                if (tax == "{{$tax->id}}")
                    var tax_rate ='{{$tax->rate}}';
                        @endforeach
                var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
                // var discount = $('#discount').val();
                var deli_fee = $('#deli_fee').val();
                var on_off=$('input[name="amount_discount"]:checked').val();
                var grand=(parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount));
                if(on_off==1){
                    if('{{$amount_discount->isEmpty()}}'){
                        $('#grand_total').val(grand);
                    }else{
                        @foreach($amount_discount as $item)
                        if(sum > parseFloat('{{$item->min_amount}}') && sum < parseFloat('{{$item->max_amount}}')){
                            var discount=(parseInt('{{$item->rate}}')/100)*sum;
                            var sub_total=grand - discount;
                            $('#percentage').show();
                            $('#discount').val(discount);
                            $('#percentage').text('{{$item->rate}}'+'%');
                            $('#grand_total').val(sub_total);
                        }
                        @endforeach
                    }
                }else {
                    $('#grand_total').val(grand);
                }


            });
        });

        $(document).ready(function () {
            $('#product_code').hide();
            $('#foc').hide();
            $('#p_code').click(function () {
                $('#p_code').addClass('btn-primary');
                $('#p_name').removeClass('btn-primary');
                $('#foc_button').removeClass('btn-primary');
                $('#product_name').hide();
                $('#foc').hide();
                $('#product_code').show();
            });
            $('#p_name').click(function () {
                $('#p_name').addClass('btn-primary');
                $('#p_code').removeClass('btn-primary');
                $('#foc_button').removeClass('btn-primary');
                $('#product_name').show();
                $('#foc').hide();
                $('#product_code').hide();
            });
            $('#foc_button').click(function () {
                $('#foc').show();
                $('#foc_button').addClass('btn-primary');
                $('#p_code').removeClass('btn-primary');
                $('#p_name').removeClass('btn-primary');
                $('#product_name').hide();
                $('#product_code').hide();

            });
        });
        $(document).ready(function () {

            $('select').select2();

        });

        $(document).ready(function () {
            $('#client_id').change(function () {
                var client_id=$(this).val();
                @foreach($allcustomers as $client)
                if(client_id=='{{$client->id}}'){
                    $('#client_address').val("{{$client->address}}");
                    $('#client_email').val("{{$client->email}}");
                }
                @endforeach
            }) ;
        });
        $(document).ready(function () {
            $('input[type="radio').change(function () {
                var deli=$(this).val();
                if(deli=='on'){
                    $('#delivery').show();
                }else if(deli=='off'){
                    $('#delivery').hide();
                }
            });
        });

        $(document).on('click', '#add_item', function () {
            var variant_id = $('#variant option:selected').val();
            var invoice_id = $('#invoice_id').val();
            var client_id = $('#client_id').val();
            var client_email = $('#client_email').val();
            var inv_date = $('#inv_date').val();
            var due_date = $('#due_date').val();
            var client_address = $('#client_address').val();
            var bill_address = $('#bill_address').val();
            var more_info = $('#more_info').val();
            var inv_grand_total = $('#inv_grand_total').val();
            var payment = $('#payment option:selected').val();
            var status = $('#status option:selected').val();
            var inv_type = $('#inv_type option:selected').val();
            var title = $('#title').val();
            var order_id = $('#order_id').val();
            $.ajax({
                data: {
                    'variant_id': variant_id,
                    "invoice_id": invoice_id,
                    'title': title,
                    "client_id": client_id,
                    'client_email': client_email,
                    'inv_date': inv_date,
                    "due_date": due_date,
                    'client_address': client_address,
                    "more_info": more_info,
                    'inv_grand_total': inv_grand_total,
                    'bill_address': bill_address,
                    'status': status,
                    'order_id': order_id,
                    'payment_method': payment,
                    'type': 'invoice',
                    'invoice_type':inv_type,
                    'inv_type':'{{$type}}'

                },
                type: 'POST',
                url: "{{route('invoice_items.store')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    var alltotal = [];
                    $('.total').each(function () {
                        alltotal.push(this.value);
                    });
                    var grand_total = 0;
                    for (var i = 0; i < alltotal.length; i++) {
                        grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);
                    }
                    if (!$.isEmptyObject(data.Error)) {
                        // alert(data.orderempty);
                        swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                    }else {

                        location.reload();
                    }
                }
            });

        });

        $(document).on('click', '#add_item_code', function (event) {
            var code=$('#code option:selected').val();
            var invoice_id = $('#invoice_id').val();
            var client_id = $('#client_id').val();
            var client_email = $('#client_email').val();
            var inv_date = $('#inv_date').val();
            var due_date = $('#due_date').val();
            var client_address = $('#client_address').val();
            var bill_address = $('#bill_address').val();
            var more_info = $('#more_info').val();
            var inv_grand_total = $('#inv_grand_total').val();
            var payment = $('#payment option:selected').val();
            var status = $('#status option:selected').val();
            var title = $('#title').val();
            var order_id = $('#order_id').val();
            var inv_type = $('#inv_type option:selected').val();
            $.ajax({
                data: {
                    'variant_id': code,
                    "invoice_id": invoice_id,
                    'title': title,
                    "client_id": client_id,
                    'client_email': client_email,
                    'inv_date': inv_date,
                    "due_date": due_date,
                    'client_address': client_address,
                    "more_info": more_info,
                    'inv_grand_total': inv_grand_total,
                    'bill_address': bill_address,
                    'status': status,
                    'order_id': order_id,
                    'payment_method': payment,
                    'type': 'invoice',
                    'invoice_type':inv_type,
                    'inv_type':'{{$type}}'

                },
                type: 'POST',
                url: "{{route('invoice_items.store')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    var alltotal = [];
                    $('.total').each(function () {
                        alltotal.push(this.value);
                    });
                    var grand_total = 0;
                    for (var i = 0; i < alltotal.length; i++) {
                        grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);
                    }
                    if (!$.isEmptyObject(data.Error)) {
                        // alert(data.orderempty);
                        swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                    }else {

                        location.reload();
                    }
                }
            });

        });
        $(document).on('click', '#foc_item', function (event) {
            var foc=$('#foc_id option:selected').val();
            var invoice_id = $('#invoice_id').val();
            var client_id = $('#client_id').val();
            var client_email = $('#client_email').val();
            var inv_date = $('#inv_date').val();
            var due_date = $('#due_date').val();
            var client_address = $('#client_address').val();
            var bill_address = $('#bill_address').val();
            var more_info = $('#more_info').val();
            var inv_grand_total = $('#inv_grand_total').val();
            var payment = $('#payment option:selected').val();
            var status = $('#status option:selected').val();
            var title = $('#title').val();
            var order_id = $('#order_id').val();
            var inv_type = $('#inv_type option:selected').val();
            $.ajax({
                data: {
                    'variant_id': foc,
                    "invoice_id": invoice_id,
                    'title': title,
                    "client_id": client_id,
                    'client_email': client_email,
                    'inv_date': inv_date,
                    "due_date": due_date,
                    'client_address': client_address,
                    "more_info": more_info,
                    'inv_grand_total': inv_grand_total,
                    'bill_address': bill_address,
                    'status': status,
                    'order_id': order_id,
                    'payment_method': payment,
                    'type': 'invoice',
                    'invoice_type':inv_type,
                    'foc':1

                },
                type: 'POST',
                url: "{{route('invoice_items.store')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    var alltotal = [];
                    $('.total').each(function () {
                        alltotal.push(this.value);
                    });
                    var grand_total = 0;
                    for (var i = 0; i < alltotal.length; i++) {
                        grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);
                    }
                    if (!$.isEmptyObject(data.Error)) {
                        // alert(data.orderempty);
                        swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                    }else {

                        location.reload();
                    }
                }
            });

        });
        $(document).ready(function () {
            $(document).on('click', '#saveAndsend', function () {
                var client_id = $('#client_id').val();
                var client_email = $('#client_email').val();
                var inv_date = $('#inv_date').val();
                var due_date = $('#due_date').val();
                var client_address = $('#client_address').val();
                var bill_address = $('#bill_address').val();
                var more_info = $('#more_info').val();
                var inv_grand_total = $('#grand_total').val();
                var payment = $('#payment option:selected').val();
                var status = $('#status option:selected').val();
                var title = $('#title').val();
                var order_id = $('#order_id').val();
                var action_type = 'save_and_send';
                var discount = $('#discount').val();
                var total = $('#total').val();
                var tax_id = $('#tax option:selected').val();
                var tax_amount = $('#tax_amount').val();
                var inv_type = $('#inv_type option:selected').val();
                var deli_fee = $('#deli_fee').val();
                var warehouse=$('#warehouse option:selected').val();
                var delivery_onoff=$('input[name="delionoff"]:checked').val();
                $.ajax({
                    data: {
                        'discount': discount,
                        'total': total,
                        'tax_id': tax_id,
                        'tax_amount': tax_amount,
                        'title': title,
                        "client_id": client_id,
                        'client_email': client_email,
                        'inv_date': inv_date,
                        "due_date": due_date,
                        'client_address': client_address,
                        "more_info": more_info,
                        'inv_grand_total': inv_grand_total,
                        'bill_address': bill_address,
                        "save_type": action_type,
                        'status': status,
                        'order_id': order_id,
                        'payment_method': payment,
                        'invoice_type': inv_type,
                        'delivery_fee': deli_fee,
                        'inv_type':"{{$type}}",
                        'warehouse_id':warehouse,
                        'deli_fee_include':delivery_onoff
                    },
                    type: 'POST',
                    url: "{{route('invoices.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        if (!$.isEmptyObject(data.orderempty)) {
                            swal('Empty Item', 'You invoice does not have any item.', 'error');

                        } else if ($.isEmptyObject(data.error)) {
                            console.log(data);
                            swal('Invoice Crete', 'Invoice Create Success', 'success');

                            window.location = data.url;
                        } else {
                            $.each(data.error, function (key, value) {
                                console.log(key);
                                $('.' + key + '_err').text(value);
                            });
                        }
                    }
                });
            });
        });

        //save only
        $(document).ready(function () {
            $(document).on('click', '#save', function () {
                var client_id = $('#client_id').val();
                var client_email = $('#client_email').val();
                var inv_date = $('#inv_date').val();
                var due_date = $('#due_date').val();
                var client_address = $('#client_address').val();
                var more_info = $('#more_info').val();
                var bill_address = $('#bill_address').val();
                var inv_grand_total = $('#grand_total').val();
                var payment = $('#payment option:selected').val();
                var status = $('#status option:selected').val();
                var title = $('#title').val();
                var order_id = $('#order_id').val();
                var discount = $('#discount').val();
                var total = $('#total').val();
                var tax_id = $('#tax option:selected').val();
                var tax_amount = $('#tax_amount').val();
                var inv_type = $('#inv_type option:selected').val();
                var deli_fee = $('#deli_fee').val();
                var warehouse=$('#warehouse option:selected').val();
                var delivery_onoff=$('input[name="delionoff"]:checked').val();
                $.ajax({
                    data: {
                        'discount': discount,
                        'total': total,
                        'tax_id': tax_id,
                        'tax_amount': tax_amount,
                        'order_id': order_id,
                        'title': title,
                        'client_id': client_id,
                        'client_email': client_email,
                        'inv_date': inv_date,
                        'due_date': due_date,
                        'client_address': client_address,
                        'more_info': more_info,
                        'bill_address': bill_address,
                        'inv_grand_total': inv_grand_total,
                        'status': status,
                        'payment_method': payment,
                        'invoice_type': inv_type,
                        'delivery_fee': deli_fee,
                        'inv_type':"{{$type}}",
                        'warehouse_id':warehouse,
                        'deli_fee_include':delivery_onoff

                    },
                    type: 'POST',
                    url: "{{route('invoices.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        if (!$.isEmptyObject(data.orderempty)) {
                            swal('Empty Item', 'You invoice does not have any item.', 'error');

                        } else if ($.isEmptyObject(data.error)) {
                            console.log(data);
                            swal('Invoice Create', 'Invoice Create Success', 'success');

                            window.location = data.url;
                        } else {
                            $.each(data.error, function (key, value) {
                                console.log(key);
                                $('.' + key + '_err').text(value);
                            });
                        }
                    }
                });
            });
        });
        var warehouse = document.querySelector('#warehouse');
        var product_name = document.querySelector('#variant');
        var code = document.querySelector('#code');
        var options2 = product_name.querySelectorAll('option');
        var options3 = code.querySelectorAll('option');
        console.log(options3);
        // alert(product)
        function giveSelection(selValue) {
            variant.innerHTML='';
            code.innerHTML='';

            for(var i = 0; i < options2.length; i++) {
                if(options2[i].dataset.option === selValue) {
                    variant.appendChild(options2[i]);
                    code.appendChild(options3[i]);

                }
            }
        }
        giveSelection(warehouse.value);
        // window.onbeforeunload = closeWindow;
    </script>

    <!-- /Page Content -->

@endsection