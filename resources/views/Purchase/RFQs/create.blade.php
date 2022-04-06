@extends('layout.mainlayout')
@section('title','RFQs Create')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">RFQs Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">RFQs</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('rfqs.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <select name="vendor_id" id="supplier" class="form-control select2">
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{isset($rfq_data)?($rfq_data[0]['supplier_id']==$supplier->id?'selected':''):''}}>{{$supplier->name}}</option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                {{--                @dd()--}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Purchase Type</label>
                        <select name="type" id="type" class="select2">
                            <option value="Re-Sale" {{isset($rfq_data)?($rfq_data[0]['type']=='Re-Sale'?'selected':''):''}}>Re-Sale</option>
                            <option value="Office Use" {{isset($rfq_data)?($rfq_data[0]['type']=='Office Use'?'selected':''):''}}>Office Use</option>
                        </select>
                        @error('type')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Deadline</label>
                        <input type="date" name="deadline" id="deadline" class="form-control" value="{{$rfq_data[0]['deadline']??''}}" >

                        @error('deadline')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Vendor Reference</label>
                        <input type="text" class="form-control" name="vendor_reference" id="vendor_ref" value="{{$rfq_data[0]['vendor_ref']??''}}">
                        @error('vendor_reference')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="">Source</label>
                    <select name="source" id="source" class="select2 form-control">
                        <option value="">None</option>
                        @foreach($pr as $key=>$val)
                        <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                    </select>
                    @error('source')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Receipt Date</label>
                        <input type="date" class="form-control" name="receive_date" id="received_date" value="{{$rfq_data[0]['received_date']??''}}">
                        @error('receive_date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Tag</label>
                        <select name="tag[]" id="tag" class="form-control select2" multiple>
                            @foreach($emps as $key=>$val )
                                @if(isset($rfq_data[0]['emp']))
                                    <option value="{{$key}}" @foreach($rfq_data[0]['emp'][0] as $index=>$item) {{$item==$key?'selected':''}} @endforeach>{{$val}}</option>
                                @else
                                    <option value="{{$key}}">{{$val}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('tag')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <label for="">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{$rfq_data[0]['desc']??''}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

            </div>
            <input type="hidden" id="creation_id" value="{{$creation_id[0]}}">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <th scope="col" style="min-width: 200px;">Product</th>
                        <th scope="col">Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="tbody">
                        @foreach($items as $item)

                            <tr>
                                <td>
                                    {{$item->product->name}}
                                </td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->qty??''}}</td>
                                <td>{{$item->unit}}</td>
                                <td>{{$item->price??''}}</td>
                                <td>{{$item->total??''}}
                                </td>
                                <td style="min-width: 60px;">
                                    <div class="row">
                                        <button type="button" data-toggle="modal" data-target="#edit{{$item->id}}"
                                                class="btn btn-success btn-sm mt-1"><i
                                                    class="fa fa-edit"></i></button>
                                        <button type="button" id="delete_{{$item->id}}"
                                                class="btn btn-danger btn-sm mt-1"><i
                                                    class="fa fa-minus"></i></button>
                                        <div id="edit{{$item->id}}" class="modal custom-modal fade" role="dialog">
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
                                                                    <select name="[]" id="product{{$item->id}}"
                                                                            class="form-control select2 update{{$item->id}}">
                                                                        @foreach($product as $key=>$value)
                                                                            <option value="{{$key}}" {{$key==$item->product_id?'selected':''}}>{{$value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label for="" class="col-md-3">Description</label>
                                                                <div class="col-md-9">
                                                                    <textarea name="" id="desc{{$item->id}}" cols="30" rows="2"
                                                                              class="form-control col-md-8 update{{$item->id}}">{{$item->description}}</textarea>
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
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="unit{{$item->id}}" value="{{$item->unit??''}}">
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
                                                        <button id="update_item{{$item->id}}" data-dismiss="modal"
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
                                            var product = $('#product{{$item->id}} option:selected').val();
                                            var qty=$('#qty{{$item->id}}').val();
                                            var price = $('#price{{$item->id}}').val();
                                            var total = $('#total{{$item->id}}').val();
                                            var unit=$('#unit{{$item->id}}').val();
                                            $.ajax({
                                                data: {
                                                    description: description,
                                                    product_id: product,
                                                    qty:qty,
                                                    price: price,
                                                    total:total,
                                                    unit:unit

                                                },
                                                type: 'POST',
                                                url: "{{url('/rfq/item/update/'.$item->id)}}",
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
                                                url: "{{url('/rfq/item/delete')}}",
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
                                    <option value="" selected>Select Product</option>
                                    @foreach($product as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
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
                        </tr>
                        <tr>
                            <td><input type="hidden"></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="attach">Attachment File</label>
                    <input type="file" class="form-control" name="attach[]" multiple>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).ready(function () {
            $('input').keyup(function () {
                var quantiy = $('#qty').val();
                var price = $('#price').val();
                var total = quantiy * price;
                $('#total').val(total);
            });
        });

        function loadlink() {
            $('#links').load('head.blade.php', function () {
                $(this).unwrap();
            });
        }

        $(document).on('change', '#product', function (event) {
            var emp =new Array();
            $("#tag").each(function () {
                // console.log($(this).val()); //works fine
                emp.push($(this).val());
            });
            var supplier = $('#supplier option:selected').val();
            var approver = $('#approver option:selected').val();
            var deadline = $('#deadline').val();
            var desc = $('#description').val();
            var description = $('#desc').val();
            var product = $('#product option:selected').val();
            var price = $('#price').val();
            var type=$('#type option:selected').val();
            var creation_id = $('#creation_id').val();
            var vendor_ref=$('#vendor_ref').val();
            var received_date=$('#received_date').val();
            var source=$('#source option:selected').val();
            $.ajax({
                data: {
                    supplier_id: supplier,
                    approver_id: approver,
                    deadline: deadline,
                    description: description,
                    product_id: product,
                    qty: 1,
                    price: price,
                    total: 0,
                    creation_id: creation_id,
                    desc: desc,
                    type:type,
                    vendor_ref:vendor_ref,
                    received_date:received_date,
                    source:source,
                    unit:'PCS',
                    emp:emp

                },
                type: 'POST',
                url: "{{url('/rfq/item/add')}}",
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
@endsection