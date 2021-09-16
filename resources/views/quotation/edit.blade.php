@extends('layout.mainlayout')
@section("title","Quotation Create")
@section('content')

    <!-- Page Content -->
    <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Edit Quotation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="{{url("/quotations")}}">Quotation</a></li>
                            <li class="breadcrumb-item active">{{$quotation->quotation_id}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Content Starts -->

        <button class="btn btn-primary" type="button" id="update_quotaion">Update</button>
        <hr>
        <div class="card">
            <div class="col-12 mt-3">
                <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation->quotation_id}}">
                <h4>{{$quotation->quotation_id}} </h4>
                <div class="row">
                    <div class="col-md-1 offset-md-1">  <label for="">Customer</label></div>
                    <div class="col-md-4">
                        <div class="form-group" id="contact_div">
                            <select name="quo_customer" id="edit_customer_name"  class="form-control">
                                @foreach($allcustomers as $client)
                                    @if($client->id==$quotation->customer_name)
                                        <option value="{{$client->id}}" selected>{{$client->name}}</option>
                                    @else
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                    @endif
                                @endforeach
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
                            <input type="date" class="form-control" name="exp_date" id="exp" value="{{\Carbon\Carbon::parse($quotation->exp_date)->format('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="offset-md-7 col-md-1">
                        <label for="">Payment Terms</label>
                    </div>
                    <div class="col-md-4" >
                        <select name="pay_term" id="pay_term" class="form-control">
                            @foreach($payterm as $key=>$value)
                                @if($quotation->payment_term==$value)
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
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
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x: auto">
                        <table class="table">
                            <thead>
                            <th scope="col">Product</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Taxes(%)</th>
                            <th>Total(IncludeTax)</th>
                            <th> Action </th>
                            </thead>
                            <tbody>
                            @php
                                $orderline=\App\Models\Orderline::with('product')->where("quotation_id",$quotation->quotation_id)->get();
                                $grand_total=0;
                                 for ($i=0;$i<count($orderline);$i++){
                                     $grand_total=$grand_total+$orderline[$i]->total_amount;
                                 }
                            @endphp
                            @foreach($orderline as $order)
                                <tr>
                                    <td>
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
                                    <td>
                                        <div class="row">
                                            <a class="btn btn-success btn-sm mr-2" href="" type="button" id="update_order_{{$order->id}}"><i class="fa fa-save"></i></a><br>
                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$order->id}}" href="#" ><i class="fa fa-trash-o "></i></a>
                                            @include('quotation.order_delete')
                                        </div>
                                    </td>
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
                                                    },
                                                    type:'POST',
                                                    url:"{{route("orders.update",$order->id)}}",
                                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                    success:function(data){
                                                        // console.log(data);
                                                        {{--$("#myTabContent").load(location.href + " #myTabContent>* ");--}}
                                                        {{--$("#order_edit_{{$order->id}}").modal('hide');--}}

                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                </tr>

                            @endforeach
                            <tr>
                                <td>
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
                                <td>
                                    <button type="button" class="btn btn-outline-success" id="add"><i class="fa fa-plus"></i></button>
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
                        <div class="form-group">
                            <label for="">Terms and Condition</label>
                            <input type="text" class="form-control" name="term_condition" id="term_and_condition" value="{{$quotation->terms_conditions}}">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
            </div>
        </div>
        <!-- /Content End -->
        @include('Deal.add_customer')
        </div>
    <!-- /Page Content -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#customer_add', function () {

                // var customer_id=$("#customer_id").val();
                var customer_name =$("#customer_name").val();
                var customer_phone=$("#customer_phone").val();
                var customer_email=$("#customer_email").val();
                var customer_company=$("#customer_company_id option:selected").val();
                var customer_address=$("#customer_address").text();
                // alert(customer_name);
                var type="ajax";
                $.ajax({
                    data : {
                        name:customer_name,
                        phone:customer_phone,
                        email:customer_email,
                        company_id:customer_company,
                        address:customer_address,
                    },
                    type:'POST',
                    url:"{{route('add_new_customer')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#contact_div").load(location.href + " #contact_div>* ");

                    }
                });
            });
        });
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
            $('#edit_customer_name').select2({
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
                var quotation_id=$('#quotation_id').val();
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

        //product price pass date ajax function
        $(document).on('change','#product',function (){
            var product_id=$("#product option:selected").val();
            @foreach($products as $product )
            var p_id={{$product->id}}
            if(p_id==product_id)
            var tax={{$product->taxes->rate}};
            $('#product_tax').val(tax);
            $('#price').val({{$product->sale_price}});
            @endforeach
        });
        //store ajax function
        $(document).ready(function() {
            $(document).on('click', '#update_quotaion', function () {

                var quotation_id=$('#quotation_id').val();
                var customer_id=$('#edit_customer_name option:selected').val();
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
                    type:'PUT',
                    url:"{{route("quotations.update",$quotation->id)}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        window.location.href = "/quotations";
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
                    url:"{{url("quotation.blade.php")}}",
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
                    url:"{{url("quotation.blade.php")}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        window.location.href = "/quotations/sendemail/{{$quotation->quotation_id}}";
                    }
                });
            });
        });
    </script>
@endsection
