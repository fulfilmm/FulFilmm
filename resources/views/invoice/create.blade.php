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
                                        <select name="" id="payment" class="select">
                                            <option value="Cash">Cash</option>
                                            <option value="Bank">Bank</option>
                                            <option value="KBZ Pay">KBZPay</option>
                                            <option value="Cash">Wave Money</option>
                                        </select>
                                    </div>
                                </div>
                                        <input type="hidden" id="invoice_id" class="form-control" value="{{$request_id[0]}}" readonly>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="client_id">Client <span class="text-danger">*</span></label>
                                        <select class="select" id="client_id">
                                          @foreach($allcustomers as $client)
                                            <option value="{{$client->id}}" {{isset($order_data)?($client->id==$order_data->customer_id?'selected':''):''}}>{{$client->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="client_email">Email</label>
                                        <input class="form-control" type="email" id="client_email">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="inv_date">Invoice date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="inv_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="due_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="client_address">Client Address</label>
                                        <input type="text" class="form-control" id="client_address">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="bill_address">Billing Address</label>
                                        <input type="text" class="form-control" rows="3" id="bill_address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Other Information</label>
                                        <textarea class="form-control" id="more_info"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="order_table">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-white">
                                                <thead>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Taxes(%)</th>
                                                <th>Discount Type</th>
                                                <th>Discount</th>
                                                <th>Total(Include Tax)</th>
                                                <th>Currency Unit</th>
                                                <th>Action</th>
                                                </thead>
                                                <tbody id="tbody">
                                                @foreach($orderline as $order)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                                           {{$order->product->name}}
                                                        </td>
                                                        <td>
                                                            {{$order->description}}
                                                        </td>
                                                        <td>
                                                            {{$order->quantity}}
                                                        </td>
                                                        <td>{{$order->unit_price}}</td>
                                                        <td>{{$order->tax_id}}</td>
                                                        <td>
                                                            {{$order->discount_type}}

                                                        </td>
                                                        <td>
                                                            {{$order->discount}}
                                                        </td>
                                                        <td>
                                                            {{$order->total}}
                                                        </td>
                                                        <td>{{$order->currency_unit}}
                                                        <td>
                                                            <div class="row">
                                                                <a data-toggle="modal" href="#edit{{$order->id}}" id="call_full_form" class="btn btn-primary btn-sm mr-1"><i class="fa fa-edit"></i></a><br>
                                                                <a class="btn btn-danger btn-sm" data-toggle="modal" href="#remove{{$order->id}}" ><i class="fa fa-trash-o "></i></a>
                                                            </div>
                                                    </tr>
                                                    {{--@include('invoice.itemsedit')--}}
                                                    @include('invoice.item_remove')
                                                @endforeach
                                                <tr>
                                                    <td>
                                                        <select name="" id="product" class="form-control" style="min-width: 150px;">
                                                            <option value="">Select Product</option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="description" id="order_description" class="form-control" style="min-width: 200px;">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantity" id="quantity" class="form-control " value="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" id="price" class="form-control " value="0" style="min-width: 120px;">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="tax" id="product_tax" >
                                                    </td>
                                                    <td>
                                                        <select name="discount_type" id="discount_type" class="form-control">
                                                            <option value="%">%</option>
                                                            <option value="amount">Amount</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" id="discount" value=0 style="min-width: 100px;">
                                                    </td>

                                                    <td>
                                                        <input type="number" name="total" id="total" class="form-control col-md-7" value="0" style="min-width: 150px;">
                                                    </td>
                                                    <td><input type="text" class="form-control" id="unit"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-danger ml-2 text-sm" id="add_item"><i class="fa fa-plus"></i></button>
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
                                                    <td></td>
                                                    <td></td>
                                                    <th>Grand Total</th>
                                                    <td><input class="form-control" type="text" id="inv_grand_total" value="{{$grand_total}}" style="min-width: 150px"></td>
                                                    <td></td>
                                                    <td></td>
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
            <script>
                $(document).on('change', 'input', function() {
                    var quantity=$('#quantity').val();
                    var price=$('#price').val();
                    var total=quantity * price;
                    var tax=$('#product_tax').val();
                    var tax_amount=tax / 100 * total;
                    var include_tax=total + tax_amount;
                    var discount=$('#discount').val();
                    var discount_type=$('#discount_type option:selected').val();
                    var total_amount=0;
                    if(discount_type=='amount') {
                        total_amount = include_tax - discount;
                    }else {
                        var discount_amount = (discount / 100) * include_tax;
                        total_amount=include_tax-discount_amount;
                    }
                    $('#total').val(total_amount);

                });
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
                $(document).ready(function() {
                    $(document).on('click', '#add_item', function () {
                        var invoice_id=$('#invoice_id').val();
                        var product=$('#product option:selected').val();
                        var desc=$('#order_description').val();
                        var quantity=$('#quantity').val();
                        var price=$('#price').val();
                        var discount=$('#discount').val();
                        var discount_type=$('#discount_type option:selected').val();
                        var tax=$('#product_tax').val();
                        var unit=$('#unit').val();
                        var total=$('#total').val();
                        $.ajax({
                            data : {
                                "product_id":product,
                                'description':desc,
                                'quantity':quantity,
                                "tax_id":tax,
                                'discount':discount,
                                "discount_type":discount_type,
                                'unit_price':price,
                                "currency_unit":unit,
                                "total":total,
                                "invoice_id":invoice_id

                            },
                            type:'POST',
                            url:"{{route('invoice_items.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                $("#order_table").load(location.href + " #order_table>* ");
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
                //save and send
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
                                'payment_method':payment

                            },
                            type:'POST',
                            url:"{{route('invoices.store')}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success:function(data){
                                console.log(data);
                                window.location.href = "/invoices";
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
                        $.ajax({
                            data : {
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
                                console.log(data);
                                window.location.href = "/invoices";
                            }
                        });
                    });
                });
            </script>

@endsection
