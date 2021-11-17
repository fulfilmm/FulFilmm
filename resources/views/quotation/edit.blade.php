@extends('layout.mainlayout')
@section("title","Quotation Edit")
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
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('quotations.index')}}">Quotations</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->

        <hr>
        <div class="card">
            <div class="col-12 mt-3">
                {{--                    <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation_id}}">--}}
                <h3>NEW </h3>
                <div class="row mb-3 ">
                    <div class="col-md-4" id="contact_div">
                        <div class="form-group" >
                            <label for="">Customer</label>
                            <div class="input-group">
                                <select name="quo_customer" id="customer_name"  class="form-control">
                                    @foreach($allcustomers as $client)
                                        <option value="{{$client->id}} {{$client->id==$quotation->client_name?'selected':''}}">{{$client->name}}</option>
                                    @endforeach

                                    <strong class="text-danger client_err"></strong>
                                </select>
                                <button data-toggle="modal" data-target="#add_contact"  class="btn btn-outline-dark"><i class="fa fa-plus"></i></button>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expiration</label>
                            <input type="date" class="form-control {{ $errors->has('exp_date') ? ' is-invalid' : '' }}" name="exp_date" id="exp" value="{{\Carbon\Carbon::parse($quotation->exp_date)->format('Y-m-d')}}" required>
                            <span class="help-block">
                                        <strong class="text-danger text-center expiration_err"></strong>
                                        </span>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="">Payment Terms</label>
                            <select name="pay_term" id="pay_term" class="form-control">
                                <option value="Immediate Payment">Immediate Payment</option>
                                <option value="15 Days">15 Days</option>
                                <option value="21 Days">21 Days</option>
                                <option value="30 Days">30 Days</option>
                                <option value="45 Days">45 Days</option>
                                <option value="2 Months">2 Months</option>
                                <option value="End Of Following Month">End Of Following Month</option>
                                <option value="30% Now,Balance 60 Days">30% Now,Balance 60 Days</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" id="contact_div">
                        <div class="form-group" >
                            <label for="">Deal ID</label>
                            <div class="input-group">
                                <select name="deal_id" id="deal_id"  class="form-control">
                                    <option value="">None</option>
                                    @foreach($deals as $deal)
                                        <option value="{{$deal->id}}" {{$quotation->deal_id==$deal->id?'selected':''}}>{{$deal->deal_id}}</option>
                                    @endforeach

                                    <strong class="text-danger client_err"></strong>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="description">Terms And Conditions</label>
                            <textarea  class="form-control " name="term_condition" id="term_and_condition" placeholder="Write terms and conditions ..">{{$quotation->terms_conditions}}</textarea>
                        </div>
                        <span class="help-block">
                                        <strong class="text-danger text-center term_and_condition_err"></strong>
                                        </span>
                    </div>
                </div>
                <div class="border-top" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
                    <div class="form-group">
                        <label for="">Search Product</label>
                        <input type="hidden" id="form_id" value="{{$quotation->id}}">
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
                        <th>Total(Include Tax)</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="tbody">
                        @foreach($orderline as $order)
                            <tr>
                                <td style="min-width: 200px;max-width: 400px"><input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                    <div class="row">
                                        <input type="hidden" name="product_id" id="product_{{$order->id}}" value="{{$order->product_id}}">
                                        <div class="col-md-4">
                                            <img src="{{url(asset('product_picture/'.$order->product->image))}}"  alt="" width="40px" height="40px">
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
                                    <input type="text" name="hello" id="edit_quantity_{{$order->id}}" class="form-control update_order_{{$order->id}}" value="{{$order->quantity}}" >
                                </td>
                                <td><input type="text" id="edit_price_{{$order->id}}" class="form-control update_order_{{$order->id}}" value="{{$order->price}}" ></td>
                                <td>
                                    <input type="text" name="total" id="edit_total_{{$order->id}}" class="form-control update_order_{{$order->id}}" value="{{$order->total_amount}}" >
                                </td>
                                <td>
                                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$order->id}}" href="#" ><i class="fa fa-trash-o "></i></a>
                                    @include('quotation.order_delete')
                                </td>

                                <script>
                                    //order update
                                    $('.update_order_{{$order->id}}').keyup( function () {
                                        var quantity = $('#edit_quantity_{{$order->id}}').val();
                                        var price = $('#edit_price_{{$order->id}}').val();
                                        var total = quantity * price;
                                        $('#edit_total_{{$order->id}}').val(total);

                                    });
                                    $(document).on('change', '#edit_product_{{$order->id}}', function () {
                                        var product_id = $("#edit_product_{{$order->id}} option:selected").val();
                                                @foreach($variants as $product )
                                        var p_id ={{$product->id}}
                                        if (p_id == product_id) {
                                            var edit_price = {{$product->price}};
                                            $('#edit_price_{{$order->id}}').val(edit_price);
                                        }
                                                @endforeach
                                        var quantity = $('#edit_quantity_{{$order->id}}').val();
                                        var price = $('#edit_price_{{$order->id}}').val();
                                        var total = quantity * price;
                                        $('#edit_total_{{$order->id}}').val(total);
                                    });
                                    $(document).ready(function () {
                                        $(".update_order_{{$order->id}}").keyup(function () {
                                            // alert("hello");
                                            var quantity = $('#edit_quantity_{{$order->id}}').val();
                                            var price = $('#edit_price_{{$order->id}}').val();
                                            var total = $('#edit_total_{{$order->id}}').val();
                                            var order_id = $('#order_id_{{$order->id}}').val();
                                            var product = $('#product_{{$order->id}}').val();
                                            $.ajax({
                                                data: {
                                                    product_id: product,
                                                    quantity: quantity,
                                                    price: price,
                                                    total: total,
                                                    order_id: order_id
                                                },
                                                type: 'PUT',
                                                url: "{{route('quotation_items.update',$order->id)}}",
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
                                                    $('#total').val(grand_total);

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

                            <th>Total</th>

                            <td id="" colspan="2"><input class="form-control" type="text" id="total" value="{{$grand_total}}">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>Discount</th>
                            <td id="discount_div" colspan="2"><input class="form-control" type="text" id="discount" value="{{$quotation->discount}}" ></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th>Tax</th>

                            <td id="tax" colspan="2">
                                <div class="input-group">
                                    <input type="number" id="tax_amount" class="form-control">
                                    <select name="" id="tax" class="form-control">
                                        @foreach($taxes as $tax)
                                            <option value="{{$tax->id}}" {{$tax->id==$quotation->tax_id?'selected':''}}>{{$tax->name}} ({{$tax->rate}} %)</option>
                                        @endforeach
                                    </select>
                                </div>
                        </tr>
                        {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td></td>--}}
                        {{--<td></td>--}}
                        {{--<th>Discount</th>--}}

                        {{--<td id="grand_total_div"><input class="form-control" type="text" id="grand_total" value="{{$grand_total}}"></td>--}}
                        {{--</tr>--}}

                        <tr>
                            <td></td>
                            <td></td>

                            <th>Grand Total</th>

                            <td id="" colspan="2"><input class="form-control" type="text" id="grand_total" value="{{$grand_total}}">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-outline-primary " id="update">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content End -->
    </div>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
        $(document).ready(function () {
            var tax=$('#tax option:selected').val();
            @foreach($taxes as $tax)
            if(tax=="{{$tax->id}}")
                var tax_rate={{$tax->rate}};
                    @endforeach

            var total = $('#total').val();
            var tax_amount=total*(tax_rate/100);
            var tax_include=(total-0)+tax_amount;
            var discount = $('#discount').val();
            var grand =tax_include-discount;
            $('#grand_total').val(grand);
            $('#tax_amount').val(tax_amount);
        });
        $('input').keyup( function () {
            var tax=$('#tax option:selected').val();
            @foreach($taxes as $tax)
            if(tax=="{{$tax->id}}")
                var tax_rate={{$tax->rate}};
                    @endforeach

            var total = $('#total').val();
            var tax_amount=total*(tax_rate/100);
            var tax_include=(total-0)+tax_amount;
            var discount = $('#discount').val();
            var grand =tax_include-discount;
            $('#grand_total').val(grand);
            $('#tax_amount').val(tax_amount);

        });
        $(document).on('change','#tax',function () {
            var tax=$('#tax option:selected').val();
            @foreach($taxes as $tax)
            if(tax=="{{$tax->id}}")
                var tax_rate={{$tax->rate}};
                    @endforeach

            var total = $('#total').val();
            var tax_amount=total*(tax_rate/100);
            var tax_include=(total-0)+tax_amount;
            var discount = $('#discount').val();
            var grand =tax_include-discount;
            $('#grand_total').val(grand);
            $('#tax_amount').val(tax_amount);
        });
        $(document).ready(function() {
            $(document).on('change', '#product', function () {
                var quotation_id=$('#form_id').val();
                var product=$('#product option:selected').val();
                $.ajax({
                    data : {
                        product_id:product,
                        quotation_id:quotation_id
                    },
                    type:'POST',
                    url:"{{route('quotation_items.store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#home").load(location.href + " #home>* ");
                        var alltotal=[];
                        $('.total').each(function(){
                            alltotal.push(this.value);
                        });
                        var grand_total=0;
                        for (var i=0;i<alltotal.length;i++){
                            grand_total=parseFloat(grand_total)+parseFloat(alltotal[i]);
                        }
                        $('#grand_total').val(grand_total);

                    }
                });
            });
        });

        //store ajax function

        $(document).ready(function() {
            $(document).on('click', '#update', function () {
                var quotation_id=$('#form_id').val();
                var customer_id=$('#customer_name option:selected').val();
                var exp=$('#exp').val();
                var pay_term=$('#pay_term option:selected').val();
                var grand_total=$('#grand_total').val();
                var deal_id=$('#deal_id option:selected').val();
                var term_condition=$("#term_and_condition").val();
                var tax_id=$('#tax option:selected').val();
                var discount=$('#discount').val();
                var total=$('#total').val();
                var tax_amount=$('#tax_amount').val();
// alert(term_condition);
                $.ajax({
                    data : {
                        quotation_id:quotation_id,
                        customer:customer_id,
                        expiration:exp,
                        payment_term:pay_term,
                        grand_total:grand_total,
                        term_and_condition:term_condition,
                        deal_id:deal_id,
                        tax_id:tax_id,
                        discount:discount,
                        total:total,
                        tax_amount:tax_amount
                    },
                    type:'PUT',
                    url:"{{route('quotations.update',$quotation->id)}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
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

        // ClassicEditor
        //     .create(document.querySelector('#term_and_condition'));
    </script>
@endsection
