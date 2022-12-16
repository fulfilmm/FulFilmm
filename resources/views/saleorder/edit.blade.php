@extends(\Illuminate\Support\Facades\Auth::guard('employee')->check()?'layout.mainlayout':'layouts.app')
@section('title','Order Edit')
@section('content')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>--}}

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />--}}
    <!-- Page Content -->
    @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
        <div class="content container-fluid">
        @endif

        <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Order</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Order</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow">
                       <div class="col-12 my-3">
                           <h5 class="font-weight-bold pb-3">Customer Details</h5>
                           @csrf
                           <div class="col-md-12 mb-3">
                               <label for="Text1" class="form-label font-weight-bold text-muted text-uppercase">Customer
                                   <span class="text-danger">*</span></label>
                               <select name="customer_id" class="form-control" id="customer_id" required>
                                   <option value="">Choose Customer</option>
                                   @foreach($data['customer'] as $customer)
                                       @if(\Illuminate\Support\Facades\Auth::guard('customer')->check()&& \Illuminate\Support\Facades\Auth::guard('customer')->user()->id==$customer->id)
                                           <option value="{{$customer->id}}">{{$customer->name}}</option>
                                       @else
                                           <option value="{{$customer->id}}" {{$edit_order->customer_id==$customer->id ?'selected':''}}>{{$customer->name}}</option>
                                       @endif
                                   @endforeach
                               </select>
                               <span class="text-danger customer_id_err"></span>
                           </div>
                           <div class="col-md-12 mb-3">
                               <label for="phone" class="form-label font-weight-bold text-muted text-uppercase">Phone
                                   <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" id="phone" name="phone"
                                      placeholder="Enter Phone" value="{{$edit_order->phone??''}}" required>
                               <span class="text-danger phone_err"></span>
                           </div>
                           <div class="col-md-12 mb-3">
                               <label for="email" class="form-label font-weight-bold text-muted text-uppercase">Email
                                   <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" id="email" name="email"
                                      placeholder="Enter Email" value="{{$edit_order->email??''}}" required>
                               <span class="text-danger email_err"></span>
                           </div>
                           <div class="col-md-12 mb-3">
                               <label for="address" class="form-label font-weight-bold text-muted text-uppercase">Address
                                   <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" name="address" id="address"
                                      placeholder="Enter Address" value="{{$edit_order->address??''}}" required>
                               <span class="text-danger address_err"></span>
                           </div>
                           <div class="col-md-12 mb-3">
                               <label for="email" class="form-label font-weight-bold text-muted text-uppercase">Billing
                                   Address <span class="text-danger">*</span></label>
                               <input type="text" class="form-control" id="billing_address" name="billing_address"
                                      placeholder="Enter Billing Address" value="{{$edit_order->billing_address??''}}"
                                      required>
                               <span class="text-danger email_err"></span>
                           </div>
                           <div class="form-group col-12">
                               <label for="" class="form-label font-weight-bold text-muted text-uppercase">Shipping
                                   Type</label><br>
                               <input type="radio" class="shipping_type" name="shipping_type"
                                      value="pickup" {{$edit_order->shipping_type=='pickup'?'checked':''}}> <label
                                       for="shipping_address" class="ml-2 mr-3">Pick Up</label>
                               <input type="radio" class="shipping_type" name="shipping_type"
                                      value="delivery" {{$edit_order->shipping_type=='delivery'?'checked':''}}><label
                                       for="shipping_address" class="ml-2 mr-3">Delivery</label>
                           </div>
                           <div class="form-group col-12" id="delivery_address">
                               <label for='' class='form-label font-weight-bold text-muted text-uppercase'>Shipping
                                   Address</label>
                               <input type='text' class='form-control' name='shipping_address' id='shipping_address'
                                      placeholder='Shipping Address' value="{{$edit_order->shipping_address??''}}">
                           </div>
                       </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="col-12 my-3">
                            <h5 class="font-weight-bold pb-3">Order Details</h5>
                            <div class="row g-3">
                                <div class="col-md-12 mb-3">
                                    <label for="order_date"
                                           class="form-label font-weight-bold text-muted text-uppercase">Date <span
                                                class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="order_date" placeholder="DD MM YYYY"
                                           value="{{\Carbon\Carbon::parse($edit_order->order_date)->format('Y/m/d h:i:s')}}"
                                           required>
                                    <span class="text-danger order_date_err"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Text7" class="form-label font-weight-bold text-muted text-uppercase">Payment
                                        Method <span class="text-danger">*</span></label><br>
                                    <div class="form-group" aria-label="Basic outlined example">
                                        <input type="radio" name="payment_type" id="payment_type" value="Cash"
                                               class="mr-2" {{$edit_order->payment_method=='Cash'?'checked':''}}><label
                                                for="">Cash</label>
                                        <input type="radio" name="payment_type" id="payment_type" value="Mobile Banking"
                                               class="mr-2 ml-2" {{$edit_order->payment_method=='Mobile Banking'?'checked':''}}><label>Mobile
                                            Banking</label>
                                        <input type="radio" name="payment_type" id="payment_type" value="Bank Transfer"
                                               class="mr-2 ml-2" {{$edit_order->payment_method=='Bank Transfer'?'checked':''}}><label
                                                for="">Bank Transfer</label>
                                    </div>
                                    <span class="text-danger payment_type_err"></span>
                                </div>
                                <div class="col-md-12 ">
                                    <label for="Text7" class="form-label font-weight-bold text-muted text-uppercase">Payment
                                        Term <span class="text-danger">*</span></label><br>
                                    <div class="form-group" aria-label="Basic outlined example">
                                        <select class="form-control" name="payment_term" id="payment_term" required>
                                            <option value="COD - Cash on delivery" {{$edit_order->payment_term=='COD - Cash on delivery'?'selected':''}}>
                                                COD - Cash on delivery
                                            </option>
                                            <option value="Payment seven days after invoice date" {{$edit_order->payment_term=='Payment seven days after invoice date'?'selected':''}}>
                                                Payment seven days after invoice date
                                            </option>
                                            <option value="EOM - End of month" {{$edit_order->payment_term=='EOM - End of month'?'selected':''}}>
                                                EOM - End of month
                                            </option>

                                        </select>
                                        <span class="text-danger payment_term_err"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{--@dd($data['quotation'])--}}
                                    <div class="form-group">
                                        <label for="quotation_id" class="font-weight-bold text-muted text-uppercase">Quotation
                                            ID</label>
                                        <select name="quotation_id" id="quotation_id" class="form-control">
                                            <option value="">None</option>
                                            @foreach($data['quotation'] as $quotation)
                                                <option value="{{$quotation->id}}" {{$edit_order->quotation_id==$quotation->id?'selected':''}}>
                                                    #{{$quotation->quotation_id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="comment" class="form-label font-weight-bold text-muted text-uppercase">Remark</label>
                                    <textarea type="text" class="form-control" id="comment" name="comment" rows="5"
                                              placeholder="Enter your comment">{{$edit_order->comment??''}}</textarea>
                                </div>
                                <input type="hidden" id="order_id" value="{{$edit_order->id}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="col-12">
                    <div class="card-body">
                                <h5 class="font-weight-bold mb-3">Order Items</h5>
                                <input type="hidden" id="creation_id" value="{{$data['id'][0]}}">
                                @if(!isset($order_data))
                                    <div class="col-md-5 col-5 my-3">
                                        <div class="input-group">
                                            <select name="" id="variant" class="form-control">
                                                <option value="">Select Product</option>
                                                @foreach($data['variants'] as $variant)
                                                    <option value="{{$variant->id}}"
                                                            data-option="{{$variant->product_id}}">{{$variant->product_name}}
                                                        ({{$variant->variant??''}})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary rounded-right" id="add_item">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-hover table-white table-bordered" id="order_table">
                                        <thead>
                                        <th colspan="3">Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                        </thead>
                                        <tbody id="tbody">
                                        @foreach($data['items'] as $order)
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
                                                           value="{{$order->quantity}}" min="0" {{isset($order_data)?'readonly':''}}>
                                                </td>
                                                <td>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <input type="number" id="price_{{$order->id}}"
                                                                   class="form-control update_item_{{$order->id}}"
                                                                   value="{{$order->unit_price}}" min="0"
                                                                   oninput="validity.valid||(value='');" style="min-width: 120px;">

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
                                            <script>
                                                $(document).ready(function () {
                                                    var unit_id = $('#unit{{$order->id}} option:selected').val();
                                                    @foreach($prices as $item)
                                                    if ('{{$order->variant_id}}' == '{{$item->product_id}}') {
                                                        if (unit_id == "{{$item->unit_id}}") {
                                                            var qty = $('#quantity_{{$order->id}}').val();
                                                            if (parseInt("{{$item->min}}") <= qty) {
                                                                var price = "{{$item->price}}";
                                                            }

                                                        }
                                                    }
                                                            @endforeach

                                                    var quantity = $('#quantity_{{$order->id}}').val();
                                                    var sub_total = quantity * price;
                                                    // alert(sub_total);
                                                    $('#total_{{$order->id}}').val(sub_total);
                                                    var sum = 0;
                                                    $('.total').each(function () {
                                                        sum += parseFloat($(this).val());
                                                    });
                                                    $('#total').val(sum);
                                                    $('.select_update').change(function () {
                                                        @if($order->foc)
                                                        $('#price_{{$order->id}}').val(0);
                                                        $('#total_{{$order->id}}').val(0);
                                                                @else
                                                        var quantity = $('#quantity_{{$order->id}}').val();
                                                        var price = $('#price_{{$order->id}}').val();
                                                                {{--var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();--}}
                                                        var sub_total = quantity * price ?? 0;
                                                        $('#total_{{$order->id}}').val(sub_total);
                                                        var sum = 0;
                                                        $('.total').each(function () {
                                                            sum += parseFloat($(this).val());
                                                        });
                                                        $('#total').val(sum);
                                                        @endif
                                                        var product = $('#product_{{$order->id}}').val();
                                                        // var amount = (dis_pro / 100) * sub_total;
                                                        // var total = sub_total - amount;
                                                        var sell_unit = $('#unit{{$order->id}} option:selected').val();
                                                        $.ajax({
                                                            data: {
                                                                "product_id": product,
                                                                'quantity': quantity,
                                                                'unit_price': price,
                                                                "total": total,
                                                                'sell_unit': sell_unit,
                                                                'discount_pro': 0,
                                                            },

                                                            type: 'PUT',
                                                            url: "{{route('invoice_items.update',$order->id)}}",
                                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                            success: function (data) {
                                                                console.log(data);

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
                                                                {{--var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();--}}
                                                        var sub_total = quantity * price ?? 0;
                                                        $('#total_{{$order->id}}').val(sub_total);
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
                                                                {{--var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();--}}
                                                        var sub_total =$('#total_{{$order->id}}').val();
                                                        // var amount = (dis_pro / 100) * sub_total;
                                                        // var total = sub_total - amount;
                                                        var sell_unit = $('#unit{{$order->id}} option:selected').val();
                                                        $.ajax({
                                                            data: {
                                                                "product_id": product,
                                                                'quantity': quantity,
                                                                'unit_price': price,
                                                                "total": sub_total,
                                                                'sell_unit': sell_unit,
                                                                'discount_pro': 0,
                                                                'type': 'order'
                                                            },
                                                            type: 'PUT',
                                                            url: "{{route('invoice_items.update',$order->id)}}",
                                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                            success: function (data) {
                                                                console.log(data);

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

                                            <td id="discount_div" colspan="2"><input class="form-control" type="text"
                                                                                     id="discount" value="0.0"></td>
                                        </tr>
                                        <tr id="delivery">
                                            <th colspan="7" class="text-right"><span class="mt-5">Delivery Fee</span></th>
                                            <td colspan="2">
                                                <input type="number" class="form-control" name="delivery_fee" id="deli_fee" value="0.0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="7" class="text-right"><span class="mt-5">Tax</span></th>
                                            <td colspan="2">
                                                <select name="" id="tax" class="form-control select_update" style="width: 100%">
                                                    @foreach($data['taxes'] as $tax)
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
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                        <buttton type="button" class="btn btn-primary" id="order_submit">Submit</buttton>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        @include('saleorder.jquery_for_order_create')
        <script>
            jQuery(document).ready(function () {
                'use strict';

                jQuery('#order_date').datetimepicker();

            });
            $(document).ready(function () {

                var type = $("input[name='shipping_type']:checked").val();
                if (type == 'pickup') {
                    $('#delivery_address').hide();

                }
                $(document).on('change', '.shipping_type', function () {
                    var type = $("input[name='shipping_type']:checked").val();
                    if (type == 'pickup') {
                        $('#delivery_address').hide();

                    } else if (type == 'delivery') {
                        $('#delivery_address').show();
                    }
                });
            });
            $(document).on('change', '#customer_id', function () {
                var customer_id = $("#customer_id option:selected").val();
                // alert(product_id);
                        @foreach($data['customer'] as $customer )
                var p_id =
                {{$customer->id}}
                if (p_id == customer_id) {
                    $('#phone').val({{$customer->phone}});
                    $('#email').val("{{$customer->email}}");
                    $('#address').val("{{$customer->address}}");
                    $('#billing_address').val("{{$customer->address}}");
                }
                @endforeach
            });
            {{--$('input').keyup(function () {--}}
                {{--var tax = $('#tax option:selected').val();--}}
                {{--@foreach($data['taxes'] as $tax)--}}
                {{--if (tax == "{{$tax->id}}")--}}
                    {{--var tax_rate ={{$tax->rate}};--}}
                        {{--@endforeach--}}
                {{--var sum = 0;--}}
                {{--$('.total').each(function() {--}}
                    {{--sum += parseFloat($(this).val());--}}
                {{--});--}}
                {{--$('#total').val(sum);--}}
                {{--alert(sum)--}}
                {{--var tax_amount = sum * (tax_rate / 100);--}}
                {{--var tax_include = sum - tax_amount;--}}
                {{--var discount = $('#discount').val();--}}
                {{--var grand = tax_include - discount;--}}
                {{--$('#grand_total').val(grand);--}}
                {{--$('#tax_amount').val(tax_amount);--}}
            {{--});--}}
            {{--$(document).on('change', '#tax', function () {--}}
                {{--var tax = $('#tax option:selected').val();--}}
                {{--@foreach($data['taxes'] as $tax)--}}
                {{--if (tax == "{{$tax->id}}")--}}
                    {{--var tax_rate ={{$tax->rate}};--}}
                        {{--@endforeach--}}

                {{--var sum = 0;--}}
                {{--$('.total').each(function() {--}}
                    {{--sum += parseFloat($(this).val());--}}
                {{--});--}}
                {{--$('#total').val(sum);--}}
                {{--var tax_amount = sum * (tax_rate / 100);--}}
                {{--var tax_include = sum - tax_amount;--}}
                {{--var discount = $('#discount').val();--}}
                {{--var grand = tax_include - discount;--}}
                {{--$('#grand_total').val(grand);--}}
                {{--$('#tax_amount').val(tax_amount);--}}
            {{--});--}}
            {{--$(document).ready(function () {--}}
                {{--$(document).on('click', '#add_item', function () {--}}
                    {{--var order_id = $('#order_id').val();--}}
                    {{--var creation_id = $('#creation_id').val();--}}
                    {{--var product = $('#product option:selected').val();--}}
                    {{--var customer_id = $('#customer_id').val();--}}
                    {{--var email = $('#email').val();--}}
                    {{--var order_date = $('#order_date').val();--}}
                    {{--var address = $('#address').val();--}}
                    {{--var comment = $('#comment').val();--}}
                    {{--var billing_address = $('#billing_address').val();--}}
                    {{--var grand_total = $('#grand_total').val();--}}
                    {{--var payment = $("input[name='payment_type']:checked").val();--}}
                    {{--var payment_term = $('#payment_term option:selected').val();--}}
                    {{--var shipping_type = $("input[name='shipping_type']:checked").val();--}}
                    {{--var shipping_address = $('#shipping_address').val();--}}
                    {{--var quotation_id = $('#quotation_id option:selected').val();--}}
                    {{--var variant_id = $('#variant option:selected').val();--}}
                    {{--var phone = $('#phone').val();--}}
                    {{--// alert(creation_id);--}}
                    {{--$.ajax({--}}
                        {{--data: {--}}
                            {{--'variant_id': variant_id,--}}
                            {{--"product_id": product,--}}
                            {{--"invoice_id": creation_id,--}}
                            {{--'phone': phone,--}}
                            {{--'order_id': order_id,--}}
                            {{--'customer_id': customer_id,--}}
                            {{--'email': email,--}}
                            {{--'order_date': order_date,--}}
                            {{--'address': address,--}}
                            {{--'comment': comment,--}}
                            {{--'grand_total': grand_total,--}}
                            {{--'payment_method': payment,--}}
                            {{--'payment_term': payment_term,--}}
                            {{--'billing_address': billing_address,--}}
                            {{--'shipping_address': shipping_address,--}}
                            {{--'shipping_type': shipping_type,--}}
                            {{--'quotation_id': quotation_id,--}}
                            {{--'type': 'order'--}}

                        {{--},--}}
                        {{--type: 'POST',--}}
                        {{--url: "{{route('invoice_items.store')}}",--}}
                        {{--headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},--}}
                        {{--success: function (data) {--}}
                            {{--console.log(data);--}}
                            {{--$("#order_table").load(location.href + " #order_table>* ");--}}
                            {{--$("#grand_total_div").load(location.href + " #grand_total_div>* ");--}}
                            {{--var alltotal = [];--}}
                            {{--$('.total').each(function () {--}}
                                {{--alltotal.push(this.value);--}}
                            {{--});--}}
                            {{--var grand_total = 0;--}}
                            {{--for (var i = 0; i < alltotal.length; i++) {--}}
                                {{--grand_total = parseFloat(grand_total) + parseFloat(alltotal[i]);--}}
                            {{--}--}}
                            {{--$('#grand_total').val(grand_total);--}}
                            {{--location.reload();--}}

                        {{--}--}}
                    {{--});--}}
                {{--});--}}
            {{--});--}}
            //save only
            $(document).ready(function () {
                $(document).on('click', '#order_submit', function () {
                    var customer_id = $('#customer_id').val();
                    var email = $('#email').val();
                    var order_date = $('#order_date').val();
                    var address = $('#address').val();
                    var comment = $('#comment').val();
                    var billing_address = $('#billing_address').val();
                    var grand_total = $('#grand_total').val();
                    var payment = $("input[name='payment_type']:checked").val();
                    var payment_term = $('#payment_term option:selected').val();
                    var shipping_type = $("input[name='shipping_type']:checked").val();
                    var shipping_address = $('#shipping_address').val();
                    var quotation_id = $('#quotation_id option:selected').val();
                    var phone = $('#phone').val();
                    var discount = $('#discount').val();
                    var total = $('#total').val();
                    var tax_id = $('#tax option:selected').val();
                    var tax_amount = $('#tax_amount').val()
                    $.ajax({
                        data: {
                            'discount': discount,
                            'total': total,
                            'tax_id': tax_id,
                            'tax_amount': tax_amount,
                            'phone': phone,
                            'customer_id': customer_id,
                            'email': email,
                            'order_date': order_date,
                            'address': address,
                            'comment': comment,
                            'grand_total': grand_total,
                            'payment_method': payment,
                            'payment_term': payment_term,
                            'billing_address': billing_address,
                            'shipping_address': shipping_address,
                            'shipping_type': shipping_type,
                            'quotation_id': quotation_id

                        },
                        type: 'PUT',
                        url: "{{route('saleorders.update',$edit_order->id)}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            console.log(data);
                            if (!$.isEmptyObject(data.orderempty)) {
                                swal('Empty Item', 'You order does not have any item.', 'error');

                            } else if ($.isEmptyObject(data.error)) {
                                console.log(data);
                                swal('Order Update', 'Order Update Success', 'success');

                                window.location.href = "/saleorders";
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
        </script>
@endsection
