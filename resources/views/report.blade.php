@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Daily Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                        <li class="breadcrumb-item active">
                            Daily Report
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('selling/report')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Sale Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.income')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0"></div>
                                    <span class="small">Revenue Report</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.inhand')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Cash In Hand Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.inemp')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Cash In Transit</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.receivable')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Receivable</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.bill')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Bill</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Expense Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.payable')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Payable</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.payment')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Payment</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('stock/report')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Stock Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.transfer')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Stock Transfer Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.stockin')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Stock In Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.stockout')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Stock Out Report</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.return')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Stock Return</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.damage')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Damage Products</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md col-6 my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{route('report.foc')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">FOC Product</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
