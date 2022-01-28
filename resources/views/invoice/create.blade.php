@extends('layout.mainlayout')
@section('title',$type.'Invoice Create')
@section('content')
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
        <div class="row card">
            <div class="col-sm-12 my-5">
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
                    <div class="col-sm-3 col-md-4">
                        <div class="form-group">
                            <label for="bill_address">Warehouse<span class="text-danger"> * </span></label>
                            <select name="" id="warehouse" class="form-control select2" onchange="giveSelection(this.value)">
                                @foreach($warehouse as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4 mt-4">
                        <input type="radio" class="mr-2 ml-3" name="delionoff" id="on" value="on" checked><label for="">Include Delivery Fee</label><br>
                        <input type="radio" class="mr-2 ml-3" name="delionoff" id="off" value="off"><label for="">Not Include Delivery Fee</label>
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
                                  <div class="row">
                                      <div class="col-md-8 col-12 my-2 mb-3">
                                          <div class="row">
                                              <div class="col-md-4 col-4">
                                                 <button type="button" title="Search By Product Name" id="p_name" class="btn btn-white"><i class="la la-cube"></i></button>
                                                 <button type="button" title="Search By Product Code" id="p_code" class="btn btn-white"><i class="la la-barcode"></i></button>
                                                 <button type="button" title="Give FOC" id="foc_button" class="btn btn-white">FOC</button>
                                             </div>
                                              <div class="col-6 col-md-6" id="product_name">
                                                 <div class="input-group">
                                                     <select name="" id="variant" class="form-control " style="width: 80%">
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
                            <table class="table table-hover table-white" id="order_table">
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
                                            <input type="number" name="quantity" id="quantity_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{$order->quantity}}" min="0" @foreach($aval_product as $item) @if($item->variant_id==$order->variant_id) max="{{$item->available}}" @endif @endforeach  {{isset($order_data)?'readonly':''}}>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <input type="number" id="price_{{$order->id}}"
                                                       class="form-control update_item_{{$order->id}}"
                                                       value="{{$order->foc?0:$order->unit_price}}" min="0"
                                                       oninput="validity.valid||(value='');" style="min-width: 120px;">

                                            </div>
                                        </td>
                                        <td>
                                            <select name="" class="select_update" id="unit{{$order->id}}" style="min-width: 100px">

                                                @foreach($unit_price as $item)
                                                    @if($order->variant_id==$item->product_id)
                                                        <option value="{{$item->id}}" {{$item->id==$order->sell_unit?'selected':''}}>{{$item->unit->unit}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                           @if($order->foc)
                                                <input type="text" class="form-control" value="FOC">
                                               @else
                                                <select name=""  id="dis_pro{{$order->id}}" class="form-control select_update">
                                                    <option value="0">Select Discount</option>
                                                    @foreach($dis_promo as $item)

                                                        @if($order->variant_id==$item->variant_id)
                                                            <option value="{{$item->rate}}" {{$item->rate==$order->discount_promotion?'selected':''}}>{{$item->rate}} %</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="total" id="total_{{$order->id}}"
                                                   class="form-control update_item_{{$order->id}}"
                                                   value="{{$order->foc?0:number_format($order->total)}}">
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
                                            var unit_id=$('#unit{{$order->id}} option:selected').val();
                                            @foreach($unit_price as $item)
                                                if(unit_id=="{{$item->id}}") {
                                                var price = "{{$item->price}}";
                                            }
                                                @endforeach


                                           @if($order->foc)
                                            $('#price_{{$order->id}}').val(0);
                                            $('#total_{{$order->id}}').val(0);
                                            @else
                                            $('#price_{{$order->id}}').val(price);
                                            var quantity = $('#quantity_{{$order->id}}').val();
                                            var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                            var sub_total =quantity * price;
                                            var amount=(dis_pro/100)*sub_total;
                                            var total=sub_total-amount;
                                            $('#total_{{$order->id}}').val(total);
                                            @endif
                                            $('.select_update').change(function () {
                                                var unit_id=$('#unit{{$order->id}} option:selected').val();
                                                @foreach($unit_price as $item)
                                                if(unit_id=="{{$item->id}}") {
                                                    var price = "{{$item->price}}";
                                                }
                                                @endforeach
                                                @if($order->foc)
                                                $('#price_{{$order->id}}').val(0);
                                                $('#total_{{$order->id}}').val(0);
                                                @else
                                                $('#price_{{$order->id}}').val(price);

                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total =quantity * price;
                                                var amount=(dis_pro/100)*sub_total;
                                                var total=sub_total-amount;
                                                $('#total_{{$order->id}}').val(total);
                                                var product = $('#product_{{$order->id}}').val();
                                                var sell_unit=$('#unit{{$order->id}} option:selected').val();
                                                var discount_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                                @endif
                                                $.ajax({
                                                    data: {
                                                        "product_id": product,
                                                        'quantity': quantity,
                                                        'unit_price': price,
                                                        "total": total,
                                                        'sell_unit':sell_unit,
                                                        'discount_pro':discount_pro
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
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                @if($order->foc)
                                                $('#price_{{$order->id}}').val(0);
                                                $('#total_{{$order->id}}').val(0);
                                                @else
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();
                                                var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total =quantity * price;
                                                var amount=(dis_pro/100)*sub_total;
                                                var total=sub_total-amount;
                                                $('#total_{{$order->id}}').val(total);
                                                @endif
                                            });
                                        });
                                        $(document).ready(function () {
                                            $(".update_item_{{$order->id}}").keyup(function () {
                                                var product = $('#product_{{$order->id}}').val();
                                                var quantity = $('#quantity_{{$order->id}}').val();
                                                var price = $('#price_{{$order->id}}').val();
                                                var dis_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                                var sub_total =quantity * price;
                                                var amount=(dis_pro/100)*sub_total;
                                                var total=sub_total-amount;
                                                var sell_unit=$('#unit{{$order->id}} option:selected').val();
                                                var discount_pro=$('#dis_pro{{$order->id}} option:selected').val();
                                                $.ajax({
                                                    data: {
                                                        "product_id": product,
                                                        'quantity': quantity,
                                                        'unit_price': price,
                                                        "total": total,
                                                        'sell_unit':sell_unit,
                                                        'discount_pro':discount_pro
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
                                    <td colspan="4"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Total</span></th>
                                    <td id="total_div" colspan="2"><input class="form-control" type="number" id="total"
                                                                          value="{{$grand_total}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Discount</span></th>

                                    <td id="discount_div" colspan="2"><input class="form-control" type="text"
                                                                             id="discount" value="0.0"></td>
                                </tr>
                                <tr id="delivery">
                                    <td colspan="4"></td>
                                    <td></td>
                                    <th colspan="2" class="text-right"><span class="mt-5">Delivery Fee</span></th>
                                    <td colspan="2">
                                        <input type="number" class="form-control" name="delivery_fee" id="deli_fee" value="0.0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
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
                                    <td colspan="4"></td>
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
    <script>
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
        $('input').keyup(function () {
            var tax = $('#tax option:selected').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ='{{$tax->rate}}';
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
                var tax_rate ='{{$tax->rate}}';
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
    </script>
   @include('invoice.innerjs')
    <!-- /Page Content -->

@endsection