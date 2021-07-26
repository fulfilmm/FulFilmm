<div class="modal custom-modal rounded" id="edit{{$order->id}}">
    <div class="modal-dialog modal-md " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Order Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container scoll" >
                <div class="modal-body">
                    <input type="hidden" id="order_id_{{$order->id}}" value="{{$order->id}}">
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Product</label>
                               <select name="" id="edit_product_{{$order->id}}" class="form-control">
                                   <option value="">Select Product</option>
                                   @foreach($products as $product)
                                       @if($product->id==$order->product_id)
                                           <option value="{{$product->id}}" selected>{{$product->name}}</option>
                                       @else
                                           <option value="{{$product->id}}">{{$product->name}}</option>
                                       @endif
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Price</label>
                               <input type="number" id="edit_price_{{$order->id}}" class="form-control " value="{{$order->unit_price}}">
                           </div>
                       </div>
                   </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="number" name="hello" id="edit_quantity_{{$order->id}}" class="form-control " value="{{$order->quantity}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Currency Unit</label>
                                <input type="text" class="form-control" id="edit_unit{{$order->id}}" value="{{$order->currency_unit}}"></td>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Discount</label>
                                <input type="number" name="discount" id="edit_discount{{$order->id}}" class="form-control" value="{{$order->discount}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Discount Type</label>
                                <select name="" id="edit_discount_type{{$order->id}}" class="form-control">
                                    <option value="%">%</option>
                                    <option value="amount">Amount</option>
                                </select>
                            </div>
                        </div>

                    </div>
                   <div class="row">

                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Product Tax</label>
                               <input type="text" class="form-control" name="tax" id="edit_product_tax_{{$order->id}}" value="{{$order->tax_id}}"></td>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="">Total Cost</label>
                               <input type="number" name="total" id="edit_total_{{$order->id}}" class="form-control" value="{{$order->total}}">
                           </div>
                       </div>

                   </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="for">Description</label>
                                <textarea name="description" id="edit_order_description_{{$order->id}}" class="form-control" >
                             {{$order->description}}
                            </textarea>
                            </div>
                        </div>
                    </div>






                    <script>
                        //order update
                        $(document).on('change', 'input', function() {
                            var quantity=$('#edit_quantity_{{$order->id}}').val();
                            var price=$('#edit_price_{{$order->id}}').val();
                            var total=quantity * price;
                            var tax=$('#edit_product_tax_{{$order->id}}').val();
                            var tax_amount=tax / 100 * total;
                            var include_tax=total + tax_amount;
                            var discount=$('#discount_{{$order->id}}').val();
                            var discount_type=$('#edit_discount_type{{$order->id}} option:selected').val();
                            var total_amount=0;
                            if(discount_type=='amount') {
                                total_amount = include_tax - discount;
                            }else {
                                var discount_amount = (discount / 100) * include_tax;
                                total_amount=include_tax-discount_amount;
                            }
                            $('#edit_total_{{$order->id}}').val(total_amount);

                        });
                        $(document).on('change','#edit_product_{{$order->id}}',function (){
                            var product_id=$("#edit_product_{{$order->id}} option:selected").val();
                            @foreach($products as $product )
                            var p_id={{$product->id}}
                            if(p_id==product_id)
                            {
                                var tax = {{$product->taxes->rate}};
                                var price = {{$product->sale_price}};
                                $('#edit_product_tax_{{$order->id}}').val(tax);
                                $('#edit_price_{{$order->id}}').val(price);
                            }
                            @endforeach
                            var quantity=$('#edit_quantity_{{$order->id}}').val();
                            var price=$('#edit_price_{{$order->id}}').val();
                            var total=quantity * price;
                            var tax=$('#edit_product_tax_{{$order->id}}').val();
                            var tax_amount=tax / 100 * total;
                            var include_tax=total + tax_amount;
                            $('#edit_total_{{$order->id}}').val(include_tax);
                        });
                        $(document).ready(function() {
                            $(document).on('click', "#update_order_{{$order->id}}", function () {
                                // alert("hello");

                                var desc=$('#edit_order_description_{{$order->id}}').val();
                                var quantity=$('#edit_quantity_{{$order->id}}').val();
                                var price=$('#edit_price_{{$order->id}}').val();
                                var tax=$('#edit_product_tax_{{$order->id}}').val();
                                var total=$('#edit_total_{{$order->id}}').val();
                                var order_id=$('#order_id_{{$order->id}}').val();
                                var product=$('#edit_product_{{$order->id}} option:selected').val();
                                // alert(product);
                                $.ajax({
                                    data : {
                                        product_id:product,
                                        description:desc,
                                        quantity:quantity,
                                        price:price,
                                        tax:tax,
                                        total:total,
                                        order_id:order_id,
                                    },
                                    type:'POST',
                                    url:"{{route('orders.update',$order->id)}}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success:function(data){
                                        console.log(data);
                                        // $("#home").load(location.href + " #home>* ");

                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
