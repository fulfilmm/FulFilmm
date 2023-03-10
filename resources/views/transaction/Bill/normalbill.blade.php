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

        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-5">
                    <form action="{{route('bills.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{old('title')}}">
                                    @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" name="grand_total" id="amount" value="{{old('grand_total')}}">
                                    @error('grand_total')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="cat">Category</label>
                                    <select name="category" id="" class="form-control select">
                                        @foreach($category as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="payment">Payment Type</label>
                                    <select name="payment_method" id="payment" class="form-control select2">
                                        <option value="Cash" {{isset($po_to_bill)?'':(isset($order_data)?($order_data->payment_method=='Cash'?'selected':''):($data!=null?($data[0]['payment']?'selected':''):''))}}>
                                            Cash
                                        </option>
                                        <option value="Bank" {{isset($po_to_bill)?'':(isset($order_data)?($order_data->payment_method=='Bank'?'selected':''):($data!=null?($data[0]['payment']?'selected':''):''))}}>
                                            Bank
                                        </option>
                                        <option value="KBZ Pay" {{isset($po_to_bill)?'':(isset($order_data)?($order_data->payment_method=='KBZ Pay'?'selected':''):($data!=null?($data[0]['payment']?'selected':''):''))}}>
                                            KBZPay
                                        </option>
                                        <option value="Wave Money" {{isset($po_to_bill)?'':(isset($order_data)?($order_data->payment_method=='Wave Money'?'selected':''):($data!=null?($data[0]['payment']?'selected':''):''))}}>
                                            Wave Money
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="creation_id" name="creation_id" class="form-control" value="{{$request_id[0]}}" readonly>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inv_date">Invoice Date</label>
                                    <input type='date' class="form-control" id="inv_date" name="invoice_date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inv_id">Invoice ID</label>
                                    <input type="text" class="form-control" name="invoice_id" placeholder="Enter Invoice ID">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="bill_date">Bill date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="bill_date"  id="bill_date" value="{{isset($po_to_bill)?'':(isset($data[0]['billing_date'])?$data[0]['billing_date']:\Carbon\Carbon::today()->format('Y-m-d'))}}">
                                    @error('bill_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input class="form-control" name="due_date" type="date" id="due_date" value="{{isset($po_to_bill)?'':(isset($data[0]['due_date'])?$data[0]['due_date']:\Carbon\Carbon::today()->addDay(1)->format('Y-m-d'))}}">
                                    @error('due_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="vendor_id">Vendor <span class="text-danger">*</span></label>
                                    <select name="vendor_id" id="vendor_id" class="form-control select2" onchange="giveSelection(this.value)">
                                        @foreach($vendor as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="vendor_email">Email</label>
                                    <input class="form-control" type="email" name="vendor_email" id="vendor_email" value="{{old('vendor_email')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="vendor_address">Address <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" id="vendor_address" name="vendor_address"
                                           value="{{old('vendor_addrss')??''}}">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="bill_address">Billing Address <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" id="bill_address" name="billing_address"
                                           value="{{old('billing_address')??''}}">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="po">PO ID</label>
                                    <input type="text" class="form-control" id="po" name="po_id">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Attach</label>
                                    <input type="file" class="form-control" name="attach">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Other Information</label>
                                    <textarea class="form-control" id="more_info" name="other_info">{{isset($po_to_bill)?'':($data[0]['more_info']??'')}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn" type="submit" id="save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Page Content -->
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
        function giveSelection(id) {
            @foreach($vendor as $item)
            if(id=='{{$item->id}}'){
                $('#vendor_email').val('{{$item->email}}');
                $('#vendor_address').val('{{$item->address??''}}');
                $('#bill_address').val('{{$item->address??''}}');
            }
            @endforeach
        }

    </script>
@endsection