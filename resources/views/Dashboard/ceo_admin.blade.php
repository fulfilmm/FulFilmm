<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
    <div class="col  my-2">
        <div class="alert-success alert mb-0 shadow">
            <a href="{{url('revenue')}}">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded no-thumbnail bg-success text-light shadow"><i class="fa fa-dollar fa-lg"></i></div>
                    <div class="flex-fill ms-3 text-truncate">
                        <div class="h6 mb-0">In Flow</div>
                        <span class="small"><span id="total_income"></span></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-danger alert mb-0 shadow">
            <a href="{{url('expense')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-credit-card fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Out Flow</div>
                    <span class="small" id="total_expense"></span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-warning text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Balance</div>
                    <span class="small" id="total_profit"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-warning alert mb-0 shadow">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light shadow"><i class="fa fa-money fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Bill</div>
                    <span class="small" id="total_bill"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col my-2">
        <div class="alert-info alert mb-0 shadow">
            <a href="{{route('accounts.index')}}">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-info text-light shadow"><i class="fa fa-bank" aria-hidden="true"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Account</div>
                    <span class="small">{{$account[0]->total??0}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <figure class="highcharts-figure my-2">
                <div id="yearly"></div>
            </figure>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('employees.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['daily_sale'][0]->total??0}}</h3>
                        <span>Daily Sale</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('customers.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['customer']??0}}</h3>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('transactions.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-retweet"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['transaction']??0}}</h3>
                        <span>Transactions</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('groups.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['my_groups']??0}}</h3>
                        <span>Group</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 ">
        <a href="{{route('tickets.index')}}">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-ticket"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['all_ticket']}}</h3>
                        <span>Tickets</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 ">
        <a href="{{route('approvals.index')}}">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-check-circle-o"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['requestation']??0}}</h3>
                        <span>Requestation</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 ">
        <a href="{{url('sale/activity')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                                <span class="dash-widget-icon"><i class="la la-bar-chart"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['saleactivity']}}</h3>
                        <span>Sale Activity</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('meetings.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-calendar"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['meeting']??0}}</h3>
                        <span>Meeting</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('employees.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$total_emp}}</h3>
                        <span>Employees</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('customers.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['customer']??0}}</h3>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('transactions.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-retweet"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['transaction']??0}}</h3>
                        <span>Transactions</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('groups.index')}}">
            <div class="card dash-widget ">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['my_groups']??0}}</h3>
                        <span>Group</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
