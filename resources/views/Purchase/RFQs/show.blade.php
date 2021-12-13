@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">RFQ View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">RFQ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card" >
                <div class="card-header">
                    <a href="{{route('rfq.preparemail',$rfq->id)}}"  class="btn btn-primary btn-sm">{{$rfq->status=='RFQ Sent'?'Re-Sent':'SEND BY EMAIL'}}</a>
                    <a href="{{route('rfq.statuschange',[$rfq->id,'Cancel'])}}" class="btn btn-primary btn-sm">CANCEL</a>
                   @if($rfq->status=='Confirm Order')
                        <a href="{{route('receipt.show',$product_receive->id??'')}}" class="btn btn-primary btn-sm">Receive Product</a>
                       @elseif($rfq->status=='RFQ Sent'||$rfq->status='Daft')
                        <a href="{{route('rfq.statuschange',[$rfq->id,'Confirm Order'])}}" class="btn btn-primary btn-sm">CONFIRM ORDER</a>
                       @endif

                </div>
                <div class="card-body border" id="pdfarea" >
                    <div class="row">
                        <div class="col-md-12">
                            <span>Request For Quotation</span>
                            <h4>{{$rfq->purchase_id}}</h4>
                        </div>
                        <div class="col-md-6">
                          <div class="row mt-3">
                              <div class="col-md-6">
                                  <span class="text-muted">Vendor</span>
                              </div>
                            <div class="col-md-6">
                                {{$rfq->vendor->name}}
                            </div>
                          </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <span class="text-muted">Vendor Reference</span>
                                </div>
                                <div class="col-md-6">
                                    {{$rfq->vendor_reference}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($rfq->status=='Confirm Order')
                                <div class="row mt-3">
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4 offset-md-2">
                                        <span class="text-muted">Confirm Date</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span>{{\Carbon\Carbon::parse($rfq->confirm_date)->toFormattedDateString()}}</span>
                                    </div>
                                </div>
                                @else
                                <div class="row mt-3">
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4 offset-md-2">
                                        <span class="text-muted">Deadline</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span>{{\Carbon\Carbon::parse($rfq->deadline)->toFormattedDateString()}}</span>
                                    </div>
                                </div>
                                @endif
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 offset-md-2">
                                    <span class="text-muted">Receipt Date</span>
                                </div>
                                <div class="col-md-6">
                                    <span>{{\Carbon\Carbon::parse($rfq->receipt_date)->toFormattedDateString()}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-12">
                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>SubTotal</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @foreach($rfq_items as $item)
                                        <td>{{$item->product->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->total}}</td>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="width: 100%">
                        <p>{{$rfq->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection