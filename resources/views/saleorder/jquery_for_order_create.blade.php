<script>
    jQuery(document).ready(function () {
        'use strict';

        jQuery('#order_date').datetimepicker();
        $('#customer_id').select2();
        $('#product').select2();
        $('#quotation_id').select2();
        $('#payment_term').select2();
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
        var p_id ={{$customer->id}}
        if (p_id == customer_id) {
            $('#phone').val({{$customer->phone}});
            $('#email').val("{{$customer->email}}");
            $('#address').val("{{$customer->address}}");
            $('#billing_address').val("{{$customer->address}}");
        }
        @endforeach
    });

    $(document).ready(function () {
        $(document).on('change','#product',function (){
            var creation_id = $('#creation_id').val();
            var product = $('#product option:selected').val();
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
            // alert(creation_id);
            $.ajax({
                data: {
                    "product_id":product,
                    "invoice_id":creation_id,
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
                    'quotation_id': quotation_id,
                    'type':'order'

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
                    location.reload();

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
            var phone = $('#phone').val();
            $.ajax({
                data: {
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