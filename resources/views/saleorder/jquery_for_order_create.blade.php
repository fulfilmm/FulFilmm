<script>

    $(document).ready(function () {
        $('select').select2();

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
        var tax = $('#tax option:selected').val();
        var sum =$('#total').val();
        @foreach($data['taxes'] as $tax)
        if (tax == "{{$tax->id}}")
            var tax_rate ='{{$tax->rate}}';
                @endforeach
        var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
        var discount = $('#discount').val();
        var deli_fee = $('#deli_fee').val();
        $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
        $('select').change(function () {
            var tax = $('#tax option:selected').val();
            var sum =$('#total').val();
            @foreach($data['taxes'] as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ='{{$tax->rate}}';
                    @endforeach
            var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
            var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
        });
        $('input').keyup(function () {
            var tax = $('#tax option:selected').val();
            var sum =$('#total').val();
            @foreach($data['taxes'] as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate ='{{$tax->rate}}';
                    @endforeach
            var tax_amount = parseFloat(sum) * (parseInt(tax_rate) / 100);
            var discount = $('#discount').val();
            var deli_fee = $('#deli_fee').val();
            $('#grand_total').val((parseFloat(sum) + parseFloat(deli_fee) + parseFloat(tax_amount)) - parseFloat(discount));
        });
    });
    $(document).ready(function () {
        $(document).on('click','#add_item',function (){
            var order_id=$('#order_id').val();
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
            var variant_id=$('#variant option:selected').val();
            var phone = $('#phone').val();
            // alert(creation_id);
            $.ajax({
                data: {
                    'variant_id':variant_id,
                    "product_id":product,
                    "invoice_id":creation_id,
                    'phone': phone,
                    'order_id':order_id,
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
                    'type':'order',
                    'inv_type':'Whole Sale'

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
            var discount=$('#discount').val();
            var total=$('#total').val();
            var tax_id=$('#tax option:selected').val();
            var tax_amount=$('#tax_amount').val()
            $.ajax({
                data: {
                    'discount':discount,
                    'total':total,
                    'tax_id':tax_id,
                    'tax_amount':tax_amount,
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