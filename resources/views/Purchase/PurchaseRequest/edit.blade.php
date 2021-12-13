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
                            @foreach($approvers as $approver)
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
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                        </thead>
                        <tbody id="tbody">
                        @foreach($items as $item)

                            <tr>
                                <td>
                                    <select name="[]" id="product{{$item->id}}" class="form-control select2">
                                        @foreach($product as $key=>$value)
                                            <option value="{{$key}}" {{$key==$item->product_id?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" id="qty{{$item->id}}" class="form-control" name="qty"
                                           value="{{$item->qty??''}}"></td>
                                <td><input type="number" id="price{{$item->id}}" class="form-control" name="price"
                                           value="{{$item->price??''}}"></td>
                                <td><input class="form-control" type="text" id="total{{$item->id}}"
                                           value="{{$item->total??''}}">
                                </td>
                                <td>
                                    <button type="button" id="item_save" class="btn btn-white btn-sm mt-1"><i
                                                class="fa fa-save"></i></button>
                                    <button type="button" id="delete" class="btn btn-danger btn-sm mt-1"><i
                                                class="fa fa-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach

                        <tr id="add_row">
                            <td>
                                <select name="[]" id="product" class="form-control select2">
                                    @foreach($product as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" id="qty" class="form-control" name="qty"></td>
                            <td><input type="number" id="price" class="form-control" name="price"></td>
                            <td><input class="form-control" type="text" id="total" value="">
                            </td>
                            <td>
                                <button type="button" id="item_save" class="btn btn-white btn-sm mt-1"><i
                                            class="fa fa-save"></i></button>
                                <button type="button" id="remove" class="btn btn-danger btn-sm mt-1"><i
                                            class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <button type="button" id="add" class="btn btn-white btn-sm">Add</button>
                            </td>
                        </tr>
                        </tbody>
                        <tr>
                            <td></td>
                            <td></td>

                            <th>Grand Total</th>

                            <td id="" colspan="2"><input class="form-control" type="text" name="total_cost"
                                                         id="grand_total" value="{{$grand_total}}">
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Attachment Files</label>
                    <input type="file" name="file[]" class="form-control" id="attach" multiple>
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
        $(document).on('click', '#item_save', function (event) {
            var supplier = $('#supplier option:selected').val();
            var approver = $('#approver option:selected').val();
            var deadline = $('#deadline').val();
            var description = $('#description').val();
            var product = $('#product option:selected').val();
            var qty = $('#qty').val();
            var price = $('#price').val();
            var total = $('#total').val();
            var creation_id = $('#creation_id').val();
            $.ajax({
                data: {
                    supplier_id: supplier,
                    approver_id: approver,
                    deadline: deadline,
                    desc: description,
                    product_id: product,
                    qty: qty,
                    price: price,
                    total: total,
                    pr_id:creation_id

                },
                type: 'POST',
                url: "{{url('/pr/item/add')}}",
                async: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    console.log(data);
                    $("#tbody").load(location.href + " #tbody>* ");
                    $("#grand_total").load(location.href + " #grand_total>* ");
                    selectRefresh();
                }
            });

        });
    </script>
@endsection