@extends('layout.mainlayout')
@section("title","Quotation Create")
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Quotation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <button class="btn btn-outline-success btn-sm" type="button" id="save">Save</button>
        <button type="button" class="btn btn-outline-warning btn-sm " id="send_email">SendByEmail</button>
        <button class="btn btn-outline-primary btn-sm  mr-1" id="confirm">Confirm</button>
        <button class="btn btn-danger btn-sm " type="button" id="discard">Discard</button>
        <hr>
        <div class="card">
            <div class="col-12 mt-3">
                {{--                    <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation_id}}">--}}
                <h3>NEW </h3>
                <div class="row mb-3 ">
                    <div class="col-md-4" id="contact_div">
                        <div class="form-group">
                            <label for="">Customer</label>
                            <div class="input-group">
                                <select name="quo_customer" id="customer_name" class="form-control">
                                    @foreach($allcustomers as $client)
                                        <option value="{{$client->id}}" {{$data!=null?($data[0]['customer']==$client->id?'selected':''):''}}>{{$client->name}}</option>
                                    @endforeach

                                    <strong class="text-danger client_err"></strong>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expiration</label>
                            <input type="date" class="form-control {{ $errors->has('exp_date') ? ' is-invalid' : '' }}"
                                   name="exp_date" id="exp" value="{{$data[0]['expiration']??''}}" required>
                            <span class="help-block">
                                        <strong class="text-danger text-center expiration_err"></strong>
                                        </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Payment Terms</label>
                            <select name="pay_term" id="pay_term" class="form-control">
                                <option value="Immediate Payment">Immediate Payment</option>
                                <option value="15 Days" {{$data!=null?($data[0]['payment_term']=="15 Days"?'selected':''):''}}>15 Days</option>
                                <option value="21 Days" {{$data!=null?($data[0]['payment_term']=="21 Days"?'selected':''):''}}>21 Days</option>
                                <option value="30 Days" {{$data!=null?($data[0]['payment_term']=="30 Days"?'selected':''):''}}>30 Days</option>
                                <option value="45 Days" {{$data!=null?($data[0]['payment_term']=="45 Days"?'selected':''):''}}>45 Days</option>
                                <option value="2 Months" {{$data!=null?($data[0]['payment_term']=="2 Months"?'selected':''):''}}>2 Months</option>
                                <option value="End Of Following Month" {{$data!=null?($data[0]['payment_term']=="End Of Following Month"?'selected':''):''}}>End Of Following Month</option>
                                <option value="30% Now,Balance 60 Days" {{$data!=null?($data[0]['payment_term']=="30% Now,Balance 60 Days"?'selected':''):''}}>30% Now,Balance 60 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" id="contact_div">
                        <div class="form-group">
                            <label for="">Deal ID</label>
                            <div class="input-group">
                                <select name="deal_id" id="deal_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach($deals as $deal)
                                        <option value="{{$deal->id}}" {{$data!=null?($data[0]['deal_id']==$deal->id?'selected':''):''}}>{{$deal->deal_id}}</option>
                                    @endforeach

                                    <strong class="text-danger client_err"></strong>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="description">Terms And Conditions</label>
                            <textarea class="form-control " name="term_condition" id="term_and_condition"
                                      placeholder="Write terms and conditions ..">{{$data[0]['term_and_condition']??''}}</textarea>
                        </div>
                        <span class="help-block">
                                        <strong class="text-danger text-center term_and_condition_err"></strong>
                                        </span>
                    </div>
                </div>
                <div class="border-top" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
                    <div class="form-group">
                        <label for="">Add Item</label>
                        <input type="hidden" id="form_id" value="{{$request_id[0]}}">
                        <select name="" id="product" class="form-control">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table">
                        <thead>
                        <th scope="col" style="min-width: 150px;">Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Taxes(%)</th>
                        <th>Total(Include Tax)</th>
                        <th>Currency Unit</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="tbody">
                        @foreach($orderline as $order)
                            <tr>
                                <td style="min-width: 200px;max-width: 400px"><input type="hidden"
                                                                                     id="order_id_{{$order->id}}"
                                                                                     value="{{$order->id}}">
                                    <div class="row">
                                        <input type="hidden" name="product_id" id="product_{{$order->id}}"
                                               value="{{$order->product_id}}">
                                        <div class="col-md-4">
                                            <img src="{{url(asset('product_picture/'.$order->product->image))}}" alt=""
                                                 width="40px" height="40px">
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <span class="font-weight-bold">{{$order->product->name}}</span>
                                            </div>
                                            <p class="m-0 mt-1">
                                                {{$order->product->description}}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="hello" id="edit_quantity_{{$order->id}}"
                                           class="form-control update_order_{{$order->id}}"
                                           value="{{$order->quantity}}">
                                </td>
                                <td><input type="text" id="edit_price_{{$order->id}}"
                                           class="form-control update_order_{{$order->id}}" value="{{$order->price}}">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control update_order_{{$order->id}}" name="tax" id="edit_product_tax_{{$order->id}}"
                                                                    value="{{$order->tax}}"><span
                                                class="input-group-text">%</span></div>
                                </td>
                                <td>
                                    <input type="text" name="total" id="edit_total_{{$order->id}}"
                                           class="form-control update_order_{{$order->id}}"
                                           value="{{$order->total_amount}}">
                                </td>
                                <td><input type="text" class="form-control update_order_{{$order->id}}" id="edit"
                                           value="{{$order->product->currency_unit}}" readonly></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" id="remove{{$order->id}}"><i
                                                class="fa fa-trash-o "></i></button>
                                    @include('quotation.order_delete')
                                </td>

                                <script>
                                    //order update
                                    $('input').keyup( function () {
                                        var quantity = $('#edit_quantity_{{$order->id}}').val();
                                        var price = $('#edit_price_{{$order->id}}').val();
                                        var total = quantity * price;
                                        var tax = $('#edit_product_tax_{{$order->id}}').val();
                                        var tax_amount = tax / 100 * total;
                                        var include_tax = total + tax_amount;
                                        $('#edit_total_{{$order->id}}').val(include_tax);

                                    });
                                    $(document).on('change', '#edit_product_{{$order->id}}', function () {
                                        var product_id = $("#edit_product_{{$order->id}} option:selected").val();
                                                @foreach($products as $product )
                                        var p_id =
                                        {{$product->id}}
                                        if (p_id == product_id) {
                                            var tax = {{$product->taxes->rate}};
                                            var price = {{$product->sale_price}};
                                            $('#edit_product_tax_{{$order->id}}').val(tax);
                                            $('#edit_price_{{$order->id}}').val(price);
                                        }
                                                @endforeach
                                        var quantity = $('#edit_quantity_{{$order->id}}').val();
                                        var price = $('#edit_price_{{$order->id}}').val();
                                        var total = quantity * price;
                                        var tax = $('#edit_product_tax_{{$order->id}}').val();
                                        var tax_amount = tax / 100 * total;
                                        var include_tax = total + tax_amount;
                                        $('#edit_total_{{$order->id}}').val(include_tax);
                                    });
                                    $(document).ready(function () {
                                        $("input").keyup(function () {
                                            // alert("hello");

                                            var desc = $('#edit_order_description_{{$order->id}}').val();
                                            var quantity = $('#edit_quantity_{{$order->id}}').val();
                                            var price = $('#edit_price_{{$order->id}}').val();
                                            var tax = $('#edit_product_tax_{{$order->id}}').val();
                                            var total = $('#edit_total_{{$order->id}}').val();
                                            var order_id = $('#order_id_{{$order->id}}').val();
                                            var product = $('#product_{{$order->id}}').val();
                                            $.ajax({
                                                data: {
                                                    product_id: product,
                                                    description: desc,
                                                    quantity: quantity,
                                                    price: price,
                                                    tax: tax,
                                                    total: total,
                                                    order_id: order_id,
                                                },
                                                type: 'PUT',
                                                url: "{{route('quotation_items.update',$order->id)}}",
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                success: function (data) {
                                                    console.log(data);
                                                    $("#grand_total_div").load(location.href + " #grand_total_div>* ");
                                                    var alltotal = [];
                                                    $('.total').each(function () {
                                                        alltotal.push(this.value);
                                                    });
                                                    var grand_total = 0;
                                                    for (var i = 0; i < alltotal.length; i++) {
                                                        grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);
                                                    }
                                                    $('#grand_total').val(grand_total);

                                                }
                                            });
                                        });
                                    });
                                </script>
                            </tr>
                        @endforeach
                        </tbody>
                        <tr>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th>Grand Total</th>

                            <td id="grand_total_div"><input class="form-control" type="text" id="grand_total" value="{{$grand_total}}"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content End -->
    </div>
    @include('customer.quickcustomer')
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        // window.onbeforeunload = function(event) {
        //     alert('message');
        //     return 'jkj';
        // };

        // window.onbeforeunload = closeWindow;

        $(document).ready(function () {
            $(document).on('change', '#product', function (event) {
                event.preventDefault();
                var quotation_id = $('#form_id').val();
                var product = $('#product option:selected').val();
                var customer_id = $('#customer_name option:selected').val();
                var exp = $('#exp').val();
                var pay_term = $('#pay_term option:selected').val();
                var grand_total = $('#grand_total').val();
                var deal_id = $('#deal_id option:selected').val();
                var term_condition = $("#term_and_condition").val();
                $.ajax({
                    data: {
                        product_id: product,
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id
                    },
                    type: 'POST',
                    url: "{{route('quotation_items.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = window.location.href;
                        var alltotal = [];
                        $('.total').each(function () {
                            alltotal.push(this.value);
                        });
                        var grand_total = 0;
                        for (var i = 0; i < alltotal.length; i++) {
                            grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);
                        }
                        $('#grand_total').val(grand_total);
                        location.reload();

                    }
                });
            });
        });

        //store ajax function
        $(document).ready(function () {
            $(document).on('click', '#confirm', function () {
                var quotation_id = $('#form_id').val();
                var customer_id = $('#customer_name option:selected').val();
                var exp = $('#exp').val();
                var pay_term = $('#pay_term option:selected').val();
                var grand_total = $('#grand_total').val();
                var deal_id = $('#deal_id option:selected').val();
                var term_condition = $("#term_and_condition").val();
// alert(term_condition);
                $.ajax({
                    data: {
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,
                        confirm: 1
                    },
                    type: 'POST',
                    url: "{{route('quotations.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/quotations";
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);
                            $('#success_message').fadeIn().html(err.responseJSON.message);
                            // you can loop through the errors object and show it to the user
                            console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function (i, error) {
                                $('.' + i + '_err').text(error);
                            });
                        }
                    }
                });
            });
        });
        $(document).ready(function () {
            $(document).on('click', '#save', function () {
                var quotation_id = $('#form_id').val();
                var customer_id = $('#customer_name option:selected').val();
                var exp = $('#exp').val();
                var pay_term = $('#pay_term option:selected').val();
                var grand_total = $('#grand_total').val();
                var deal_id = $('#deal_id option:selected').val();
                var term_condition = $("#term_and_condition").val();
// alert(term_condition);
                $.ajax({
                    data: {
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id
                    },
                    type: 'POST',
                    url: "{{route('quotations.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/quotations";
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);
                            $('#success_message').fadeIn().html(err.responseJSON.message);
                            // you can loop through the errors object and show it to the user
                            console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function (i, error) {
                                $('.' + i + '_err').text(error);
                            });
                        }
                    }
                });
            });
        });
        //Discard ajax code
        $(document).ready(function () {
            $(document).on('click', '#discard', function () {
                var quotation_id = $('#form_id').val();
                $.ajax({
                    data: {
                        quotation_id: quotation_id,
                    },
                    type: 'POST',
                    url: "{{route('quotations.discard')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = "/quotations";
                    }
                });
            });
        });
        $(document).ready(function () {
            $(document).on('click', '#send_email', function () {
                var quotation_id = $('#form_id').val();
                var customer_id = $('#customer_name option:selected').val();
                var exp = $('#exp').val();
                var pay_term = $('#pay_term option:selected').val();
                var grand_total = $('#grand_total').val();
                var term_condition = $("#term_and_condition").val();
                var deal_id = $('#deal_id option:selected').val();
                $.ajax({
                    data: {
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,
                        send_email: 'saveandsend',
                        confirm: 1
                    },
                    type: 'POST',
                    url: "{{route('quotations.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.href = data.url;
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);
                            $('#success_message').fadeIn().html(err.responseJSON.message);
                            // you can loop through the errors object and show it to the user
                            console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function (i, error) {
                                alert(error);
                            });
                        }
                    }
                });
            });
        });
        $(document).ready(function () {
            $('#customer_name').select2();
            $('#deal_id').select2();
            $('#pay_term').select2();
        })
        // ClassicEditor
        //     .create(document.querySelector('#term_and_condition'));
    </script>
@endsection
