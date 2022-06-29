<script>
    $(document).ready(function () {
        var warehouse = $('#warehouse option:selected').val();
        var quantity = $('#quantity_{{$order->id}}').val();
        var unit_id = $('#unit{{$order->id}} option:selected').val();

        @foreach($aval_product as $item)
        if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
            @foreach($unit_price as $unit)
            if (unit_id == '{{$unit->id}}') {
                var subqty = quantity * parseInt('{{$unit->unit_convert_rate}}');
                var aval = Math.round((parseFloat('{{$item->available}}') - subqty) / parseInt('{{$unit->unit_convert_rate}}'));
                $('#aval{{$order->id}}').val(aval);
            }
            @endforeach



        }
        @endforeach
    });
    $(".update_item_{{$order->id}}").keyup(function () {
        var customer_id = $('#client_id option:selected').val();
        var unit_id = $('#unit{{$order->id}} option:selected').val();
        @foreach($prices as $item)
        if(unit_id=="{{$item->unit_id}}") {
            var qty=$('#quantity_{{$order->id}}').val();
            if(parseInt("{{$item->min}}")<= qty){
                var price = "{{$item->price}}";
            }
        }
        @endforeach
        @if($order->foc)
        $('#price_{{$order->id}}').val(0);
        $('#total_{{$order->id}}').val(0);
        @else
        $('#price_{{$order->id}}').val(price);
        var quantity = $('#quantity_{{$order->id}}').val();
        var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
        var warehouse = $('#warehouse option:selected').val();
        @foreach($aval_product as $item)
        if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
            @foreach($unit_price as $unit)
            if (unit_id == '{{$unit->id}}') {
                var subqty = quantity * parseInt('{{$unit->unit_convert_rate}}');
                var aval = Math.round((parseFloat('{{$item->available}}') - subqty) / parseInt('{{$unit->unit_convert_rate}}'));
                $('#aval{{$order->id}}').val(aval);
                if (aval >= 0) {
                    var sub_total = quantity * price;
                    var amount = (dis_pro / 100) * sub_total;
                    var total = sub_total - amount;
                    $('#total_{{$order->id}}').val(total);
                    var sum = 0;
                    $('.total').each(function () {
                        sum += parseFloat($(this).val());
                    });
                    $('#total').val(sum);

                } else {
                    swal({
                        title: "Not Enough Quantity", text: '', type:
                            "warning"
                    }).then(function () {
                            $('#quantity_{{$order->id}}').val('{{$order->quantity}}');
                            location.reload();
                        }
                    );
                }
            }
            @endforeach

        }
        @endforeach
                @foreach($allcustomers as $client)
        if ('{{$client->id}}' == customer_id) {
            if ((parseFloat(sum) + parseFloat('{{$client->current_credit}}')) > parseFloat('{{$client->credit_limit}}')) {
                noti_alert();
            }
        }
        @endforeach
        @endif

    });
    $(".select_update").change(function () {
        var customer_id = $('#client_id option:selected').val();
        var unit_id = $('#unit{{$order->id}} option:selected').val();
        var warehouse = $('#warehouse option:selected').val();

        @foreach($prices as $item)
        if (unit_id == "{{$item->unit_id}}") {
            var qty = $('#quantity_{{$order->id}}').val();
            if (parseInt("{{$item->min}}") <= qty) {
                var price = "{{$item->price}}";
            }
        }
        @endforeach


        @if($order->foc)
        $('#price_{{$order->id}}').val(0);
        $('#total_{{$order->id}}').val(0);
        @else
        $('#price_{{$order->id}}').val(price);
        var quantity = $('#quantity_{{$order->id}}').val();
        var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
        var sub_total = quantity * price;
        var amount = (dis_pro / 100) * sub_total;
        var total = sub_total - amount;

        $('#total_{{$order->id}}').val(total);
        var sum = 0;
        $('.total').each(function () {
            sum += parseFloat($(this).val());
        });
        $('#total').val(sum);
        @foreach($aval_product as $item)
        if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
            @foreach($unit_price as $unit)
            if (unit_id == '{{$unit->id}}') {
                var subqty = quantity * parseInt('{{$unit->unit_convert_rate}}');
                var aval = Math.round((parseFloat('{{$item->available}}') - subqty) / parseInt('{{$unit->unit_convert_rate}}'));
                $('#aval{{$order->id}}').val(aval);
            }
            @endforeach



        }
        @endforeach
                @foreach($allcustomers as $client)
        if ('{{$client->id}}' == customer_id) {
            if ((parseFloat(sum) + parseFloat('{{$client->current_credit}}')) > parseFloat('{{$client->credit_limit}}')) {
                noti_alert();
            }
        }
        @endforeach
        @endif

    });
    $(document).ready(function () {
        var customer_id = $('#client_id option:selected').val();
        var unit_id = $('#unit{{$order->id}} option:selected').val();
        @foreach($prices as $item)
        if(unit_id=="{{$item->unit_id}}") {
            var qty=$('#quantity_{{$order->id}}').val();
            if(parseInt("{{$item->min}}")<= qty){
                var price = "{{$item->price}}";

            }
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
        var sum = 0;
        $('.total').each(function() {
            sum += parseFloat($(this).val());
        });
        $('#total').val(sum);
        @endif
        $('.select_update').change(function () {
            var unit_id = $('#unit{{$order->id}} option:selected').val();
            var warehouse = $('#warehouse option:selected').val();
            @foreach($prices as $item)
            if(unit_id=="{{$item->unit_id}}") {
                var qty=$('#quantity_{{$order->id}}').val();
                if(parseInt("{{$item->min}}")<= qty ){
                    var price = "{{$item->price}}";
                }
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
            var sum = 0;
            $('.total').each(function() {
                sum += parseFloat($(this).val());
            });
            $('#total').val(sum);
            var product = $('#product_{{$order->id}}').val();
            var sell_unit=$('#unit{{$order->id}} option:selected').val();
            var discount_pro=$('#dis_pro{{$order->id}} option:selected').val();
            @endif
                    @foreach($aval_product as $item)
            if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
                @foreach($unit_price as $unit)
                if (unit_id == '{{$unit->id}}') {
                    var subqty = quantity * parseInt('{{$unit->unit_convert_rate}}');
                    var aval = Math.round((parseFloat('{{$item->available}}') - subqty) / parseInt('{{$unit->unit_convert_rate}}'));
                    if (aval >= 0) {
                        $.ajax({
                            data: {
                                "product_id": product,
                                'quantity': quantity,
                                'unit_price': price,
                                "total": total,
                                'sell_unit': sell_unit,
                                'discount_pro': discount_pro,
                                'warehouse_id':warehouse,
                            },
                            type: 'PUT',
                            url: "{{route('invoice_items.update',$order->id)}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                console.log(data);
                                if (!$.isEmptyObject(data.out_of_stock)) {
                                    swal('Empty Item', data.out_of_stock);
                                    $('#quantity_{{$order->id}}').val('{{$order->quantity}}');
                                    // location.reload();

                                }

                            }
                        });

                    } else {
                        swal({
                            title: "Not Enough Quantity", text: '', type:
                                "warning"
                        }).then(function () {
                                location.reload();

                            }
                        );
                    }
                }
                @endforeach

            }
            @endforeach

        });
    });
    $(document).ready(function () {
        $(".update_item_{{$order->id}}").keyup(function () {
            var customer_id = $('#client_id option:selected').val();
            @if($order->foc)
            $('#price_{{$order->id}}').val(0);
            $('#total_{{$order->id}}').val(0);
                    @else
            var quantity = $('#quantity_{{$order->id}}').val();
            var price = $('#price_{{$order->id}}').val();
            var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
            var warehouse = $('#warehouse option:selected').val();
            @foreach($aval_product as $item)
            if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
                if (parseInt('{{$item->available}}') >= quantity) {
                    var sub_total = quantity * price;
                    var amount = (dis_pro / 100) * sub_total;
                    var total = sub_total - amount;
                    $('#total_{{$order->id}}').val(total);
                    var sum = 0;
                    $('.total').each(function () {
                        sum += parseFloat($(this).val());
                    });
                    $('#total').val(sum);
                } else {
                    swal({
                        title: "Not Enough Quantity", text: '', type:
                            "warning"
                    }).then(function () {
                            $('#quantity_{{$order->id}}').val('{{$order->quantity}}');
                            location.reload();
                        }
                    );
                }
            }
            @endforeach

                    @foreach($allcustomers as $client)
            if ('{{$client->id}}' == customer_id) {
                if ((parseFloat(sum) + parseFloat('{{$client->current_credit}}')) > parseFloat('{{$client->credit_limit}}')) {
                    noti_alert();
                }
            }
            @endforeach
            @endif
        });
    });
    $(document).ready(function () {
        $(".update_item_{{$order->id}}").keyup(function () {
            var product = $('#product_{{$order->id}}').val();
            var quantity = $('#quantity_{{$order->id}}').val();
            var price = $('#price_{{$order->id}}').val();
            var dis_pro = $('#dis_pro{{$order->id}} option:selected').val();
            var sub_total = quantity * price;
            var amount = (dis_pro / 100) * sub_total;
            var total = sub_total - amount;
            var sell_unit = $('#unit{{$order->id}} option:selected').val();
            var discount_pro = $('#dis_pro{{$order->id}} option:selected').val();
            var warehouse = $('#warehouse option:selected').val();
            @foreach($aval_product as $item)
            if ('{{$order->variant->id}}' == '{{$item->variant->id}}' && warehouse == '{{$item->warehouse_id}}') {
                @foreach($unit_price as $unit)
                if (sell_unit == '{{$unit->id}}') {
                    var subqty = quantity * parseInt('{{$unit->unit_convert_rate}}');
                    var aval = Math.round((parseFloat('{{$item->available}}') - subqty) / parseInt('{{$unit->unit_convert_rate}}'));
                    if (aval >= 0) {
                        $.ajax({
                            data: {
                                "product_id": product,
                                'quantity': quantity,
                                'unit_price': price,
                                "total": total,
                                'sell_unit': sell_unit,
                                'discount_pro': discount_pro,
                                'warehouse_id':warehouse,
                            },
                            type: 'PUT',
                            url: "{{route('invoice_items.update',$order->id)}}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                console.log(data);

                            }
                        });
                    } else {
                        swal({
                            title: "Not Enough Quantity", text: '', type:
                                "warning"
                        }).then(function () {
                                $('#quantity_{{$order->id}}').val('{{$order->quantity}}');
                                location.reload();


                            }
                        );
                    }
                }
                @endforeach
            }
            @endforeach

        });
    });
</script>