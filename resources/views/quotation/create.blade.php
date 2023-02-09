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
                    <h3 class="page-title">{{$type}} Quotation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="col-12 mt-3">
            {{--                    <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation_id}}">--}}
            <div class="row mb-3 ">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header">Required Field</div>
                        <div class="col-12">
                            <div class="row my-3">
                                <div class="col-md-6" id="contact_div">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Expiration</label>
                                        <input type="date" class="form-control {{ $errors->has('exp_date') ? ' is-invalid' : '' }}"
                                               name="exp_date" id="exp" value="{{$data[0]['expiration']??''}}" required>
                                        <span class="help-block">
                                        <strong class="text-danger text-center expiration_err"></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6" id="contact_div">
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
                                <div class="col-md-12">
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
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header">Action</div>
                        <div class="col-12 my-3">
                            <button class="btn btn-outline-success col-12 my-3" type="button" id="save">Save</button>
                            <button type="button" class="btn btn-outline-warning col-12 my-3" id="send_email">SendByEmail</button>
                            <button class="btn btn-outline-primary col-12 my-3" id="confirm">Confirm</button>
                            <button class="btn btn-danger col-12 my-3" type="button" id="discard">Discard</button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="card shadow">
                    <div class="card-header">Quote Item</div>
                   <div class="col-12 mt-2">
                       <div  id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
                           <div class="form-group">
                               <input type="hidden" id="form_id" value="{{$request_id[0]}}">
                               <div class="row">
                                   <div class="col-md-8 col-12">
                                       <div class="input-group">
                                           <select name="" id="variant" class="form-control select2">
                                               @foreach($aval_product as $item)
                                                   <option value="{{$item->variant->id}}"
                                                           data-option="{{$item->warehouse_id}}">{{$item->variant->product_name}} ( {{$item->variant->variant}})</option>
                                               @endforeach
                                           </select>
                                           <div class="input-group-prepend">
                                               <button class="btn btn-primary rounded-right" id="add_item">Add</button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <table class="table table-hover table-nowrap">
                               <thead>
                               <th scope="col" style="min-width: 200px;">Product</th>
                               <th>Quantity</th>
                               <th>Unit</th>
                               <th>Price</th>
                               <th>Discount/Promotion</th>
                               <th>Total</th>
                               <th>Action</th>
                               </thead>
                               <tbody id="tbody">
                               @foreach($orderline as $order)
                                   <tr>
                                       <td style="min-width: 300px;max-width:400px">
                                           <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                                           <div class="row">
                                               <input type="hidden" name="product_id" id="product_{{$order->id}}"
                                                      value="{{$order->product_id}}">
                                               <div class="col-md-2">
                                                   @php
                                                       $img=json_decode($order->variant->image);
                                                   @endphp
                                                   @if($img!=null)
                                                       <img src="{{url(asset('product_picture/'.$img[0]??''))}}"
                                                            alt="" style="max-width: 50px;max-height: 50px;">
                                                   @endif
                                               </div>
                                               <div class="col-md-9 ml-2">
                                                   <div>
                                                       <span class="font-weight-bold">{{$order->variant->product_name}}</span>
                                                   </div>
                                                   <p class="m-0 mt-1">
                                                       {!!$order->description!!}
                                                   </p>
                                               </div>
                                           </div>
                                       </td>
                                       <td>
                                           <input type="text" name="hello" id="edit_quantity_{{$order->id}}"
                                                  class="form-control update_item_{{$order->id}}"
                                                  value="{{$order->quantity}}">
                                       </td>
                                       <td style="min-width: 100px;">
                                           <select name="" class="select2 select_update" id="unit{{$order->id}}" style="min-width: 100px">
                                               @foreach($unit_price as $item)
                                                   @if($order->variant->product_id==$item->product_id)
                                                       <option value="{{$item->id}}" {{$item->id==$order->unit_id?'selected':''}}>{{$item->unit}}</option>
                                                   @endif
                                               @endforeach
                                           </select>
                                       </td>
                                       <td style="min-width: 120px"><input type="text" id="edit_price_{{$order->id}}"
                                                                           class="form-control update_item_{{$order->id}}" value="{{$order->price??0}}">
                                       </td>
                                       <td>
                                           {{--@if($order->foc)--}}
                                               {{--<input type="text" class="form-control" value="FOC">--}}
                                           {{--@else--}}
                                               <input type="text" class="form-control update_item_{{$order->id}}" id="dis_pro{{$order->id}}" value="{{$order->discount??0}}">
                                           {{--@endif--}}
                                       </td>
                                       <td style="min-width: 120px;">
                                           <input type="number" name="total" id="edit_total_{{$order->id}}"
                                                  class="form-control update_item_{{$order->id}}"
                                                  value="{{$order->total_amount}}">
                                       </td>
                                       <td>
                                           <button type="button" class="btn btn-danger btn-sm" id="remove{{$order->id}}"><i
                                                       class="fa fa-trash-o "></i></button>
                                           @include('quotation.order_delete')
                                       </td>
                                       <script>
                                           $(document).ready(function () {
                                               $(".update_item_{{$order->id}}").keyup(function () {
                                                   @if($order->foc)
                                                   $('#edit_price_{{$order->id}}').val(0);
                                                   $('#edit_total_{{$order->id}}').val(0);
                                                           @else
                                                   var quantity = $('#edit_quantity_{{$order->id}}').val();
                                                   var price = $('#edit_price_{{$order->id}}').val();
                                                   var dis_pro=$('#dis_pro{{$order->id}}').val();
                                                   var sub_total =quantity * price;
                                                   var total=sub_total-dis_pro;
                                                   $('#edit_total_{{$order->id}}').val(total);
                                                   @endif
                                               });
                                           });
                                           $(document).ready(function () {
                                               $(".update_item_{{$order->id}}").keyup(function () {
                                                   var quantity = $('#edit_quantity_{{$order->id}}').val();
                                                   var price = $('#edit_price_{{$order->id}}').val();
                                                   var dis_pro=$('#dis_pro{{$order->id}}').val();
                                                   var sub_total =quantity * price;
                                                   var total=sub_total-dis_pro;
                                                   var sell_unit=$('#unit{{$order->id}} option:selected').val();
                                                   $.ajax({
                                                       data: {
                                                           "unit_id": sell_unit,
                                                           'quantity': quantity,
                                                           'unit_price': price,
                                                           "total": total,
                                                           'discount_pro':dis_pro
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
                                                           $('#grand_total').val(grand_total);
                                                           // $("#order_table").load(location.href + " #order_table>* ");
                                                           $("#grand_total_div").load(location.href + " #grand_total_div>* ");
                                                           $("#total_div").load(location.href + " #total_div>* ");

                                                       }
                                                   });
                                               });
                                           });
                                           $(document).ready(function () {
                                               $("#unit{{$order->id}}").change(function () {
                                                   var quantity = $('#edit_quantity_{{$order->id}}').val();
                                                   var price = $('#edit_price_{{$order->id}}').val();
                                                   var dis_pro=$('#dis_pro{{$order->id}}').val();
                                                   var sub_total =quantity * price;
                                                   var total=sub_total-dis_pro;
                                                   var sell_unit=$('#unit{{$order->id}} option:selected').val();
                                                   $.ajax({
                                                       data: {
                                                           "unit_id": sell_unit,
                                                           'quantity': quantity,
                                                           'unit_price': price,
                                                           "total": total,
                                                           'discount_pro':dis_pro
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
                                                           $('#grand_total').val(grand_total);
                                                           // $("#order_table").load(location.href + " #order_table>* ");
                                                           $("#grand_total_div").load(location.href + " #grand_total_div>* ");
                                                           $("#total_div").load(location.href + " #total_div>* ");

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
                                   <th>Total</th>

                                   <td id="total_div" colspan="2"><input class="form-control" type="text" id="total" value="{{$grand_total}}">
                                   </td>
                                   <td></td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <th>Discount</th>
                                   <td id="discount_div" colspan="2"><input class="form-control" type="text" id="discount" value="0.0" ></td>
                                   <td></td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <th>Tax</th>

                                   <td id="tax" colspan="2">
                                       <div class="input-group">
                                           <input type="number" id="tax_amount" class="form-control">
                                           <select name="" id="tax" class="form-control">
                                               @foreach($taxes as $tax)
                                                   <option value="{{$tax->id}}">{{$tax->name}} ({{$tax->rate}} %)</option>
                                               @endforeach
                                           </select>
                                       </div>
                                   </td>
                                   <td></td>

                               </tr>
                               <tr>
                                   <td></td>
                                   <td></td>
                                   <td></td>
                                   <th>Grand Total</th>

                                   <td id="grand_total_div" colspan="2"><input class="form-control" type="text" id="grand_total" value="{{$grand_total}}">
                                   </td>
                                   <td></td>
                               </tr>
                           </table>
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
        $(document).ready(function () {
           $('.select2').select2();
        });
        $('input').keyup( function () {
            var tax=$('#tax option:selected').val();
            @foreach($taxes as $tax)
            if(tax=="{{$tax->id}}")
                var tax_rate='{{$tax->rate}}';
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

        $(document).ready(function () {
            $(document).on('click', '#add_item', function (event) {
                event.preventDefault();
                var quotation_id = $('#form_id').val();
                var customer_id = $('#customer_name option:selected').val();
                var exp = $('#exp').val();
                var pay_term = $('#pay_term option:selected').val();
                var grand_total = $('#grand_total').val();
                var deal_id = $('#deal_id option:selected').val();
                var term_condition = $("#term_and_condition").val();
                var variant_id=$('#variant option:selected').val();
                $.ajax({
                    data: {
                        variant_id:variant_id,
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,

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
                var tax_id=$('#tax option:selected').val();
                var discount=$('#discount').val();
                var tax_amount=$('#tax_amount').val();
                var total=$('#total').val();
// alert(term_condition);
                $.ajax({
                    data: {
                        tax_id:tax_id,
                        discount:discount,
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,
                        confirm: 1,
                        total:total,
                        tax_amount:tax_amount,
                        sale_type:'{{$type}}'
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
                var tax_id=$('#tax option:selected').val();
                var discount=$('#discount').val();
                var tax_amount=$('#tax_amount').val();
                var total=$('#total').val();
// alert(term_condition);
                $.ajax({
                    data: {
                        tax_id:tax_id,
                        discount:discount,
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,
                        total:total,
                        tax_amount:tax_amount,
                        sale_type:'{{$type}}'
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
                var tax_id=$('#tax option:selected').val();
                var discount=$('#discount').val();
                var tax_amount=$('#tax_amount').val();
                var total=$('#total').val();
                $.ajax({
                    data: {
                        tax_id:tax_id,
                        discount:discount,
                        quotation_id: quotation_id,
                        customer: customer_id,
                        expiration: exp,
                        payment_term: pay_term,
                        grand_total: grand_total,
                        term_and_condition: term_condition,
                        deal_id: deal_id,
                        send_email: 'saveandsend',
                        confirm: 1,
                        total:total,
                        tax_amount:tax_amount,
                        sale_type:'{{$type}}'
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
