@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Request Edit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Purchase Request</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('purchase_request.update',$prs->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Supplier</label>
                        <select name="vendor_id" id="supplier" class="form-control select2">
                            @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{$prs->vendor_id==$supplier->id?'selected':''}}>{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Approver</label>
                        <select name="approver_id" id="approver" class="form-control select2">
                            @foreach($emps as $approver)
                                @if($approver->role->name=='Manager'||$approver->role->name=='CEO')
                                    <option value="{{$approver->id}}" {{$prs->approver_id==$approver->id?'selected':''}}>{{$approver->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Purchase Type</label>
                        <select name="type" id="type" class="select2">
                            <option value="Re-Sale" {{$prs->type=='Re-Sale'?'selected':''}}>Re-Sale</option>
                            <option value="Office Use" {{$prs->type=='Office Use'?'selected':''}}>Office Use</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Deadline</label>
                        <input type="date" name="deadline" id="deadline" class="form-control" value="{{\Carbon\Carbon::parse($prs->deadline)->format('Y-m-d')}}">
                    </div>
                </div>

                <div class="col-12">
                    <label for="">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{$prs->description}}</textarea>
                </div>

            </div>
            <input type="hidden" id="creation_id" value="{{$prs->id}}">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <th scope="col" style="min-width: 200px;">Product</th>
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
                                <td>{{$item->unit??''}}</td>
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
                                                                              class="form-control update{{$item->id}}">{{$item->description}}</textarea>
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
                                                                    <input type="text" id="unit{{$item->id}}"
                                                                           class="form-control update{{$item->id}}"
                                                                           name="unit"
                                                                           value="{{$item->unit??''}}"></div>
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
                                                url: "{{url('/pr/item/update/'.$item->id)}}",
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
                                                url: "{{url('/pr/item/delete')}}",
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
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td colspan="7">
                                <button type="button" id="add" class="btn btn-white btn-sm">Add</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Tag</label>
                    <select name="tag[]" id="tag" class="form-control select2" multiple>
                        @foreach($emps as $emp )
                            <option value="{{$emp->id}}" @foreach($pr_followers as $item) {{$item->emp_id==$emp->id?'selected':''}} @endforeach>{{$emp->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Attachment Files</label>
                    <input type="file" name="file[]" class="form-control" id="attach" value="@foreach($attach as $item){{url(asset('attach_file/'.$item))}} @endforeach" multiple >
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
                $('#grand_total').val(parseInt(total) + parseInt({{$grand_total??0}}));
            });
        });
        $(document).on('change', '#product', function (event) {
            var product = $('#product option:selected').val();
            var price = $('#price').val();
            var creation_id = $('#creation_id').val();
            $.ajax({
                data: {
                    edit:'update',
                    product_id: product,
                    qty: 1,
                    price: price,
                    total: 0,
                    creation_id: creation_id,
                    pr_id:creation_id,
                    unit:'PCS'

                },
                type: 'POST',
                url: "{{url('/pr/item/add')}}",
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