@extends('layout.mainlayout')
@section('title',$invoice->inv_type.'Invoice Edit')
@section('content')
    <style>
        hr {
            border:none;
            border-top:1px dashed #f00;
            color:#fff;
            background-color:#fff;
            height:1px;
            width:100%;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit {{$invoice->inv_type}} Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Invoice</li>
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
                                        <option value="General Invoice" {{$invoice->inv_type=='General Invoice'?'selected':''}}>General Invoice</option>
                                        <option value="Cash On Delivery(COD)" {{$invoice->inv_type=='Cash On Delivery(COD)'?'selected':''}}>Cash On Delivery</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="inv_date">Invoice date <span class="text-danger">*</span></label>
                                    <input class="form-control shadow-sm" type="date" id="inv_date" value="{{\Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d')}}">

                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input class="form-control shadow-sm" type="date" id="due_date" value="{{\Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control shadow-sm" name="title" id="title"
                                           value="{{$invoice->title??''}}">
                                    <span class="text-danger title_err"></span>
                                </div>
                            </div>
                            <input type="hidden" id="invoice_id" class="form-control" value="{{$invoice->invoice_id}}" readonly>

                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="bill_address">Order ID</label>
                                    <input type="text" class="form-control shadow-sm"
                                           value="{{$invoice->order_id??''}}" readonly>
                                    <input type="hidden" name="order_id" id="order_id" value="{{$invoice->order_id??''}}">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="client_id">Client <span class="text-danger">*</span></label>
                                    <select class="form-control" id="client_id">
                                        <option value="">Select Client</option>
                                        @foreach($allcustomers as $client)
                                            <option value="{{$client->id}}" {{$invoice->customer_id==$client->id?'selected':''}} >{{$client->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="client_email">Email</label>
                                    <input class="form-control shadow-sm" type="email" id="client_email"
                                           value="{{$invoice->email??''}}" required>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="client_address">Shipping Address <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" id="client_address"
                                           value="{{$invoice->customer_address??''}}">
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-6">
                                <div class="form-group">
                                    <label for="bill_address">Billing Address <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control shadow-sm" id="bill_address"
                                           value="{{$invoice->billing_address??''}}">
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <h4>Other Information</h4>
                                    <textarea class="form-control shadow-sm" id="more_info">{{$invoice->other_information??''}}</textarea>
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
                                <option value="Cash" {{$invoice->payment_method=='Cash'?'selected':''}}>
                                    Cash
                                </option>
                                <option value="Bank" {{$invoice->payment_method=='Bank'?'selected':''}}>
                                    Bank
                                </option>
                                <option value="KBZ Pay" {{$invoice->payment_method=='KBZ Pay'?'selected':''}}>
                                    KBZPay
                                </option>
                                <option value="Wave Money" {{$invoice->payment_method=='Wave Money'?'selected':''}}>
                                    Wave Money
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bill_address">Warehouse<span class="text-danger"> * </span></label>
                            <select name="" id="warehouse" class="form-control select2" onchange="giveSelection(this.value)">
                                @foreach($warehouse as $item)
                                    <option value="{{$item->id}}" {{$invoice->warehouse_id==$item->id?'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 mt-4">
                            <input type="radio" class="mr-1" name="delionoff" id="on" value="on" {{$invoice->delivery_fee!=null?'checked':''}}><label for="">Delivery Fee</label><br>
                            <input type="radio" class="mr-1" name="delionoff" id="off" value="off" {{$invoice->delivery_fee==null?'checked':''}}><label for="">Not Delivery Fee</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="col-12 my-3">
                        <button class="btn btn-primary my-3 col-12" type="button" id="save">Update</button>
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
                                                <button type="button" title="Search By Product Name" id="p_name" class="btn btn-white shadow-sm"><i class="la la-cube"></i></button>
                                                <button type="button" title="Search By Product Code" id="p_code" class="btn btn-white shadow-sm"><i class="la la-barcode"></i></button>
                                                <button type="button" title="Give FOC" id="foc_button" class="btn btn-white shadow-sm">FOC</button>
                                            </div>
                                            <div class="col-6 col-md-6" id="product_name">
                                                <div class="input-group">
                                                    <select name="" id="variant" class="form-control" style="width: 80%">
                                                        <option value="" data-option="{{$item->warehouse_id}}">Search Product Name</option>
                                                        @foreach($aval_product as $item)
                                                            <option value="{{$item->variant->id}}"
                                                                    data-option="{{$item->warehouse_id}}">{{$item->variant->product_name}} ( {{$item->variant->variant}})</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary col-md-12" id="add_item">Add</button>
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
                                                        <button class="btn btn-primary col-md-12" id="add_item_code">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-6" id="foc">
                                                <div class="input-group">
                                                    <select name="" id="foc_id" class="form-control input-group-sm" style="width: 80%">
                                                        <option value="">Select FOC Item</option>
                                                        @foreach($focs as $item)
                                                            <option value="{{$item->variant_id}}">{{$item->variant->product_name}}({{$item->variant->variant}})</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary col-md-12" id="foc_item">Add</button>
                                                    </div>
                                                </div>
                                            </div>

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
                                                    </div>
                                                @endif
                                                <div class="col-8">
                                                    <div>
                                                        <span class="font-weight-bold">{{$order->variant->product_name}}</span><br>
                                                        <span>@foreach($aval_product as $item) @if($item->variant_id==$order->variant_id) Aval: {{$item->available}} @endif @endforeach </span>
                                                    </div>
                                                    <p class="m-0 mt-1">
                                                        {{$order->variant->variant}}
                                                        {!! $order->variant->description !!}

                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                           {{$order->quantity??''}}
                                        </td>
                                        <td>
                                            <div class="col-12">
                                                <div class="row">
                                                  {{$order->unit_price}}

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{$order->unit->unit}}
                                        </td>
                                        <td>
                                            @if($order->foc)
                                                <input type="text" class="form-control" value="FOC">
                                            @else
                                               {{$order->discount_promotion??''}} %
                                            @endif
                                        </td>
                                        <td>
                                            {{$order->foc?0:$order->total}}
                                            <input type="hidden" class="total" id="" value="{{$order->foc?0:$order->total}}">
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
                                @endforeach


                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Total</span></th>
                                    <td id="total_div" colspan="2"><input class="form-control" type="number" id="total">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Discount</span></th>

                                    <td id="discount_div" colspan="2"><input class="form-control" type="text"
                                                                             id="discount" value="{{$invoice->discount??'0.0'}}"></td>
                                </tr>
                                <tr id="delivery">
                                    <th colspan="7" class="text-right"><span class="mt-5">Delivery Fee</span></th>
                                    <td colspan="2">
                                        <input type="number" class="form-control" name="delivery_fee" id="deli_fee" value="{{$invoice->delivery_fee??'0.0'}}">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="7" class="text-right"><span class="mt-5">Tax</span></th>
                                    <td colspan="2">
                                        <select name="" id="tax" class="form-control select_update" style="width: 100%">
                                            @foreach($taxes as $tax)
                                                <option value="{{$tax->id}}" {{$tax->id==$invoice->tax_id?'selected':''}}>{{$tax->name}} ({{$tax->rate}} %)</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="tax_amount" name="tax_mount" {{$invoice->tax_amount??'0'}}>
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

            var unit_id = $('#unit{{$order->id}} option:selected').val();
            @foreach($unit_price as $item)
            if (unit_id == "{{$item->id}}") {
                var price = "{{$item->price}}";
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
            var tax = $('#tax option:selected').val();
            var sum =$('#total').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ='{{$tax->rate}}';
                    @endforeach
            var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
            var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
            $('select').change(function () {
                var tax = $('#tax option:selected').val();
                var sum =$('#total').val();
                @foreach($taxes as $tax)
                if (tax == "{{$tax->id}}")
                    var tax_rate ='{{$tax->rate}}';
                        @endforeach
                var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
                var discount = $('#discount').val();
                var deli_fee = $('#deli_fee').val();
                $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
            });
            $('input').keyup(function () {
                var tax = $('#tax option:selected').val();
                var sum =$('#total').val();
                @foreach($taxes as $tax)
                if (tax == "{{$tax->id}}")
                    var tax_rate ='{{$tax->rate}}';
                        @endforeach
                var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
                var discount = $('#discount').val();
                var deli_fee = $('#deli_fee').val();
                $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
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
                    'inv_type':'{{$invoice->inv_type}}'

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
                    'inv_type':'{{$invoice->inv_type}}'

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
                        'inv_type':"{{$invoice->inv_type}}",
                        'warehouse_id':warehouse

                    },
                    type: 'PUT',
                    url: "{{route('invoices.update',$invoice->id)}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        // console.log(data.errors);
                        if (!$.isEmptyObject(data.orderempty)) {
                            // alert(data.orderempty);
                            swal('Empty Item', 'You invoice does not have any item.', 'error');
                        } else {
                            window.location.href = data.url;
                        }
                    },
                    error: function (data) {
                        $.each(data.errors, function (key, value) {
                            // console.log(key);
                            alert(value);
                            $('.' + key + '_err').text(value);
                        });

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