@extends('layout.mainlayout')
@section('title','Bill Create')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Bill</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Invoice</li>
                        <li class="breadcrumb-item float-right">New</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-sm-12">
                <form action="{{route('bills.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title">
                                <span class="text-danger title_err"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="payment">Payment Type</label>
                                <select name="payment_method" id="payment" class="form-control">
                                    <option value="Cash">
                                        Cash
                                    </option>
                                    <option value="Bank" >
                                        Bank
                                    </option>
                                    <option value="KBZ Pay">
                                        KBZPay
                                    </option>
                                    <option value="Wave Money">
                                        Wave Money
                                    </option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="creation_id" name="creation_id" class="form-control" value="{{$request_id[0]}}" readonly>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="bill_date">Bill date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="bill_date"  id="bill_date" >

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                <input class="form-control" name="due_date" type="date" id="due_date">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="vendor_id">Vendor <span class="text-danger">*</span></label>
                                <input type="text"  id="vendor_id" class="form-control" value="{{$vendor->name}}" readonly>
                                <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label for="vendor_email">Email</label>
                                <input class="form-control" type="email" name="vendor_email" id="vendor_email"
                                       value="{{$vendor->email}}" required>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="vendor_address">Address <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" id="vendor_address" name="vendor_address"
                                       value="{{$vendor->address??''}}">
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label for="bill_address">Billing Address <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" id="bill_address" name="billing_address"
                                       value="{{$vendor->address??''}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Other Information</label>
                                <textarea class="form-control" id="more_info" name="other_info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row border-top">

                        <div class="col-md-12 col-sm-12">
                            <h4 class="mt-3">Billing Items</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <th scope="col" style="min-width: 200px;">Item ID</th>
                                    <th scope="col">Description</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody id="tbody">
                                    @foreach($items as $item)

                                        <tr>
                                            <td>
                                                <a href="{{route('deliveries.show',$item->delivery->id)}}">
                                                    {{$item->delivery->delivery_id}}
                                                </a>
                                            </td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->amount??''}}
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
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <label for="item_id{{$item->id}}" class="col-md-3">Item ID</label>
                                                                            <div class="col-md-9">
                                                                                <input type="text" name="item_id" id="item_id{{$item->id}}" class="form-control" value="{{$item->po_id!=null?$item->purchaseorder->purchaseorder_id:$item->delivery->delivery_id}}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <label for="desc{{$item->id}}" class="col-md-3">Description</label>
                                                                            <div class="col-md-9">
                                                                    <textarea name="" id="desc{{$item->id}}" cols="30" rows="2"
                                                                              class="form-control col-md-8 update{{$item->id}}">{{$item->description}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <label for="total{{$item->id}}" class="col-md-3">Total</label>
                                                                            <div class="col-md-9">
                                                                                <input class="form-control" type="text"
                                                                                       id="total{{$item->id}}"
                                                                                       value="{{$item->amount??''}}">
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
                                                        var total = $('#total{{$item->id}}').val();
                                                        $.ajax({
                                                            data: {
                                                                description: description,
                                                                total:total

                                                            },
                                                            type: 'POST',
                                                            url: "{{url('bill/item/update/'.$item->id)}}",
                                                            async: false,
                                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                            success: function (data) {
                                                                console.log(data);
                                                                location.reload();
                                                                selectRefresh();
                                                            }
                                                        });

                                                    });
                                                    $(document).on('click', '#delete_{{$item->id}}', function (event) {
                                                        // alert('hello');
                                                        $.ajax({
                                                            type: 'GET',
                                                            url: "{{url('bill/item/delete/'.$item->id)}}",
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

                                    <tr>
                                        <td colspan="3" class="text-right">Grand Total</td>
                                        <td colspan="2"><input type="number" class="form-control" id="grand_total" name="grand_total" value="{{$grand_total??0}}"></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    {{--                            <input type="hidden" id="generate_id" value="{{$generate_id}}">--}}
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" id="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <script>
        function selectRefresh() {
            $('.select2').select2({
                tags: true,
                allowClear: true,
                width: '100%'
            });
        }
    </script>
@endsection