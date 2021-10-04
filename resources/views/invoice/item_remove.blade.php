<script>
    $(document).on('click','#remove{{$order->id}}',function () {
        $.ajax({
            type:'DELETE',
            url:"{{route('invoice_items.destroy',$order->id)}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                console.log(data);
                var alltotal=[];
                $('.total').each(function(){
                    alltotal.push(this.value);
                });
                var grand_total=0;
                for (var i=0;i<alltotal.length;i++){
                    grand_total=parseFloat(grand_total)+parseFloat(alltotal[i]);
                }
                $('#grand_total').val(grand_total);
                $("#order_table").load(location.href + " #order_table>* ");
                $("#grand_total_div").load(location.href + " #grand_total_div>* ");

            }
        });
    });
</script>