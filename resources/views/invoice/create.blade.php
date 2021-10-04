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
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" name="title" id="title">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="payment">Payment Type</label>
                                        <select name="" id="payment" class="form-control">
                                            <option value="Cash" {{isset($order_data)?($order_data->payment_method=='Cash'?'selected':''):''}}>Cash</option>
                                            <option value="Bank" {{isset($order_data)?($order_data->payment_method=='Bank'?'selected':''):''}}>Bank</option>
                                            <option value="KBZ Pay" {{isset($order_data)?($order_data->payment_method=='KBZ Pay'?'selected':''):''}}>KBZPay</option>
                                            <option value="Wave Money" {{isset($order_data)?($order_data->payment_method=='Wave Money'?'selected':''):''}}>Wave Money</option>
                                        </select>
                                    </div>
                                </div>
                                        <input type="hidden" id="invoice_id" class="form-control" value="{{$request_id[0]}}" readonly>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="client_id">Client <span class="text-danger">*</span></label>
                                        <select class="form-control" id="client_id">
                                          @foreach($allcustomers as $client)
                                            <option value="{{$client->id}}" {{isset($order_data)?($client->id==$order_data->customer_id?'selected':''):''}}>{{$client->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="client_email">Email</label>
                                        <input class="form-control" type="email" id="client_email" value="{{$order_data->email??''}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="inv_date">Invoice date <span class="text-danger">*</span></label>
                                            <input class="form-control " type="date" id="inv_date">

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                        <input  class="form-control" type="date" id="due_date">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="client_address">Client Address</label>
                                        <input type="text" class="form-control" id="client_address" value="{{$order_data->address??''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="bill_address">Billing Address</label>
                                        <input type="text" class="form-control"  id="bill_address" value="{{isset($order_data)?$order_data->billing_address:''}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="bill_address">Order ID</label>
                                        <input type="text" class="form-control"   value="{{isset($order_data)?$order_data->order_id:''}}" readonly>
                                        <input type="hidden" name="order_id" id="order_id" value="{{$order_data->id??''}}">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Other Information</label>
                                        <textarea class="form-control" id="more_info"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="order_table">
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <label for="">Search Products</label>
                                            <select name="" id="product" class="form-control" style="min-width: 150px;">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <table class="table table-hover table-white">
                                                <thead>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Taxes(%)</th>
                                                <th>Type</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                                <th>Currency</th>
                                                <th>Action</th>
                                                </thead>
                                                <tbody id="tbody">
                                                @foreach($orderline as $order)
                                                    <tr>
                                                        <td style="min-width: 200px;"><input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                                            <div class="row">
                                                                <input type="hidden" name="product_id" id="product_{{$order->id}}" value="{{$order->product_id}}">
                                                                <div class="col-md-4">
                                                                    <img src="{{url(asset('product_picture/'.$order->product->image))}}"  alt="" width="40px" height="40px">
                                                                </div>
                                                                <div class="data-content">
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
                                                            <input type="text" name="quantity" id="quantity_{{$order->id}}" class="form-control update_item_{{$order->id}}" value=" {{$order->quantity}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="price_{{$order->id}}" class="form-control update_item_{{$order->id}}" value="{{$order->unit_price}}" style="min-width: 120px;">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control update_item_{{$order->id}}" name="tax" id="product_tax_{{$order->id}}" value="{{$order->tax_id}}" >
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control update_item_{{$order->id}}" name="discount_type" id="discount_type{{$order->id}}" value="{{$order->discount_type}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control update_item_{{$order->id}}" name="discount" id="discount_{{$order->id}}" value="{{$order->discount}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="total" id="total_{{$order->id}}" class="form-control col-md-7 update_item_{{$order->id}}" value="{{number_format($order->total)}}" style="min-width: 100px;" >
                                                        </td>
                                                        <td><input type="text" class="form-control update_item_{{$order->id}}" id="unit_{{$order->id}}" value="{{$order->currency_unit}}"></td>

                                                        <td>
                                                            <a class="btn btn-danger btn-sm" data-toggle="modal" href="#remove{{$order->id}}" ><i class="fa fa-trash-o "></i></a>
                                                            @include('invoice.item_remove')
                                                            <script>
                                                               $(document).ready(function () {
                                                                   $('#order_table').on('change', '.update_item_{{$order->id}}', function() {
                                                                       var quantity=$('#quantity_{{$order->id}}').val();
                                                                       var price=$('#price_{{$order->id}}').val();
                                                                       var total=quantity * price;
                                                                       var tax=$('#product_tax_{{$order->id}}').val();
                                                                       var tax_amount=tax / 100 * total;
                                                                       var include_tax=total + tax_amount;
                                                                       $('#total_{{$order->id}}').val(include_tax);

                                                                   });
                                                               });
                                                                $(document).ready(function() {
                                                                    $(document).on('change', '.update_item_{{$order->id}}', function () {
                                                                        var product=$('#product_{{$order->id}}').val();
                                                                        var desc=$('#order_description_{{$order->id}}').val();
                                                                        var quantity=$('#quantity_{{$order->id}}').val();
                                                                        var price=$('#price_{{$order->id}}').val();
                                                                        var tax=$('#product_tax_{{$order->id}}').val();
                                                                        var unit=$('#unit_{{$order->id}}').val();
                                                                        var total=$('#total_{{$order->id}}').val();
                                                                        $.ajax({
                                                                            data : {
                                                                                "product_id":product,
                                                                                'description':desc,
                                                                                'quantity':quantity,
                                                                                "tax_id":tax,
                                                                                'unit_price':price,
                                                                                "currency_unit":unit,
                                                                                "total":total,
                                                                            },
                                                                            type:'PUT',
                                                                            url:"{{route('invoice_items.update',$order->id)}}",
                                                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                                            success:function(data){
                                                                                console.log(data);
                                                                                $("#order_table").load(location.href + " #order_table>* ");
                                                                                $("#grand_total_div").load(location.href + " #grand_total_div>* ");
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
                                                            </script>
                                                        </td>

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
                                                    <td colspan="5"></td>
                                                    <th colspan="2" class="text-right"><span class="mt-5">Grand Total</span></th>
                                                    <td colspan="2"><input class="form-control" type="text"  value="{{number_format($grand_total)}}" style="min-width: 100px">
                                                        <input type="hidden" id="inv_grand_total" value="{{$grand_total}}">
                                                    </td>

                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
{{--                            <input type="hidden" id="generate_id" value="{{$generate_id}}">--}}
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn m-r-10" type="button" id="saveAndsend">Save & Send</button>
                                <button class="btn btn-primary submit-btn" type="button" id="save">Save</button>
                            </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
            {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>--}}

            {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />--}}
            <script>
                $(document).ready(function () {

                        $('select').selectize({
                        sortField: 'text'
                    });
                });
                $(document).on('change','#product',function (){
                    var product_id=$("#product option:selected").val();
                    var invoice_id=$('#invoice_id').val();
                    $.ajax({
                        data : {
                            "product_id":product_id,
                            "invoice_id":invoice_id

                        },
                        type:'POST',
                        url:"{{route('invoice_items.store')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success:function(data){
                            console.log(data);

                            var alltotal=[];
                            $('.total').each(function(){
                                alltotal.push(this.value);
                            });
                            var grand_total=0;
                            for (var i=0;i<alltotal.length;i++){
                                grand_total=parseFloat(grand_total)+parseFloat(alltotal[i]);
                            }
                            $('#grand_total').val(grand_total);
                            $("#order_table").load(location.href + " #order_table>* ");

                        }
                    });

                });
                $(document).ready(function() {
                    $(document).on('click', '#saveAndsend', function () {
                            var client_id=$('#client_id').val();
                            var client_email=$('#client_email').val();
                            var inv_date=$('#inv_date').val();
                            var due_date=$('#due_date').val();
                            var client_address=$('#client_address').val();
                            var bill_address=$('#bill_address').val();
                            var more_info=$('#more_info').val();
                            var inv_grand_total=$('#inv_grand_total').val();
                            var payment=$('#payment option:selected').val();
                            var status=$('#status option:selected').val();
                            var title=$('#title').val();
                            var order_id=$('#order_id').val();
                            var action_type='save_and_send';
                        $.ajax({
                            data : {
                                'title':title,
                                "client_id":client_id,
                                'client_email':client_email,
                                'inv_date':inv_date,
                                "due_date":due_date,
                                'client_address':client_address,
                                "more_info":more_info,
                                'inv_grand_total':inv_grand_total,
                                'bill_address':bill_address,
                                "save_type":action_type,
                                'status':status,
                                'order_id':order_id,
                                'payment_method':payment

                            },
                            type:'POST',
                            url:"{{route('invoices.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                window.location=data.url;
                            }
                        });
                        });
                    });

                //save only
                $(document).ready(function() {
                    $(document).on('click', '#save', function () {
                            var client_id = $('#client_id').val();
                            var client_email = $('#client_email').val();
                            var inv_date = $('#inv_date').val();
                            var due_date = $('#due_date').val();
                            var client_address = $('#client_address').val();
                            var more_info = $('#more_info').val();
                            var bill_address=$('#bill_address').val();
                            var inv_grand_total = $('#inv_grand_total').val();
                            var payment=$('#payment option:selected').val();
                            var status=$('#status option:selected').val();
                            var title=$('#title').val();
                            var order_id=$('#order_id').val();
                        $.ajax({
                            data : {
                                'order_id':order_id,
                                'title':title,
                                'client_id':client_id,
                                'client_email':client_email,
                                'inv_date':inv_date,
                                'due_date':due_date,
                                'client_address':client_address,
                                'more_info':more_info,
                                'bill_address':bill_address,
                                'inv_grand_total':inv_grand_total,
                                'status':status,
                                'payment_method':payment

                            },
                            type:'POST',
                            url:"{{route('invoices.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data.errors);
                                // window.location.href = data.url;
                            },
                            error:function (data) {
                                $.each(data.errors,function (key,value){
                                    console.log(key);
                                    $('.'+key+'_err').text(value);
                                });

                            }
                        });
                    });
                });
            </script>

@endsection
