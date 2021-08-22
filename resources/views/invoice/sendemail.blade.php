@extends('layout.mainlayout')
@section('title','Invoice Email Sending Prepare ')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Invoice Mail</h3>
                </div>
            </div>
        </div>
                <!-- /Page Header -->

        <div class="row ">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <form action="{{route('send')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row my-3">
                                <div class="col-sm-4 m-b-20">
                                    <img src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" class="inv-logo avatar" alt="logo" >
                                </div>
                                <div class="col-sm-2">
                                    <h3>{{$company->name ?? ''}}</h3>
                                    <strong>Address: <i> {{$company->address}}</i></strong>
                                </div>
                                <div class="col-sm-6 m-b-20">
                                    <div class="invoice-details">
                                        <h3 class="text-uppercase">Invoice #{{$detail_inv->invoice_id}}</h3>
                                        <ul class="list-unstyled">
                                            <li>Date: <span>{{\Illuminate\Support\Carbon::parse($detail_inv->invoice_date)->toFormattedDateString()}}</span></li>
                                            <li>Due date: <span>{{\Illuminate\Support\Carbon::parse($detail_inv->due_date)->toFormattedDateString()}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-6 col-xl-6 m-b-20">
                                    <h5>Invoice to:</h5>
                                    <ul class="list-unstyled">
                                        <li><strong>Name&nbsp:&nbsp</strong><span>{{$detail_inv->customer->name}}</span></li>
                                        <li><span><strong>Company&nbsp:&nbsp</strong>{{$detail_inv->customer->company->name}}</span></li>
                                        <li><strong>Address&nbsp:&nbsp</strong>{{$detail_inv->customer->address}}</li>
                                        <li><strong>Phone&nbsp:&nbsp</strong>{{$detail_inv->customer->phone}}</li>
                                        <li><strong>Email&nbsp:&nbsp</strong><a href="#">{{$detail_inv->customer->email}}</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 col-lg-6 col-xl-6 m-b-20">
                                    <h5>Invoice From:</h5>
                                    <ul class="list-unstyled">
                                        <li><span>Company Name&nbsp:&nbsp</span><strong>{{$company->name??''}}</strong></li>
                                        <li><span>{{$company->address?'Address :':''}}</span><strong>{{$company->address??''}}</strong></li>
                                        <li><span>{{$company->phone?'Phone :':''}}</span><strong>{{$company->phone??''}}</strong></li>
                                        <li><span>{{$company->email?'Email :':''}}</span><strong>{{$company->address??''}}</strong></li>
                                        <li><span>{{$company->web_link?'Website :':''}}</span><strong>{{$company->web_link??''}}</strong></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ITEM</th>
                                        <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                        <th>UNIT COST</th>
                                        <th>Tax(%)</th>
                                        <th>Discount</th>
                                        <th>Discount Type</th>
                                        <th>QUANTITY</th>
                                        <th class="text-right">TOTAL</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice_item as $item)
                                        <tr>
                                            {{--                                                    @dd($item->tax)--}}
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->product->name}}</td>
                                            <td class="d-none d-sm-table-cell">{{$item->description}}</td>
                                            <td>{{$item->unit_price}}
                                            <td>{{$item->tax_id}}%</td>
                                            <td>{{$item->discount}}</td>
                                            <td>{{$item->discount_type}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td class="text-right">{{$item->total}}</td>
                                            <td class="text-right">{{$item->currency_unit}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <div class="row invoice-payment">
                                    <div class="col-sm-7">
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="m-b-20">
                                            <div class="table-responsive no-border">
                                                <table class="table mb-0">
                                                    <tbody>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td class="text-right text-primary"><h5>{{$grand_total}}</h5>{{$invoice_item[0]->currency_unit}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-info">
                                    <h5>Other information</h5>
                                    <p class="text-muted">{{$detail_inv->other_information}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                <input type="hidden" name="email" value="{{$detail_inv->customer->email}}">
                                <input type="hidden" name="inv_id" value="{{$detail_inv->id}}">
                                <div class="form-group">
                                    <label for="cc">CC Email</label>
                                    <input type="text" id="cc" class="form-control" name="cc_mail">
                                </div>
                                <div class="form-group">
                                    <label for="">Attach File</label>
                                    <input type="file" name="attach" class="form-control">
                                </div>
                            </div>
                            <div class="form-group text-center my-3">
                                <button type="submit" class="btn btn-outline-info">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection
