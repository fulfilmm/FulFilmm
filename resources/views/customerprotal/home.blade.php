@extends('layout.mainlayout')
@section('title','Courier Home')
@section('content')
<div class="container-fluid content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-group m-b-30">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="d-block">Finish Delivery</span>
                            </div>

                        </div>
                        <h3 class="mb-3">{{$delivery_finish}}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <a href="{{route('deliveries.index')}}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between ">
                                <div>
                                    <span class="d-block">Inprogress Delivery </span>
                                </div>
                            </div>
                            <h3 class="mb-3">{{$delivery_unfinish}}</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </a>
                </div>

                {{--<div class="card">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="d-flex justify-content-between">--}}
                            {{--<div>--}}
                                {{--<span class="d-block">Remaining Delivery Fee</span>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<h3 class="mb-3">{{$remaining_deli_fee}}</h3>--}}

                        {{--<div class="progress mb-2" style="height: 5px;">--}}
                            {{--<div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="d-block">Total Delivery Fee</span>
                            </div>

                        </div>
                        <h3 class="mb-3">{{$deli_fee_total}}</h3>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection