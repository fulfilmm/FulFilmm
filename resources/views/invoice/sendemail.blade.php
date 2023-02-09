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
        <form action="{{route('send')}}" method="POST" enctype="multipart/form-data">
        <div class="row ">

            <div class="col-md-9">
                <div class="card shadow">
                        @csrf
                        <div class="card-body">
                            <div class="row mt-3 mb-1">
                                <div class="col-sm-4 col-md-2">
                                    <img src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" class="inv-logo" alt="logo" >
                                </div>
                                <div class="col-sm-2 col-md-3 ml-2">
                                    <h3>{{$company->name ?? ''}}</h3>
                                    <strong> <i> {{$company->address??''}}</i></strong>
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
                            <hr>
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
                                <div class="col-sm-4 col-lg-4 col-xl-4 m-b-20 offset-lg-2 offset-sm-2 offset-xl-2">
                                    <h5>Invoice Issued By:</h5>
                                    <ul class="list-unstyled">
                                        <li><strong>{{$detail_inv->employee->name??''}}</strong></li>
                                        <li><strong>{{$detail_inv->employee->phone??''}}</strong></li>
                                        <li><strong>{{$detail_inv->email??''}}</strong></li>
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
                                        <th>UNIT Price</th>
                                        <th>QUANTITY</th>
                                        <th>Unit</th>
                                        <th class="text-right">TOTAL</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($invoice_item!=[])
                                        @foreach($invoice_item as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->variant->product_name}}({{$item->variant->variant??''}})</td>
                                            <td class="d-none d-sm-table-cell">{!!$item->description !!}</td>
                                            <td>{{$item->unit_price}}
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->unit->unit}}</td>
                                            <td class="text-right">{{$item->total}}</td>
                                        </tr>
                                    @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                    <div class="col-sm-7">
                                    </div>
                                    <div class="col-sm-5 col-md-5">
                                        <div class="row">
                                            <div class="col-6">Total</div>
                                            <div class="col-6"> {{$detail_inv->total}} </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">Discount</div>
                                            <div class="col-6">{{$detail_inv->discount}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">Tax</div>
                                            <div class="col-6">{{$detail_inv->tax_amount}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">Delivery Fee</div>
                                            <div class="col-6">{{$detail_inv->delivery_fee}} </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">Grand Total</div>
                                            <div class="col-6">{{$detail_inv->grand_total}}</div>
                                        </div>
                                    </div>
                                </div>
                            <div class="invoice-info">
                                    <h5>Other information</h5>
                                    <p class="text-muted">{{$detail_inv->other_information}}</p>
                                </div>
                        </div>
                </div>
            </div>
            <div class="col-md-3 card shadow">
                <div class="12 m-b-20">
                    <div class="form-group mt-5">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{$detail_inv->customer->email}}" class="form-control">
                    </div>

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

        </div>
        </form>
    </div>
    <!-- /Page Content -->
@endsection
