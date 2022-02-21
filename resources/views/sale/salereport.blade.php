@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sale Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Sale Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Today Whole Sale</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$total_sale[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style=""
                                             aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Today Retail Sale</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$total_reatail_sale[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="card shadow">
                            <a href="{{url('revenue')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between ">
                                        <div>
                                            <span class="d-block">Today Income</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">{{$income[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        <span class="text-success"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Today Debt</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$debt_amount[0]->total??0}}</h3>

                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>

                                    </div>
                                    <div>
                                        <span class="text-success"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Today Whole Sale</a>
                </li>
                {{--<li class="nav-item" role="presentation">--}}
                {{--<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Today Retail Sale</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item" role="presentation">--}}
                {{--<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Product Received</a>--}}
                {{--</li>--}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12" style="overflow: auto">
                                <table class="table " id="dailysale">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice ID</th>
                                        <th>Product Code</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th>Customer</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">--}}
                    {{--<div class="col-12">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-12" style="overflow: auto">--}}
                                {{--<table class="table " id="daily_retail_sale">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>Date</th>--}}
                                        {{--<th>Invoice ID</th>--}}
                                        {{--<th>Product Code</th>--}}
                                        {{--<th>Qty</th>--}}
                                        {{--<th>Unit Price</th>--}}
                                        {{--<th>Total</th>--}}
                                        {{--<th>Customer</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}

                                {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $(function () {
                var table = $('#dailysale').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('sale.report') }}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },

                        {
                            data:'invoice.invoice_id',
                            name:'Invoice ID',
                        },
                        {
                            data: 'variant.product_code',
                            name: 'Product Code'
                        },
                        {
                            data: 'quantity',
                            name: 'Quantity'
                        },
                        {
                            data: 'unit_price',
                            name: 'Quantity'
                        },
                        {
                            data: 'total',
                            name: 'Total'
                        },
                        {
                            data: 'action',
                            name: 'Customer'
                        }
                    ]

                });

            });
        });
    </script>
@endsection
