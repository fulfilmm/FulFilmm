@extends('layout.mainlayout')
@section('title',"Delivery Details")
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/invoice_css/argon.css'))}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card"style=" height: 100%">
            <div class="card-header">
                <h3>{{$delivery->invoice->invoice_id}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h3>Delivery State</h3>
                        <div data-timeline-content="axis" data-timeline-axis-style="dashed" class="timeline timeline-one-side">
                            <a href="" id="draft">
                                <div class="timeline-block"><span class="timeline-step badge-primary"><i class="la la-{{$delivery->draft==1?'check':''}} text-white"></i></span>
                                    <div class="timeline-content"><h2 class="font-weight-500">
                                            Draft
                                        </h2>
                                        @if($delivery->draft==1)
                                            <small>
                                                Draft State: {{\Carbon\Carbon::parse($delivery->created_at)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->created_at))}}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <a href="" id="packing">
                                <div class="timeline-block">

                        <span class="timeline-step badge-danger"><i
                                    class="la la-{{$delivery->packing==1?'check':''}} text-white"></i></span>
                                    <div class="timeline-content"><h2 class="font-weight-500">
                                            Packing
                                        </h2>
                                        @if($delivery->packing==1)
                                            <small>
                                                Packing: {{\Carbon\Carbon::parse($delivery->packing_time)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->packing_time))}}
                                            </small>
                                        @else
                                            <small>Not yet in packaging</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <a href="" id="delivery">
                                <div class="timeline-block">

                                <span class="timeline-step badge-purple">
                                    <i class="la la-{{$delivery->on_way==1?'check':''}} text-white"></i>
                                </span>
                                    <div class="timeline-content">
                                        <h2 class="font-weight-500">On Delivery</h2>
                                        @if($delivery->on_way==1)
                                            <small>
                                                On The Way:{{\Carbon\Carbon::parse($delivery->onway_time)->toFormattedDateString()}} on {{date('h:i a', strtotime($delivery->onway_time))}}
                                            </small>
                                        @else
                                            <small>Not yet in on the way</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <a href="" id="done">
                                <div class="timeline-block">

                                <span class="timeline-step badge-success">
                                    <i class="la la-{{$delivery->customer_receive_confirm==1?'check':''}} text-white"></i>
                                </span>
                                    <div class="timeline-content">
                                        <h2 class="font-weight-500">Receipt</h2>
                                        <a href="{{url('delivery/customer/receipt/'.$delivery->id)}}" id="recept" class="btn btn-success {{$delivery->customer_receive_confirm==1?'disabled':''}} btn-sm">Receipt</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 border-left">
                       <h3> Delivery Man Contact</h3>
                        <div class="col-12 my-2">
                            <span>Name : {{$delivery->courier->name}}</span>
                        </div>
                        <div class="col-12 my-2">
                            <span>Phone : {{$delivery->courier->phone}}</span>
                        </div>
                        <div class="col-12 my-2">
                            <span>Email : {{$delivery->courier->email}}</span>
                        </div>
                        <h3>Company Info</h3>
                        <div class="col-12 my-2">
                            <span>Company Name : {{$company->name??''}}</span>
                        </div>
                        <div class="col-12 my-2">
                            <span>Contact Person : {{$company->contact_person??''}}</span>
                        </div>
                        <div class="col-12 my-2">
                            <span>Phone : {{$company->phone??''}}</span>
                        </div>
                        <div class="col-12 my-2">
                            <span>Email : {{$company->email??''}}</span>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
