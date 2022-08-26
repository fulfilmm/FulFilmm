@extends('layout.mainlayout')
@section('title','Purchase Order')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Order Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="{{route('purchase_request.index')}}">RFQs</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('purchaseorders.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow">
                <div class="col-12 my-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" name="po_id" value="{{$po_id}}">
                            <div class="form-group">
                                <label for="">Vendor</label>
                                <select name="vendor_id" id="supplier" class="form-control select2">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}" {{isset($po_data)?($po_data[0]['supplier_id']==$supplier->id?'selected':''):(isset($rfq)?($rfq->vendor_id==$supplier->id?'selected':''):'')}}>{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Purchase Type</label>
                                <select name="purchase_type" id="type" class="select2">
                                    <option value="Re-Sale" {{isset($po_data)?($po_data[0]['type']=='Re-Sale'?'selected':''):''}}>
                                        Re-Sale
                                    </option>
                                    <option value="Office Use" {{isset($po_data)?($po_data[0]['type']=='Office Use'?'selected':''):''}}>
                                        Office Use
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ordered_date">Ordered Date</label>
                                <input type="date" name="ordered_date" id="ordered_date" class="form-control"
                                       value="{{$po_data[0]['ordered_date']??''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Vendor Reference</label>
                                <input type="text" class="form-control" name="vendor_reference" id="vendor_ref"
                                       value="{{$po_data[0]['vendor_ref']??''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">PR Source</label>
                            <select name="pr_id" id="source" class="select2 form-control">
                                <option value="">None</option>
                                @foreach($source as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">RFQ Source</label>
                            <select name="rfq_id" id="source" class="select2 form-control">
                                <option value="">None</option>
                                @foreach($rfqs as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Expected Arrival</label>
                                <input type="date" class="form-control" name="deadline" id="received_date"
                                       value="{{$po_data[0]['received_date']??''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ship">Ship To</label>
                                <input type="text" class="form-control" id="ship_to" name="ship_to"
                                       value="{{$po_data[0]['ship_to']??''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Approver</label>
                                <select name="approver_id" id="approver" class="form-control select2" >
                                    @foreach($emps as $emp )
                                        @if($emp->role->name=='Manager'||$emp->role->name=='CEO')
                                            @if(isset($po_data[0]['approver']))
                                                <option value="{{$emp->id}}" {{$po_data[0]['approver']=$emp->id?'selected':''}} >{{$emp->name}}</option>
                                            @else
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tag</label>
                                <select name="tag[]" id="tag" class="form-control select2" multiple>
                                    @foreach($emps as $emp )
                                        @if(isset($po_data[0]['emp']))
                                            <option value="{{$emp->id}}" @foreach($po_data[0]['emp'][0] as $index=>$item) {{$item==$emp->id?'selected':''}} @endforeach>{{$emp->name}}</option>
                                        @else
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5"
                                      class="form-control">{{$po_data[0]['desc']??''}}</textarea>
                        </div>
                        <input type="hidden" name="emp_id"
                               value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">

                    </div>
                    <input type="hidden" id="creation_id" value="{{$creation_id[0]}}">
                    <div class="row mt-5">
                        <div class="col-12" style="overflow: auto;">
                            <table class="table">
                                <thead>
                                <th scope="col" style="min-width: 200px;">Product</th>
                                <th scope="col">Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th>Total</th>
                                <th>Action</th>
                                </thead>
                                <tbody id="tbody">
                                @foreach($items as $item)

                                    <tr>
                                        <td>
                                            @foreach($product as $prd)
                                                @if($prd->id==$item->variant_id)
                                                    {{$prd->product_name}}
                                                    {{$prd->variant??''}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{!! $item->description !!}</td>
                                        <td>{{$item->qty??''}}</td>
                                        <td>{{$item->price??''}}</td>
                                        <td>{{$item->product_unit->unit??''}}</td>
                                        <td>{{$item->total??''}}
                                        </td>
                                        <td style="min-width: 60px;">
                                            <div class="row">
                                                <button type="button" data-toggle="modal"
                                                        data-target="#edit{{$item->id}}"
                                                        class="btn btn-success btn-sm mt-1"><i
                                                            class="fa fa-edit"></i></button>
                                                <button type="button" id="delete_{{$item->id}}"
                                                        class="btn btn-danger btn-sm mt-1 "><i
                                                            class="fa fa-minus"></i></button>
                                                <div id="edit{{$item->id}}" class="modal custom-modal fade"
                                                     role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Item</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <label class="col-md-3">Product</label>
                                                                        <div class="col-md-9">
                                                                            <select name="" id="product{{$item->id}}"
                                                                                    class="form-control select2 update{{$item->id}}">
                                                                                <option value="{{$item->product->product_id}}">{{$item->product->product_name}}{{$item->product->variant}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label for=""
                                                                               class="col-md-3">Description</label>
                                                                        <div class="col-md-9">
                                                                    <textarea name="" id="desc{{$item->id}}" cols="30"
                                                                              rows="2"
                                                                              class="form-control update{{$item->id}}"> {!! $item->description  !!}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label for="" class="col-md-3">Qty</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" id="qty{{$item->id}}"
                                                                                   class="form-control update{{$item->id}}"
                                                                                   name="qty"
                                                                                   value="{{$item->qty??''}}"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label for="" class="col-md-3">Unit</label>
                                                                        <div class="col-9">
                                                                            <select name="unit" id="unit{{$item->id}}" class="form-control select2">
                                                                               @foreach($units as $p_unit)
                                                                              @if($item->product->product_id==$p_unit->product_id)
                                                                                <option value="{{$p_unit->id}}" {{$item->unit==$p_unit->id?'selected':''}}>{{$p_unit->unit}}</option>
                                                                                @endif
                                                                                   @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label for="" class="col-md-3">Price</label>
                                                                        <div class="col-md-9">
                                                                            <input type="number" id="price{{$item->id}}"
                                                                                   class="form-control update{{$item->id}}"
                                                                                   name="price"
                                                                                   value="{{$item->price??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <label for="" class="col-md-3">Total</label>
                                                                        <div class="col-md-9">
                                                                            <input class="form-control" type="text"
                                                                                   id="total{{$item->id}}"
                                                                                   value="{{$item->total??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button id="update_item{{$item->id}}"
                                                                        data-dismiss="modal"
                                                                        class="btn btn-primary float-right">Save
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <script>
                                                $(document).on('click', '#update_item{{$item->id}}', function (event) {
                                                    var description = $('#desc{{$item->id}}').val();
                                                    var unit = $('#unit{{$item->id}} option:selected').val();
                                                    var qty = $('#qty{{$item->id}}').val();
                                                    var price = $('#price{{$item->id}}').val();
                                                    var total = $('#total{{$item->id}}').val();
                                                    $.ajax({
                                                        data: {
                                                            description: description,
                                                            qty: qty,
                                                            price: price,
                                                            total: total,
                                                            unit: unit,

                                                        },
                                                        type: 'POST',
                                                        url: "{{url('/po/item/update/'.$item->id)}}",
                                                        async: false,
                                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                        success: function (data) {
                                                            console.log(data);
                                                            location.reload();
                                                            selectRefresh();
                                                        }
                                                    });

                                                });
                                                $(document).ready(function () {
                                                    $('.update{{$item->id}}').keyup(function () {
                                                        var quantiy = $('#qty{{$item->id}}').val();
                                                        var price = $('#price{{$item->id}}').val();
                                                        var total = quantiy * price;
                                                        $('#total{{$item->id}}').val(total);
                                                    });
                                                });
                                                $(document).on('click', '#delete_{{$item->id}}', function (event) {
                                                    // alert('hello');
                                                    $.ajax({
                                                        data: {
                                                            item_id: "{{$item->id}}"

                                                        },
                                                        type: 'POST',
                                                        url: "{{url('/po/item/delete')}}",
                                                        async: false,
                                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                        success: function (data) {
                                                            console.log(data);
                                                            location.reload();
                                                            selectRefresh();
                                                        }
                                                    });

                                                });
                                            </script>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr id="add_row">
                                    <td>
                                        <select name="[]" id="product" class="form-control select2 item_save">
                                            <option value="" selected>Item Code/Product Name</option>
                                            @foreach($product as $prod)
                                                <option value="{{$prod->id}}">{{$prod->product_name}} / {{$prod->item_code??''}}

                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" id="remove" class="btn btn-danger btn-sm mt-1"><i
                                                    class="fa fa-close"></i></button>

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" id="add" class="btn btn-white btn-sm">Add</button>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Subtotal</td>
                                    <td colspan="2"><input type="number" class="form-control" id="subtotal"
                                                           name="subtotal" value="{{$grand_total??0}}"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Discount</td>
                                    <td colspan="2"><input type="number" id="discount" class="form-control"
                                                           name="discount" value="0"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Tax</td>
                                    <td colspan="2">
                                        <select name="tax_id" id="tax" class="form-control select2">
                                            @foreach($taxes as $tax)
                                                <option value="{{$tax->id}}">{{$tax->name}} ({{$tax->rate}} %)</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" class="form-control" id="tax_amount" name="tax_amount"
                                               value="0"></td>
                                    <td><input type="hidden" id="add_cost" class="form-control"
                                               name="additional_cost" value="0"></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Grand Total</td>
                                    <td colspan="2"><input type="number" class="form-control" id="grand_total"
                                                           name="grand_total" value="{{$grand_total??0}}"></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="attach">Attachment</label>
                            <input type="file" class="form-control" name="attach[]" multiple>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <script>
        function selectRefresh() {
            $('.select2').select2({
                tags: true,
                allowClear: true,
                width: '100%'
            });
        }

        $(document).ready(function () {
            selectRefresh();
        });
        $(document).ready(function () {
            $('#add_row').hide();
        });
        $(document).on('click', '#add', function () {
            $('#add_row').show();
        });
        $(document).on('click', '#remove', function () {
            $('#add_row').hide();
        });
        $('input').keyup(function () {
            var tax = $('#tax option:selected').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}")
                var tax_rate = "{{$tax->rate}}";
                    @endforeach
            var total = $('#subtotal').val();
            var tax_amount = parseFloat(total) * (tax_rate / 100);
            var tax_include = parseFloat(total) + tax_amount;
            var discount = $('#discount').val();
            var add_cost = $('#add_cost').val();
            var grand = (tax_include - discount) + parseFloat(add_cost);
            $('#grand_total').val(parseFloat(grand));
            $('#tax_amount').val(tax_amount);
        });
        $(document).on('change', '#tax', function () {
            var tax = $('#tax option:selected').val();
            @foreach($taxes as $tax)
            if (tax == "{{$tax->id}}") {
                var tax_rate = "{{$tax->rate}}";
            }
            @endforeach;
            var total = document.getElementById('subtotal').value;
            var tax_amount = parseFloat(total) * (tax_rate / 100);
            var tax_include = parseFloat(total) + tax_amount;
            var discount = $('#discount').val();
            var grand = (tax_include - discount);
            $('#grand_total').val(grand);
            $('#tax_amount').val(tax_amount);
        });
        $(document).on('change', '#product', function (event) {
            var emp = new Array();
            $("#tag").each(function () {
                // console.log($(this).val()); //works fine
                emp.push($(this).val());
            });
            var supplier = $('#supplier option:selected').val();
            var deadline = $('#deadline').val();
            var desc = $('#description').val();
            var description = $('#desc').val();
            var product = $('#product option:selected').val();
            var price = $('#price').val();
            var type = $('#type option:selected').val();
            var creation_id = $('#creation_id').val();
            var vendor_ref = $('#vendor_ref').val();
            var received_date = $('#received_date').val();
            var source = $('#source option:selected').val();
            var ship_to = $('#ship_to').val();
            var approver=$('#approver option:selected').val();
            var ordered_date=$('#ordered_date').val();
            $.ajax({
                data: {
                    supplier_id: supplier,
                    deadline: deadline,
                    description: description,
                    variant_id: product,
                    qty: 1,
                    price: price,
                    total: 0,
                    creation_id: creation_id,
                    desc: desc,
                    type: type,
                    vendor_ref: vendor_ref,
                    received_date: received_date,
                    source: source,
                    emp: emp,
                    ship_to: ship_to,
                    approver:approver,
                    ordered_date:ordered_date

                },
                type: 'POST',
                url: "{{url('/po/item/add')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    if (!$.isEmptyObject(data.error)) {
                        // alert(data.orderempty);
                        swal('Fixed Product Unit', 'This product does not fixed unit.', 'error');
                    }else {
                        location.reload();
                        selectRefresh();
                    }
                }
            });

        });
    </script>
@endsection