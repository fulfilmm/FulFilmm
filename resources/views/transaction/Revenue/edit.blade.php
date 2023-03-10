@extends('layout.mainlayout')
@section('title','Edit Revenue')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Revenue</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('transactions.index')}}">Transaction</a></li>
                        <li class="breadcrumb-item float-right">Edit Revenue</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <form method="POST" action="{{route('revenue.update',$revenue->id)}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate" enctype="multipart/form-data"
                  class="form-loading-button needs-validation">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$revenue->title}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="transaction_date" class="form-control" value="{{\Carbon\Carbon::parse($revenue->transaction_date)->format('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-money"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="amount" name="amount" value="{{$revenue->amount??''}}">
                                    <div class="input-group-prepend">
                                        <select name="currency" id="" class="select">
                                            <option value="MMK">MMK</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        @foreach($data['customers'] as $customer)
                                            <option value="{{$customer->id}}" {{$revenue->customer_id==$customer->id?'selected':''}}>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                    <select name="payment_method" id="payment_method" class="form-control " style="width: 90%">
                                        @foreach($data['payment_method'] as $payment_method)
                                            <option value="{{$payment_method}}" {{$revenue->payment_method==$payment_method?'selected':''}}>{{$payment_method}}</option>
                                        @endforeach
                                        <option value="Advance Payment"{{$revenue->payment_method=='Advance Payment'?'selected':''}}>Advance Payment</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="regional_cashier">Regional Cashier</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <select name="approver_id" id="regional_cashier" class="form-control " style="width: 90%">
                                        @foreach($data['emps'] as $emps)
                                            @if($emps->role->name=='Regional Cashier'&& $emps->region_id==\Illuminate\Support\Facades\Auth::guard('employee')->user()->region_id)
                                                <option value="{{$emps->id}}">{{$emps->name}}</option>
                                            @endif
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="cat_div">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <div class="input-group">
                                    <select name="category" id="category" class="form-control" style="width: 90%">
                                        @foreach($data['category'] as $cat)
                                            <option value="{{$cat->id}}" {{$revenue->category==$cat->id?'selected':''}}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label for="reference">Reference</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-file-text-o"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="reference" id="reference" value="{{$revenue->reference}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="revenue_description">Description</label>
                                <textarea name="description" id="revenue_description" cols="30" rows="5" class="form-control">
                                    {{$revenue->description}}
                                </textarea>
                            </div>
                        </div>

                        {{--<div class="col-md-6">--}}
                        {{--<label for="recurring">Recurring</label>--}}
                        {{--<div class="input-group">--}}
                        {{--<div class="input-group-prepend">--}}
                        {{--<span class="input-group-text"><i class="fa fa-refresh"></i></span>--}}
                        {{--</div>--}}
                        {{--<select name="recurring" id="recurring" class="form-control" style="width: 90%">--}}
                        {{--@foreach($data['recurring'] as $recurring)--}}
                        {{--<option value="{{$recurring}}">{{$recurring}}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="attach">Attachment</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-paperclip"></i></span>
                                    </div>
                                    <input type="file" name="attachment" class="form-control" id="attach">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row save-buttons">
                        <div class="col-md-12"><a href="{{url('revenue')}}')}}"
                                                  class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                        class="btn-inner--text">Save</span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
@endsection