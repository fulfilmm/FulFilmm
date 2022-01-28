<script>

    $(document).ready(function () {

        $('select').select2();

    });

    $(document).ready(function () {
        $('#client_id').change(function () {
            var client_id=$(this).val();
            @foreach($allcustomers as $client)
            if(client_id=='{{$client->id}}'){
                $('#client_address').val("{{$client->address}}");
                $('#client_email').val("{{$client->email}}");
            }
            @endforeach
        }) ;
    });
    $(document).ready(function () {
        $('input[type="radio').change(function () {
            var deli=$(this).val();
            if(deli=='on'){
                $('#delivery').show();
            }else if(deli=='off'){
                $('#delivery').hide();
            }
        });
    });

    $(document).on('click', '#add_item', function () {
        var variant_id = $('#variant option:selected').val();
        var invoice_id = $('#invoice_id').val();
        var client_id = $('#client_id').val();
        var client_email = $('#client_email').val();
        var inv_date = $('#inv_date').val();
        var due_date = $('#due_date').val();
        var client_address = $('#client_address').val();
        var bill_address = $('#bill_address').val();
        var more_info = $('#more_info').val();
        var inv_grand_total = $('#inv_grand_total').val();
        var payment = $('#payment option:selected').val();
        var status = $('#status option:selected').val();
        var title = $('#title').val();
        var order_id = $('#order_id').val();
        $.ajax({
            data: {
                'variant_id': variant_id,
                "invoice_id": invoice_id,
                'title': title,
                "client_id": client_id,
                'client_email': client_email,
                'inv_date': inv_date,
                "due_date": due_date,
                'client_address': client_address,
                "more_info": more_info,
                'inv_grand_total': inv_grand_total,
                'bill_address': bill_address,
                'status': status,
                'order_id': order_id,
                'payment_method': payment,
                'type': 'invoice',
                'inv_type':'{{$type}}'

            },
            type: 'POST',
            url: "{{route('invoice_items.store')}}",
            async: false,
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
                if (!$.isEmptyObject(data.Error)) {
                    // alert(data.orderempty);
                    swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                }else {

                    location.reload();
                }
            }
        });

    });

    $(document).on('click', '#add_item_code', function (event) {
        var code=$('#code option:selected').val();
        var invoice_id = $('#invoice_id').val();
        var client_id = $('#client_id').val();
        var client_email = $('#client_email').val();
        var inv_date = $('#inv_date').val();
        var due_date = $('#due_date').val();
        var client_address = $('#client_address').val();
        var bill_address = $('#bill_address').val();
        var more_info = $('#more_info').val();
        var inv_grand_total = $('#inv_grand_total').val();
        var payment = $('#payment option:selected').val();
        var status = $('#status option:selected').val();
        var title = $('#title').val();
        var order_id = $('#order_id').val();
        $.ajax({
            data: {
                'variant_id': code,
                "invoice_id": invoice_id,
                'title': title,
                "client_id": client_id,
                'client_email': client_email,
                'inv_date': inv_date,
                "due_date": due_date,
                'client_address': client_address,
                "more_info": more_info,
                'inv_grand_total': inv_grand_total,
                'bill_address': bill_address,
                'status': status,
                'order_id': order_id,
                'payment_method': payment,
                'type': 'invoice',
                'inv_type':'{{$type}}'

            },
            type: 'POST',
            url: "{{route('invoice_items.store')}}",
            async: false,
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
                if (!$.isEmptyObject(data.Error)) {
                    // alert(data.orderempty);
                    swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                }else {

                    location.reload();
                }
            }
        });

    });
    $(document).on('click', '#foc_item', function (event) {
        var foc=$('#foc_id option:selected').val();
        var invoice_id = $('#invoice_id').val();
        var client_id = $('#client_id').val();
        var client_email = $('#client_email').val();
        var inv_date = $('#inv_date').val();
        var due_date = $('#due_date').val();
        var client_address = $('#client_address').val();
        var bill_address = $('#bill_address').val();
        var more_info = $('#more_info').val();
        var inv_grand_total = $('#inv_grand_total').val();
        var payment = $('#payment option:selected').val();
        var status = $('#status option:selected').val();
        var title = $('#title').val();
        var order_id = $('#order_id').val();
        $.ajax({
            data: {
                'variant_id': foc,
                "invoice_id": invoice_id,
                'title': title,
                "client_id": client_id,
                'client_email': client_email,
                'inv_date': inv_date,
                "due_date": due_date,
                'client_address': client_address,
                "more_info": more_info,
                'inv_grand_total': inv_grand_total,
                'bill_address': bill_address,
                'status': status,
                'order_id': order_id,
                'payment_method': payment,
                'type': 'invoice',
                'foc':1

            },
            type: 'POST',
            url: "{{route('invoice_items.store')}}",
            async: false,
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
                if (!$.isEmptyObject(data.Error)) {
                    // alert(data.orderempty);
                    swal('Fixed Sale Unit Price ', 'This product does not fixed unit price.', 'error');
                }else {

                    location.reload();
                }
            }
        });

    });
    $(document).ready(function () {
        $(document).on('click', '#saveAndsend', function () {
            var client_id = $('#client_id').val();
            var client_email = $('#client_email').val();
            var inv_date = $('#inv_date').val();
            var due_date = $('#due_date').val();
            var client_address = $('#client_address').val();
            var bill_address = $('#bill_address').val();
            var more_info = $('#more_info').val();
            var inv_grand_total = $('#grand_total').val();
            var payment = $('#payment option:selected').val();
            var status = $('#status option:selected').val();
            var title = $('#title').val();
            var order_id = $('#order_id').val();
            var action_type = 'save_and_send';
            var discount = $('#discount').val();
            var total = $('#total').val();
            var tax_id = $('#tax option:selected').val();
            var tax_amount = $('#tax_amount').val();
            var inv_type = $('#inv_type option:selected').val();
            var deli_fee = $('#deli_fee').val();
            var warehouse=$('#warehouse option:selected').val();
            $.ajax({
                data: {
                    'discount': discount,
                    'total': total,
                    'tax_id': tax_id,
                    'tax_amount': tax_amount,
                    'title': title,
                    "client_id": client_id,
                    'client_email': client_email,
                    'inv_date': inv_date,
                    "due_date": due_date,
                    'client_address': client_address,
                    "more_info": more_info,
                    'inv_grand_total': inv_grand_total,
                    'bill_address': bill_address,
                    "save_type": action_type,
                    'status': status,
                    'order_id': order_id,
                    'payment_method': payment,
                    'invoice_type': inv_type,
                    'delivery_fee': deli_fee,
                    'inv_type':"{{$type}}",
                    'warehouse_id':warehouse
                },
                type: 'POST',
                url: "{{route('invoices.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    if (!$.isEmptyObject(data.orderempty)) {
                        // alert(data.orderempty);
                        swal('Empty Item', 'You invoice does not have any item.', 'error');
                    } else {
                        window.location = data.url;
                    }
                }
            });
        });
    });

    //save only
    $(document).ready(function () {
        $(document).on('click', '#save', function () {
            var client_id = $('#client_id').val();
            var client_email = $('#client_email').val();
            var inv_date = $('#inv_date').val();
            var due_date = $('#due_date').val();
            var client_address = $('#client_address').val();
            var more_info = $('#more_info').val();
            var bill_address = $('#bill_address').val();
            var inv_grand_total = $('#grand_total').val();
            var payment = $('#payment option:selected').val();
            var status = $('#status option:selected').val();
            var title = $('#title').val();
            var order_id = $('#order_id').val();
            var discount = $('#discount').val();
            var total = $('#total').val();
            var tax_id = $('#tax option:selected').val();
            var tax_amount = $('#tax_amount').val();
            var inv_type = $('#inv_type option:selected').val();
            var deli_fee = $('#deli_fee').val();
            var warehouse=$('#warehouse option:selected').val();
            $.ajax({
                data: {
                    'discount': discount,
                    'total': total,
                    'tax_id': tax_id,
                    'tax_amount': tax_amount,
                    'order_id': order_id,
                    'title': title,
                    'client_id': client_id,
                    'client_email': client_email,
                    'inv_date': inv_date,
                    'due_date': due_date,
                    'client_address': client_address,
                    'more_info': more_info,
                    'bill_address': bill_address,
                    'inv_grand_total': inv_grand_total,
                    'status': status,
                    'payment_method': payment,
                    'invoice_type': inv_type,
                    'delivery_fee': deli_fee,
                    'inv_type':"{{$type}}",
                    'warehouse_id':warehouse

                },
                type: 'POST',
                url: "{{route('invoices.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    // console.log(data.errors);
                    if (!$.isEmptyObject(data.orderempty)) {
                        // alert(data.orderempty);
                        swal('Empty Item', 'You invoice does not have any item.', 'error');
                    } else {
                        window.location.href = data.url;
                    }
                },
                error: function (data) {
                    $.each(data.errors, function (key, value) {
                        // console.log(key);
                        alert(value);
                        $('.' + key + '_err').text(value);
                    });

                }
            });
        });
    });
    var warehouse = document.querySelector('#warehouse');
    var product_name = document.querySelector('#variant');
    var code = document.querySelector('#code');
    var options2 = product_name.querySelectorAll('option');
    var options3 = code.querySelectorAll('option');
    console.log(options3);
    // alert(product)
    function giveSelection(selValue) {
        variant.innerHTML='';
        code.innerHTML='';

        for(var i = 0; i < options2.length; i++) {
            if(options2[i].dataset.option === selValue) {
                variant.appendChild(options2[i]);
                code.appendChild(options3[i]);

            }
        }
    }
    giveSelection(warehouse.value);
    // window.onbeforeunload = closeWindow;
</script>