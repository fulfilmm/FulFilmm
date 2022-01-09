@extends('layout.mainlayout')
@section('title','Invoice Create')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Invoice</h3>
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
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   value="{{$data[0]['title']??''}}">
                            <span class="text-danger title_err"></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
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
                    </div>
                    <input type="hidden" id="invoice_id" class="form-control" value="{{$request_id[0]}}" readonly>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="">Invoice Type</label>
                            <select name="invoice_type" id="inv_type" class="form-control">
                                <option value="General Invoice">General Invoice</option>
                                <option value="Cash On Delivery(COD)">Cash On Delivery</option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-4">
                        <div class="form-group">
                            <label for="bill_address">Order ID</label>
                            <input type="text" class="form-control"
                                   value="{{isset($order_data)?$order_data->order_id:''}}" readonly>
                            <input type="hidden" name="order_id" id="order_id" value="{{$order_data->id??''}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="inv_date">Invoice date <span class="text-danger">*</span></label>
                            <input class="form-control " type="date" id="inv_date" value="{{$data[0]['inv_date']??''}}">

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="due_date">Due Date <span class="text-danger">*</span></label>
                            <input class="form-control" type="date" id="due_date" value="{{$data[0]['due_date']??''}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="client_id">Client <span class="text-danger">*</span></label>
                            <select class="form-control" id="client_id">
                                <option value="">Select Client</option>
                                @foreach($allcustomers as $client)
                                    <option value="{{$client->id}}" {{isset($order_data)?($client->id==$order_data->customer_id?'selected':''):($data!=null?($data[0]['client_id']?'selected':''):'')}}>{{$client->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label for="client_email">Email</label>
                            <input class="form-control" type="email" id="client_email"
                                   value="{{$order_data->email??$data[0]['client_email']??''}}" required>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-4">
                        <div class="form-group">
                            <label for="client_address">Shipping Address <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" id="client_address"
                                   value="{{$order_data->address??$data[0]['client_address']??''}}">
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-4">
                        <div class="form-group">
                            <label for="bill_address">Billing Address <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" id="bill_address"
                                   value="{{$order_data->billing_address??$data[0]['bill_address']??''}}">
                        </div>
                    </div>
                    <div class="form-group col-md-8 mt-5">
                        <input type="radio" class="mr-2 ml-5" name="delionoff" id="on" value="on" checked><label for="">Include Delivery Fee</label>
                        <input type="radio" class="mr-2 ml-5" name="delionoff" id="off" value="off"><label for="">Not Include Delivery Fee</label>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Other Information</label>
                            <textarea class="form-control" id="more_info">{{$data[0]['more_info']??''}}</textarea>
                        </div>
                    </div>

                </div>
                <div class="row border-top">

                    <div class="col-md-12 col-sm-12">
                        <h4 class="mt-3">Invoice Items</h4>
                        <div class="table-responsive">
                            @if(!isset($order_data))
                                <div class="row my-3">
                                    <div class="col-md-5 col-5">
                                        <select name="" id="product" class="form-control"
                                                onchange="giveSelection(this.value)">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 col-5">
                                        <select name="" id="variant" class="form-control">
                                            <option value="">Select Variant</option>
                                            @foreach($variants as $variant)
                                                <option value="{{$variant->id}}"
                                                        data-option="{{$variant->product_id}}">{{$variant->size??''}}{{$variant->color?','.$variant->color:''}}{{$variant->other?','.$variant->other:''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary col-md-12" id="add_item">Add</button>
                                    </div>
                                </div>
                            @endif
                            <table class="table table-hover table-white" id="order_table">
                                <thead>
                                <th colspan="3">Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                                </thead>
                                <tbody id="tbody">
                                @foreach($orderline as $order)
                                    <tr>
                                        <td style="min-width: 400px;" colspan="3">
                                            <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                            <div class="row">
                                                <input type="hidden" name="product_id" id="product_{{$order->id}}"
                                                       value="{{$order->product_id}}">
                                                <div class="col-md-4">
                                                    <img src="{{url(asset('product_picture/'.$order->variant->image))}}"
                                                         alt="" width="40px" height="40px">
                                                </div>
                                                <div class="col-8">
                                                    <div>
                                                        <span class="font-weight-bold">{{$order->product->name}}</span>
                                                    </div>
                                                    <p class="m-0 mt-1">
                                                        {{$order->variant->description}}
                                                        {{$order->variant->size??''}} {{$order->variant->color??''}} {{$order->variant->other??''}}
                                                    </p>
                                                    <p>

                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="quantity" id="quantity_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{$order->quantity}}" {{isset($order_data)?'readonly':''}}>
                                        </td>
                                        <td>
                                            <input type="number" id="price_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{$order->unit_price}}" min="0"
                                                   oninput="validity.valid||(value='');" style="min-width: 120px;">
                                        </td>
                                        <td>
                                            <input type="text" name="total" id="total_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{number_format($order->total)}}">
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
                                    <script>
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();

                                                var total = quantity * price;
                                                $('#total_{{$order->id}}').val(total);
                                            });
                                        });
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                var product = $('#product_{{$order->id}}').val();
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();
                                                var total = $('#total_{{$order->id}}').val();
                                                $.ajax({
                                                    data: {
                                                        "product_id": product,
                                                        'quantity': quantity,
                                                        'unit_price': price,
                                                        "total": total
                                                    },
                                                    type: 'PUT',
                                                    url: "{{route('invoice_items.update',$order->id)}}",
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
                                                        $('#grand_total').val(grand_total);
                                                        // $("#order_table").load(location.href + " #order_table>* ");
                                                        $("#grand_total_div").load(location.href + " #grand_total_div>* ");
                                                        $("#total_div").load(location.href + " #total_div>* ");

                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                @endforeach

                                </tbody>
                                <tr>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Total</span></th>
                                    <td id="total_div" colspan="2"><input class="form-control" type="number" id="total"
                                                                          value="{{$grand_total}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Discount</span></th>

                                    <td id="discount_div" colspan="2"><input class="form-control" type="text"
                                                                             id="discount" value="0.0"></td>
                                </tr>
                                <tr id="delivery">
                                    <td colspan="2"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Delivery Fee</span></th>
                                    <td colspan="2">
                                        <input type="number" class="form-control" name="delivery_fee" id="deli_fee" value="0.0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Tax</span></th>
                                    <td colspan="2">
                                        <select name="" id="tax" class="form-control" style="width: 100%">
                                            @foreach($taxes as $tax)
                                                <option value="{{$tax->id}}">{{$tax->name}} ({{$tax->rate}} %)</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="tax_amount" name="tax_mount">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Grand Total</span></th>
                                    <td colspan="2" id="grand_total_div">
                                        <input class="form-control" type="text" id="grand_total"
                                               value="{{$grand_total}}">
                                    </td>
                                    <td></td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                {{--                            <input type="hidden" id="generate_id" value="{{$generate_id}}">--}}
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn m-r-10" type="button" id="saveAndsend">Save & Send
                    </button>
                    <button class="btn btn-primary submit-btn" type="button" id="save">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <script>

        $(document).ready(function () {

            $('select').select2();

        });
        $(document).ready(function () {
           $('#client_id').change(function () {
               var client_id=$(this).val();
               @foreach($allcustomers as $client)
                   if(client_id=={{$client->id}}){
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
        $('input').keyup(function () {
            var tax = $('#tax option:selected').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ={{$tax->rate}};
                    @endforeach
            var total = $('#total').val();
            var tax_amount = parseFloat(total) * (tax_rate / 100);
            var tax_include = parseFloat(total) + tax_amount;
            var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            var grand = (tax_include - discount) + parseFloat(deli_fee);
            $('#grand_total').val(parseFloat(grand));
            $('#tax_amount').val(tax_amount);
        });
        $(document).on('change', '#tax', function () {
            var tax = $('#tax option:selected').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}") {
                var tax_rate ={{$tax->rate}};
            }
            @endforeach;
            var total = document.getElementById('total').value;
            var tax_amount = parseFloat(total) * (tax_rate / 100);
            var tax_include = parseFloat(total) + tax_amount;
            var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            var grand = (tax_include - discount) + parseFloat(deli_fee);
            $('#grand_total').val(grand);
            $('#tax_amount').val(tax_amount);
        });
        $(document).on('click', '#add_item', function (event) {
            var product_id = $("#product option:selected").val();
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
                    "product_id": product_id,
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
                    'type': 'invoice'

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
                        swal('Out Of Stock', 'This product is out of stock.', 'error');
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
                        'delivery_fee': deli_fee

                    },
                    type: 'POST',
                    url: "{{route('invoices.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        if (!$.isEmptyObject(data.orderempty)) {
                            // alert(data.orderempty);
                            swal('Empty Item', 'You invoice does not have any item.', 'error');
                        } else {
                            window.location = data.url;
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

                    },
                    type: 'POST',
                    url: "{{route('invoices.store')}}",
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
        // window.onbeforeunload = closeWindow;
        var product = document.querySelector('#product');
        var variant = document.querySelector('#variant');
        var options2 = variant.querySelectorAll('option');

        // alert(product)
        function giveSelection(selValue) {
            variant.innerHTML = '';
            for (var i = 0; i < options2.length; i++) {
                if (options2[i].dataset.option === selValue) {
                    variant.appendChild(options2[i]);
                }
            }
        }

        giveSelection(product.value);
    </script>
@endsection