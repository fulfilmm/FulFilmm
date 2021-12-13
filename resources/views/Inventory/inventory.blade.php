@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Inventory</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Inventory</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="d-block">Receipt</span>
                                </div>

                            </div>
                            <a href="{{url('rfq/receipt/process/')}}">
                            <h3 class="mb-3">{{$rfqprocess}} Process</h3></a>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between ">
                                <div>
                                    <span class="d-block">Delivery Order </span>
                                </div>
                            </div>
                            <h3 class="mb-3">2 Process</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div>
                                <span class="text-success"></span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="d-block">Return</span>
                                </div>

                            </div>
                            <h3 class="mb-3">3 Process</h3>

                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

                            </div>
                            <div>
                                <span class="text-success"></span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="d-block">Pos Order </span>
                                </div>

                            </div>
                            <h3 class="mb-3">4 Process</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar"  aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @endsection