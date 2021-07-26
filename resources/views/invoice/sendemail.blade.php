@extends('layout.mainlayout')
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
                                    <img src="{{url(asset("img/profiles/avatar-02.jpg"))}}" class="inv-logo avatar" alt="logo" >
                                </div>
                                <div class="col-sm-2">
                                    <h3>{{$company->name ?? null}}</h3>
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
                                <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                                    <h5>Invoice to:</h5>
                                    <ul class="list-unstyled">
                                        <li><h5><strong>{{$detail_inv->customer->name}}</strong></h5></li>
                                        <li><span>{{$detail_inv->customer->company->name}}</span></li>
                                        <li>{{$detail_inv->customer->address}}</li>
                                        <li>Coosada, AL, 36020</li>
                                        <li>United States</li>
                                        <li>{{$detail_inv->customer->phone}}</li>
                                        <li><a href="#">{{$detail_inv->customer->email}}</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                    <input type="hidden" name="email" value="{{$detail_inv->customer->email}}">
                                    <input type="hidden" name="inv_id" value="{{$detail_inv->id}}">
                                    <div class="form-group">
                                        <label for="">CC Email</label>
                                        <input type="text" class="form-control" name="cc_mail">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Attach File</label>
                                        <input type="file" name="attach" class="form-control">
                                    </div>
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
    <div class="col-12">
        <div class="row">
            <div class="col-md-6 offset-md-3"><span><i class="la la-phone"></i> Phone: </span><span> <i> {{$company->phone}}</i> |</span>
            <span><i class="la la-envelope"></i> Email : </span><span><i> {{$company->email}}</i> |</span>
            <span><i class="la la-globe"></i> Website : </span><span><i> www.{{$company->web_link}}</i> </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <span><i class="la la-facebook"></i> Facebook Page : </span><span><i> {{$company->facebook_page}}</i> |</span>
                <span><i class="la la-linkedin"></i> Linkedin : </span><span><i> {{$company->linkedin}}</i> </span>
            </div>
        </div>
    </div>
@endsection
