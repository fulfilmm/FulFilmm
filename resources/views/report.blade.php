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
                <div class="col my-2">
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
                <div class="col my-2">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Cash In Sales Man</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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

            </div>
            <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Bill(ပီပီးသား/မပေးရသေး အားလုံးပေါင်း)</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col my-2">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Payable(မပေးရန်ကျန် bill)</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Payment (ပေးပီးသားamount)</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                <div class="col my-2">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
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
            </div>
            <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">Damage Products(Stock Out type Damage)</div>
                                    <span class="small"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="alert-warning alert mb-0 shadow">
                        <a href="{{url('expense')}}">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                                <div class="flex-fill ms-3 text-truncate">
                                    <div class="h6 mb-0">FOC Product(Stock Out FOC)</div>
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
