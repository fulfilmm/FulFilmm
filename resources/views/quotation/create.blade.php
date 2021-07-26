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
        <form action="{{url("quotation/create")}}" method="POST">
            {{csrf_field()}}
            <button class="btn btn-primary" type="button" id="save">Save</button>
            <button class="btn btn-outline-primary" type="button" id="discard">Discard</button>
            <hr>
            <button type="button" class="btn btn-outline-primary"  id="send_email">SendByEmail</button>
            <button class="btn btn-outline-primary" id="confirm">Confirm</button>
            <hr>
            <div class="card">
                <div class="col-12 mt-3">
{{--                    <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation_id}}">--}}
                    <h3>NEW </h3>
                    <div class="row">
                        <div class="col-md-1 offset-md-1">  <label for="">Customer</label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="quo_customer" id="customer_name"  class="form-control">
                                    @foreach($allcustomers as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endforeach
                                        @error('quo_customer')
                                        {{-- <span class="invalid-feedback" role="alert"> --}}
                                        <strong class="text-danger">{{ $message }}</strong>
                                        {{-- </span> --}}
                                        @enderror
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a data-toggle="modal" href="#add_user"  class="btn btn-outline-dark"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-1 ">  <label for="">Expiration</label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control {{ $errors->has('exp_date') ? ' is-invalid' : '' }}" name="exp_date" id="exp" required>
                                @if ($errors->has('exp_date'))
                                    <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('exp_date') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="offset-md-7 col-md-1">
                            <label for="">Payment Terms</label>
                        </div>
                        <div class="col-md-4" >
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
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Order Line</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Optional Products</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Other Info</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <table class="table">
                                <thead>
                                <th scope="col">Product</th>
                                <th>Description</th>
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
                                        <td>
                                            <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                            <select name="" id="edit_product_{{$order->id}}" class="form-control">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    @if($product->id==$order->product->id)
                                                        <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                                    @else
                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="description" id="edit_order_description_{{$order->id}}" class="form-control" value="{{$order->description}}">
                                        </td>
                                        <td>
                                            <input type="number" name="hello" id="edit_quantity_{{$order->id}}" class="form-control " value="{{$order->quantity}}">
                                        </td>
                                        <td><input type="number" id="edit_price_{{$order->id}}" class="form-control " value="{{$order->price}}"></td>
                                        <td><input type="text" class="form-control" name="tax" id="edit_product_tax_{{$order->id}}" value="{{$order->tax}}"></td>
                                        <td>
                                            <input type="number" name="total" id="edit_total_{{$order->id}}" class="form-control col-md-7" value="{{$order->total_amount}}">
                                        </td>
                                        <td><input type="text" class="form-control" id="edit" value="{{$order->product->currency_unit}}"></td>
                                        <td>
                                            <div class="row">
                                                <a class="btn btn-success btn-sm mr-2" href="" type="button" id="update_order_{{$order->id}}"><i class="fa fa-save"></i></a><br>
                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$order->id}}" href="#" ><i class="fa fa-trash-o "></i></a>
                                            </div>
                                        </td>
                                        <div class="modal fade" id="delete{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('orders.destroy',$order->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                <span>
                                                    Are you sure cancel this order?
                                              </span>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-primary">Cancel</button>
                                                            <button type="submit" class="btn btn-danger  my-2">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            //order update
                                            $(document).on('change', 'input', function() {
                                                var quantity=$('#edit_quantity_{{$order->id}}').val();
                                                var price=$('#edit_price_{{$order->id}}').val();
                                                var total=quantity * price;
                                                var tax=$('#edit_product_tax_{{$order->id}}').val();
                                                var tax_amount=tax / 100 * total;
                                                var include_tax=total + tax_amount;
                                                $('#edit_total_{{$order->id}}').val(include_tax);

                                            });
                                            $(document).on('change','#edit_product_{{$order->id}}',function (){
                                                var product_id=$("#edit_product_{{$order->id}} option:selected").val();
                                                @foreach($products as $product )
                                                var p_id={{$product->id}}
                                                if(p_id==product_id)
                                                {
                                                    var tax = {{$product->taxes->rate}};
                                                    var price = {{$product->sale_price}};
                                                    $('#edit_product_tax_{{$order->id}}').val(tax);
                                                    $('#edit_price_{{$order->id}}').val(price);
                                                }
                                                @endforeach
                                                var quantity=$('#edit_quantity_{{$order->id}}').val();
                                                var price=$('#edit_price_{{$order->id}}').val();
                                                var total=quantity * price;
                                                var tax=$('#edit_product_tax_{{$order->id}}').val();
                                                var tax_amount=tax / 100 * total;
                                                var include_tax=total + tax_amount;
                                                $('#edit_total_{{$order->id}}').val(include_tax);
                                            });
                                            $(document).ready(function() {
                                                $(document).on('click', "#update_order_{{$order->id}}", function () {
                                                    // alert("hello");

                                                    var desc=$('#edit_order_description_{{$order->id}}').val();
                                                    var quantity=$('#edit_quantity_{{$order->id}}').val();
                                                    var price=$('#edit_price_{{$order->id}}').val();
                                                    var tax=$('#edit_product_tax_{{$order->id}}').val();
                                                    var total=$('#edit_total_{{$order->id}}').val();
                                                    var order_id=$('#order_id_{{$order->id}}').val();
                                                    var product=$('#edit_product_{{$order->id}} option:selected').val();
                                                    // alert(product);
                                                    $.ajax({
                                                        data : {
                                                            product_id:product,
                                                            description:desc,
                                                            quantity:quantity,
                                                            price:price,
                                                            tax:tax,
                                                            total:total,
                                                            order_id:order_id,
                                                        },
                                                        type:'PUT',
                                                        url:"{{route('orders.update',$order->id)}}",
                                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                        success:function(data){
                                                            console.log(data);
                                                            // $("#home").load(location.href + " #home>* ");

                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    </tr>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <input type="hidden" id="form_id" value="{{$request_id[0]}}">
                                        <select name="" id="product" class="form-control">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="description" id="order_description" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="hello" id="quantity" class="form-control " value="0">
                                    </td>
                                    <td>
                                        <input type="number" id="price" class="form-control " value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="tax" id="product_tax">
                                    </td>
                                    <td>
                                        <input type="number" name="total" id="total" class="form-control col-md-7" value="0">
                                    </td>
                                    <td><input type="text" class="form-control" id="unit"></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-danger ml-2 text-sm" id="add"><i class="fa fa-plus"></i></button>
                                    </td>
                                </tr>
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

                                    <td><input class="form-control" type="text" id="grand_total" value="{{$grand_total}}"></td>
                                </tr>
                            </table>
                            <label for="">Terms and Condition</label>
                            <div class="term">
                            <div class="input-group">
                                <input type="text" class="form-control " name="term_condition" id="term_and_condition" placeholder="..terms and conditions .."><br>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal custom-modal rounded" id="add_user">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="container " >
                        <div class="modal-body">
{{--                            @include('')--}}
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                            <a href="#" id="add_contact" data-dismiss="modal" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->
    <!-- /Page Wrapper -->
    <script>
            //price calculation function
            $(document).on('change', 'input', function() {
                var quantity=$('#quantity').val();
                var price=$('#price').val();
                var total=quantity * price;
                var tax=$('#product_tax').val();
                var tax_amount=tax / 100 * total;
                var include_tax=total + tax_amount;
                    $('#total').val(include_tax);

            });
            //customer select function
            $(document).ready(function() {
                $('#customer_name').select2({
                        "language": {
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }
                    }

                );

            });
            //product select function
            $(document).ready(function() {
                $('#product').select2({
                        "language": {
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }
                    }

                );

            });
            //order line function
            $(document).ready(function() {
                $(document).on('click', '#add', function () {
                    var quotation_id=$('#form_id').val();
                    var product=$('#product option:selected').val();
                    var desc=$('#order_description').val();
                    var quantity=$('#quantity').val();
                    var price=$('#price').val();
                    var tax=$('#product_tax').val();
                    var total=$('#total').val();
                    $.ajax({
                        data : {
                            product_id:product,
                            description:desc,
                            quantity:quantity,
                            price:price,
                            tax:tax,
                            total:total,
                            quotation_id:quotation_id,
                        },
                        type:'POST',
                        url:"{{route('orders.store')}}",
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
            //new customer add ajax function
            {{--$(document).ready(function() {--}}
            {{--    $(document).on('click', '#add_contact', function () {--}}

            {{--        var customer_id=$("#customer_id").val();--}}
            {{--        var customer_name =$("#customer_name ").val();--}}
            {{--        var customer_phone=$("#customer_phone").val();--}}
            {{--        var customer_email=$("#customer_email").val();--}}
            {{--        var customer_company=$("#customer_company").val();--}}
            {{--        var customer_dept=$("#customer_dept").val();--}}
            {{--        var customer_position=$("#customer_position option:selected").val();--}}
            {{--        var customer_report_to=$("#customer_report_to").val();--}}
            {{--        var customer_address=$("#customer_address").val();--}}
            {{--        var customer_admin_company=$("#customer_admin_company").val();--}}
            {{--        var type="ajax";--}}
            {{--        $.ajax({--}}
            {{--            data : {--}}
            {{--                customer_id:customer_id,--}}
            {{--                name:customer_name,--}}
            {{--                phone:customer_phone,--}}
            {{--                email:customer_email,--}}
            {{--                company_id:customer_company,--}}
            {{--                department:customer_dept,--}}
            {{--                position:customer_position,--}}
            {{--                report_to:customer_report_to,--}}
            {{--                address:customer_address,--}}
            {{--                admin_company:customer_admin_company,--}}
            {{--                type:type--}}
            {{--            },--}}
            {{--            type:'POST',--}}
            {{--            url:"{{url("client/customer/create/")}}",--}}
            {{--            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
            {{--            success:function(data){--}}
            {{--                console.log(data);--}}
            {{--                $("#contact_div").load(location.href + " #contact_div>* ");--}}

            {{--            }--}}
            {{--        });--}}
            {{--    });--}}
            {{--});--}}
            //product price pass date ajax function
            $(document).on('change','#product',function (){
                var product_id=$("#product option:selected").val();
                // alert(product_id);
                @foreach($products as $product )
                    var p_id={{$product->id}}
                if(p_id==product_id)
                {
                    var tax = {{$product->taxes->rate}};
                    $('#product_tax').val(tax);
                    $('#price').val({{$product->sale_price}});
                    $('#unit').val("{{$product->currency_unit}}");
                }
                @endforeach
            });
         //store ajax function
            $(document).ready(function() {
                $(document).on('click', '#save', function () {
                    var quotation_id=$('#quotation_id').val();
                    var customer_id=$('#customer_name option:selected').val();
                    var exp=$('#exp').val();
                    var pay_term=$('#pay_term option:selected').val();
                    var grand_total=$('#grand_total').val();
                    var term_condition=$('#term_and_condition').val();

                    $.ajax({
                        data : {
                            quotation_id:quotation_id,
                            customer:customer_id,
                            expiration:exp,
                            payment_term:pay_term,
                            grand_total:grand_total,
                            term_and_condition:term_condition,
                        },
                        type:'POST',
                        url:"{{route('quotations.store')}}",
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
                                   alert(error);
                                });
                            }
                        }
                    });
                });
            });
             //Discard ajax code
            $(document).ready(function() {
                $(document).on('click', '#discard', function () {
                    var quotation_id=$('#quotation_id').val();
                    $.ajax({
                        data : {
                            quotation_id:quotation_id,
                        },
                        type:'POST',
                        url:"{{route('quotations.discard')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            window.location.href = "/quotations";
                        }
                    });
                });
            });
            $(document).ready(function() {
                $(document).on('click', '#send_email', function () {
                    var quotation_id=$('#quotation_id').val();
                    var customer_id=$('#customer_name option:selected').val();
                    var exp=$('#exp').val();
                    var pay_term=$('#pay_term option:selected').val();
                    var grand_total=$('#grand_total').val();
                    var term_condition=$('#term_and_condition').val();
                    var company=$('#customer_admin_company').val();
                    $.ajax({
                        data : {
                            quotation_id:quotation_id,
                            customer:customer_id,
                            expiration:exp,
                            payment_term:pay_term,
                            grand_total:grand_total,
                            term_and_condition:term_condition,
                            admin_company:company,
                        },
                        type:'POST',
                        url:"{{route('quotations.store')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);
                            // window.location.href = "/quotations/sendemail/{";
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
    </script>
@endsection
