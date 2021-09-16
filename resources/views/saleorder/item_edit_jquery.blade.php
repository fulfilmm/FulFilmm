<script>
    $(document).on('change', 'input', function() {
        var quantity=$('#quantity_{{$order->id}}').val();
        var price=$('#price_{{$order->id}}').val();
        var total=quantity * price;
        var tax=$('#product_tax_{{$order->id}}').val();
        var tax_amount=tax / 100 * total;
        var include_tax=total + tax_amount;
        $('#total_{{$order->id}}').val(include_tax);

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