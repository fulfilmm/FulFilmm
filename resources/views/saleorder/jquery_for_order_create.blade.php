<script>
    jQuery(document).ready(function () {
        'use strict';

        jQuery('#order_date').datetimepicker();
    });
    $(document).on('change', 'input', function () {
        var quantity = $('#quantity').val();
        var price = $('#price').val();
        var total = quantity * price;
        var tax = $('#product_tax').val();
        var tax_amount = tax / 100 * total;
        var include_tax = total + tax_amount;
        $('#total').val(include_tax);

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
        $('#product').select2({
            "language": {},
            escapeMarkup: function (markup) {
                return markup;
            }
        });
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

    $(document).on('change', '#product', function () {
        var product_id = $("#product option:selected").val();
        // alert(product_id);
                @foreach($data['product'] as $product )
        var p_id =
        {{$product->id}}
        if (p_id == product_id) {
            var tax = {{$product->taxes->rate}};
            $('#product_tax').val(tax);
            $('#price').val({{$product->sale_price}});
            $('#unit').val("{{$product->currency_unit}}");
        }
        @endforeach
    });
    $(document).ready(function () {
        $(document).on('click', '#add_item', function () {
            var creation_id = $('#creation_id').val();
            var product = $('#product option:selected').val();
            var desc = $('#order_description').val();
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var discount = $('#discount').val();
            var discount_type = $('#discount_type option:selected').val();
            var tax = $('#product_tax').val();
            var unit = $('#unit').val();
            var total = $('#total').val();
            $.ajax({
                data: {
                    "product_id": product,
                    'description': desc,
                    'quantity': quantity,
                    "tax_id": tax,
                    'discount': discount,
                    "discount_type": discount_type,
                    'unit_price': price,
                    "currency_unit": unit,
                    "total": total,
                    "invoice_id": creation_id

                },
                type: 'POST',
                url: "{{route('invoice_items.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    $("#order_table").load(location.href + " #order_table>* ");
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
            var time = $('#time').val();
            var phone = $('#phone').val();
            $.ajax({
                data: {
                    'time': time,
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
                type: 'POST',
                url: "{{route('saleorders.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    if (!$.isEmptyObject(data.orderempty)) {
                        swal('Empty Item', 'You order does not have any item.', 'error');

                    } else if ($.isEmptyObject(data.error)) {
                        console.log(data);
                        swal('Order Crete', 'Order Create Succes', 'success');

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