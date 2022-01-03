@extends('layout.mainlayout')
@section('content')
    <style>
        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        #button-bar {
            min-width: 310px;
            max-width: 800px;
            margin: 0 auto;
        }


    </style>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Admin!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <form action="{{route('search.saledashboard')}}" method="GET">
        <div class="row">
            <div class="col-md-3">
               @if(isset($search_month))
                    <div class="form-group">
                        <a href="{{route('saletargets.index')}}" class="btn btn-primary col-12"><i class="fa fa-backward mr-3"></i>Back To Current Month</a>
                    </div>
                   @endif
            </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="month"  id="" class="form-control">
                            @foreach($month as $key=>$val)
                                <option value="{{$val}}"{{isset($search_month)?($search_month==$val?'selected':''):($val==date('M')?'selected':'')}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="year"  id="" class="form-control">
                            <option value="{{date('Y')-2}}" {{isset($searchYear)?($searchYear==date('Y')-2?'selected':''):''}}>{{date('Y')-2}}</option>
                            <option value="{{date('Y')-1}}" {{isset($searchYear)?($searchYear==date('Y')-1?'selected':''):''}}>{{date('Y')-1}}</option>
                            <option value="{{date('Y')}}" {{isset($searchYear)?($searchYear==date('Y')?'selected':''):'selected'}}>{{date('Y')}}</option>
                            <option value="{{date('Y')+1}}" {{isset($searchYear)?($searchYear==date('Y')+1?'selected':''):''}}>{{date('Y')+1}}</option>
                            <option value="{{date('Y')+2}}" {{isset($searchYear)?($searchYear==date('Y')+2?'selected':''):''}}>{{date('Y')+2}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary col-12">Search</button>
                    </div>
                </div>


        </div>
        </form>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-bullseye"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$monthlysaletarget[date('M')]->target??0}}</h3>
                            <span>Sale Target ({{$search_month??date('M')}})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{isset($search_month)?$monthly[$search_month]->total??0:$monthly[date('M')]->total??0}}</h3>
                            <span> Total Sale({{$search_month??date('M')}})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$revenue[0]->total??0}}</h3>
                            <span>Revenue({{$search_month??date('M')}})</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$remaining}}</h3>
                            <span>Remaining</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card">

                            <figure class="highcharts-figure my-2">
                                <div id="monthly"></div>

                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <figure class="highcharts-figure my-2">
                                <div id="yearly"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                {{--<div class="card-group m-b-30">--}}
                    {{--<div class="card">--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="d-flex justify-content-between mb-3">--}}
                                {{--<div>--}}
                                    {{--<span class="d-block">New Employees</span>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<span class="text-success">+10%</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<h3 class="mb-3">10</h3>--}}
                            {{--<div class="progress mb-2" style="height: 5px;">--}}
                                {{--<div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
                            {{--</div>--}}
                            {{--<p class="mb-0">Overall Employees 218</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="card">--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="d-flex justify-content-between mb-3">--}}
                                {{--<div>--}}
                                    {{--<span class="d-block">Debit</span>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<span class="text-success"></span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<h3 class="mb-3">{{$all_income[date('Y')]->total}}</h3>--}}
                            {{--<div class="progress mb-2" style="height: 5px;">--}}
                                {{--<div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="card">--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="d-flex justify-content-between mb-3">--}}
                                {{--<div>--}}
                                    {{--<span class="d-block">Expenses</span>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<span class="text-danger">-2.8%</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<h3 class="mb-3">$8,500</h3>--}}
                            {{--<div class="progress mb-2" style="height: 5px;">--}}
                                {{--<div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
                            {{--</div>--}}
                            {{--<p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="card">--}}
                        {{--<div class="card-body">--}}
                            {{--<div class="d-flex justify-content-between mb-3">--}}
                                {{--<div>--}}
                                    {{--<span class="d-block">Profit</span>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<span class="text-danger">-75%</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<h3 class="mb-3">$1,12,000</h3>--}}
                            {{--<div class="progress mb-2" style="height: 5px;">--}}
                                {{--<div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
                            {{--</div>--}}
                            {{--<p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<!-- Statistics Widget -->--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12 col-lg-12 col-xl-4 d-flex">--}}
                {{--<div class="card flex-fill dash-statistics">--}}
                    {{--<div class="card-body">--}}
                        {{--<h5 class="card-title">Statistics</h5>--}}
                        {{--<div class="stats-list">--}}
                            {{--<div class="stats-info">--}}
                                {{--<p>Today Leave <strong>4 <small>/ 65</small></strong></p>--}}
                                {{--<div class="progress">--}}
                                    {{--<div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="stats-info">--}}
                                {{--<p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>--}}
                                {{--<div class="progress">--}}
                                    {{--<div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="stats-info">--}}
                                {{--<p>Completed Projects <strong>85 <small>/ 112</small></strong></p>--}}
                                {{--<div class="progress">--}}
                                    {{--<div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="stats-info">--}}
                                {{--<p>Open Tickets <strong>190 <small>/ 212</small></strong></p>--}}
                                {{--<div class="progress">--}}
                                    {{--<div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="stats-info">--}}
                                {{--<p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>--}}
                                {{--<div class="progress">--}}
                                    {{--<div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-12 col-lg-6 col-xl-4 d-flex">--}}
                {{--<div class="card flex-fill">--}}
                    {{--<div class="card-body">--}}
                        {{--<h4 class="card-title">Task Statistics</h4>--}}
                        {{--<div class="statistics">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-6 col-6 text-center">--}}
                                    {{--<div class="stats-box mb-4">--}}
                                        {{--<p>Total Tasks</p>--}}
                                        {{--<h3>385</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6 col-6 text-center">--}}
                                    {{--<div class="stats-box mb-4">--}}
                                        {{--<p>Overdue Tasks</p>--}}
                                        {{--<h3>19</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="progress mb-4">--}}
                            {{--<div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>--}}
                            {{--<div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>--}}
                            {{--<div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>--}}
                            {{--<div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>--}}
                            {{--<div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right">166</span></p>--}}
                            {{--<p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">115</span></p>--}}
                            {{--<p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Tasks <span class="float-right">31</span></p>--}}
                            {{--<p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>--}}
                            {{--<p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-12 col-lg-6 col-xl-4 d-flex">--}}
                {{--<div class="card flex-fill">--}}
                    {{--<div class="card-body">--}}
                        {{--<h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">5</span></h4>--}}
                        {{--<div class="leave-info-box">--}}
                            {{--<div class="media align-items-center">--}}
                                {{--<a href="profile" class="avatar"><img alt="" src="img/user.jpg"></a>--}}
                                {{--<div class="media-body">--}}
                                    {{--<div class="text-sm my-0">Martin Lewis</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row align-items-center mt-3">--}}
                                {{--<div class="col-6">--}}
                                    {{--<h6 class="mb-0">4 Sep 2019</h6>--}}
                                    {{--<span class="text-sm text-muted">Leave Date</span>--}}
                                {{--</div>--}}
                                {{--<div class="col-6 text-right">--}}
                                    {{--<span class="badge bg-inverse-danger">Pending</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="leave-info-box">--}}
                            {{--<div class="media align-items-center">--}}
                                {{--<a href="profile" class="avatar"><img alt="" src="img/user.jpg"></a>--}}
                                {{--<div class="media-body">--}}
                                    {{--<div class="text-sm my-0">Martin Lewis</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row align-items-center mt-3">--}}
                                {{--<div class="col-6">--}}
                                    {{--<h6 class="mb-0">4 Sep 2019</h6>--}}
                                    {{--<span class="text-sm text-muted">Leave Date</span>--}}
                                {{--</div>--}}
                                {{--<div class="col-6 text-right">--}}
                                    {{--<span class="badge bg-inverse-success">Approved</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="load-more text-center">--}}
                            {{--<a class="text-dark" href="javascript:void(0);">Load More</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- /Statistics Widget -->--}}

        {{--<div class="row">--}}
            {{--<div class="col-md-6 d-flex">--}}
                {{--<div class="card card-table flex-fill">--}}
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title mb-0">Invoices</h3>--}}
                    {{--</div>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table table-nowrap custom-table mb-0">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Invoice ID</th>--}}
                                    {{--<th>Client</th>--}}
                                    {{--<th>Due Date</th>--}}
                                    {{--<th>Total</th>--}}
                                    {{--<th>Status</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0001</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Global Technologies</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>11 Mar 2019</td>--}}
                                    {{--<td>$380</td>--}}
                                    {{--<td>--}}
                                        {{--<span class="badge bg-inverse-warning">Partially Paid</span>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0002</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Delta Infotech</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>8 Feb 2019</td>--}}
                                    {{--<td>$500</td>--}}
                                    {{--<td>--}}
                                        {{--<span class="badge bg-inverse-success">Paid</span>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0003</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Cream Inc</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>23 Jan 2019</td>--}}
                                    {{--<td>$60</td>--}}
                                    {{--<td>--}}
                                        {{--<span class="badge bg-inverse-danger">Unpaid</span>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="invoices">View all invoices</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 d-flex">--}}
                {{--<div class="card card-table flex-fill">--}}
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title mb-0">Payments</h3>--}}
                    {{--</div>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table custom-table table-nowrap mb-0">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Invoice ID</th>--}}
                                    {{--<th>Client</th>--}}
                                    {{--<th>Payment Type</th>--}}
                                    {{--<th>Paid Date</th>--}}
                                    {{--<th>Paid Amount</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0001</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Global Technologies</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>Paypal</td>--}}
                                    {{--<td>11 Mar 2019</td>--}}
                                    {{--<td>$380</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0002</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Delta Infotech</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>Paypal</td>--}}
                                    {{--<td>8 Feb 2019</td>--}}
                                    {{--<td>$500</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td><a href="invoice-view">#INV-0003</a></td>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="#">Cream Inc</a></h2>--}}
                                    {{--</td>--}}
                                    {{--<td>Paypal</td>--}}
                                    {{--<td>23 Jan 2019</td>--}}
                                    {{--<td>$60</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="payments">View all payments</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-6 d-flex">--}}
                {{--<div class="card card-table flex-fill">--}}
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title mb-0">Clients</h3>--}}
                    {{--</div>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table custom-table mb-0">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Name</th>--}}
                                    {{--<th>Email</th>--}}
                                    {{--<th>Status</th>--}}
                                    {{--<th class="text-right">Action</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2 class="table-avatar">--}}
                                            {{--<a href="#" class="avatar"><img alt="" src="img/profiles/avatar-19.jpg"></a>--}}
                                            {{--<a href="client-profile">Barry Cuda <span>CEO</span></a>--}}
                                        {{--</h2>--}}
                                    {{--</td>--}}
                                    {{--<td>barrycuda@example.com</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="dropdown action-label">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                                                {{--<i class="fa fa-dot-circle-o text-success"></i> Active--}}
                                            {{--</a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2 class="table-avatar">--}}
                                            {{--<a href="#" class="avatar"><img alt="" src="img/profiles/avatar-19.jpg"></a>--}}
                                            {{--<a href="client-profile">Tressa Wexler <span>Manager</span></a>--}}
                                        {{--</h2>--}}
                                    {{--</td>--}}
                                    {{--<td>tressawexler@example.com</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="dropdown action-label">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                                                {{--<i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
                                            {{--</a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2 class="table-avatar">--}}
                                            {{--<a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-07.jpg"></a>--}}
                                            {{--<a href="client-profile">Ruby Bartlett <span>CEO</span></a>--}}
                                        {{--</h2>--}}
                                    {{--</td>--}}
                                    {{--<td>rubybartlett@example.com</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="dropdown action-label">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                                                {{--<i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
                                            {{--</a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2 class="table-avatar">--}}
                                            {{--<a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-06.jpg"></a>--}}
                                            {{--<a href="client-profile"> Misty Tison <span>CEO</span></a>--}}
                                        {{--</h2>--}}
                                    {{--</td>--}}
                                    {{--<td>mistytison@example.com</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="dropdown action-label">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                                                {{--<i class="fa fa-dot-circle-o text-success"></i> Active--}}
                                            {{--</a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2 class="table-avatar">--}}
                                            {{--<a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-14.jpg"></a>--}}
                                            {{--<a href="client-profile"> Daniel Deacon <span>CEO</span></a>--}}
                                        {{--</h2>--}}
                                    {{--</td>--}}
                                    {{--<td>danieldeacon@example.com</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="dropdown action-label">--}}
                                            {{--<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
                                                {{--<i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
                                            {{--</a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
                                                {{--<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="clients">View all clients</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 d-flex">--}}
                {{--<div class="card card-table flex-fill">--}}
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title mb-0">Recent Projects</h3>--}}
                    {{--</div>--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table custom-table mb-0">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Project Name </th>--}}
                                    {{--<th>Progress</th>--}}
                                    {{--<th class="text-right">Action</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="project-view">Office Management</a></h2>--}}
                                        {{--<small class="block text-ellipsis">--}}
                                            {{--<span>1</span> <span class="text-muted">open tasks, </span>--}}
                                            {{--<span>9</span> <span class="text-muted">tasks completed</span>--}}
                                        {{--</small>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="progress progress-xs progress-striped">--}}
                                            {{--<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="65%" style="width: 65%"></div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="project-view">Project Management</a></h2>--}}
                                        {{--<small class="block text-ellipsis">--}}
                                            {{--<span>2</span> <span class="text-muted">open tasks, </span>--}}
                                            {{--<span>5</span> <span class="text-muted">tasks completed</span>--}}
                                        {{--</small>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="progress progress-xs progress-striped">--}}
                                            {{--<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="15%" style="width: 15%"></div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="project-view">Video Calling App</a></h2>--}}
                                        {{--<small class="block text-ellipsis">--}}
                                            {{--<span>3</span> <span class="text-muted">open tasks, </span>--}}
                                            {{--<span>3</span> <span class="text-muted">tasks completed</span>--}}
                                        {{--</small>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="progress progress-xs progress-striped">--}}
                                            {{--<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="49%" style="width: 49%"></div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="project-view">Hospital Administration</a></h2>--}}
                                        {{--<small class="block text-ellipsis">--}}
                                            {{--<span>12</span> <span class="text-muted">open tasks, </span>--}}
                                            {{--<span>4</span> <span class="text-muted">tasks completed</span>--}}
                                        {{--</small>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="progress progress-xs progress-striped">--}}
                                            {{--<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="88%" style="width: 88%"></div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--<h2><a href="project-view">Digital Marketplace</a></h2>--}}
                                        {{--<small class="block text-ellipsis">--}}
                                            {{--<span>7</span> <span class="text-muted">open tasks, </span>--}}
                                            {{--<span>14</span> <span class="text-muted">tasks completed</span>--}}
                                        {{--</small>--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--<div class="progress progress-xs progress-striped">--}}
                                            {{--<div class="progress-bar" role="progressbar" data-toggle="tooltip" title="100%" style="width: 100%"></div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                    {{--<td class="text-right">--}}
                                        {{--<div class="dropdown dropdown-action">--}}
                                            {{--<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
                                            {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                {{--<a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="card-footer">--}}
                        {{--<a href="projects">View all projects</a>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    </div>
    <!-- /Page Content -->
{{--@dd($year[0])--}}

    <script>

        var monthly=$("input[name='monthly'] option:checked").val();
        var chart = Highcharts.chart('monthly', {

            chart: {
                type: "column"
            },
            title: {
                text: '{{$searchYear??date('Y')}} Monthly Sale and Target '
            },

            legend: {
                layout: "vertical",
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'March', 'April', 'May', 'June','July','Aug','Sep','Oct','Nov','Dec'],
                labels: {
                    x:3
                }
            },

            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Amount'
                }

            },

            series: [{
                name: 'Sale Target',
                data: [
                    {{$monthlysaletarget['Jan']->target??0}},
                    {{$monthlysaletarget['Feb']->target??0}},
                    {{$monthlysaletarget['March']->target??0}},
                    {{$monthlysaletarget['April']->target??0}},
                    {{$monthlysaletarget['May']->target??0}},
                    {{$monthlysaletarget['June']->target??0}},
                    {{$monthlysaletarget['July']->target??0}},
                    {{$monthlysaletarget['Aug']->target??0}},
                    {{$monthlysaletarget['Sep']->target??0}},
                    {{$monthlysaletarget['Oct']->target??0}},
                    {{$monthlysaletarget['Nov']->target??0}},
                    {{$monthlysaletarget['Dec']->target??0}}
                ],
                crosshair: true
            }, {
                name: 'Total Sale',
                data: [
                    {{$monthly['Jan']->total??0}},
                    {{$monthly['Feb']->total??0}},
                    {{$monthly['March']->total??0}},
                    {{$monthly['April']->total??0}},
                    {{$monthly['May']->total??0}},
                    {{$monthly['June']->total??0}},
                    {{$monthly['July']->total??0}},
                    {{$monthly['Aug']->total??0}},
                    {{$monthly['Sep']->total??0}},
                    {{$monthly['Oct']->total??0}},
                    {{$monthly['Nov']->total??0}},
                    {{$monthly['Dec']->total??0}}
                ]
            }
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            align: 'center',
                            verticalAlign: 'bottom',
                            layout: 'horizontal'
                        },
                        yAxis: {
                            labels: {
                                align: 'left',
                                x: 0,
                                y: -5
                            },
                            title: {
                                text: null
                            }
                        },
                        subtitle: {
                            text: null
                        },
                        credits: {
                            enabled: false
                        }
                    }
                }]
            }
        });

        var chart = Highcharts.chart('yearly', {

            chart: {
                type: ''
            },
            title: {
                text: 'Yearly Sale and Target'
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            tooltip: {
                valueSuffix: 'MMK',
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} MMK</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            xAxis: {
                categories: [{{$year[0]}}, '{{$year[1]}}', '{{$year[2]}}', '{{$year[3]}}', '{{$year[4]}}'],
                labels: {
                    x:-2
                }
            },

            yAxis: {
                min: 0,
                title: {
                    text: 'Amount',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },

            series: [{
                name: 'Sale Target',
                data: [
                    {{$yearly_target[$year[0]]->target??0}},
                    {{$yearly_target[$year[1]]->target??0}},
                    {{$yearly_target[$year[2]]->target??0}},
                    {{$yearly_target[$year[3]]->target??0}},
                    {{$yearly_target[$year[4]]->target??0}}

                ]
            }, {
                name: 'Total Sale',
                data: [
                    {{$yearly[$year[0]]->total??0}},
                    {{$yearly[$year[1]]->total??0}},
                    {{$yearly[$year[2]]->total??0}},
                    {{$yearly[$year[3]]->total??0}},
                    {{$yearly[$year[4]]->total??0}}

                ]
            }
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            align: 'center',
                            verticalAlign: 'bottom',
                            layout: 'vertical'
                        },
                        yAxis: {
                            labels: {
                                align: 'left',
                                x: 0,
                                y: -5
                            },
                            title: {
                                text: null
                            }
                        },
                        subtitle: {
                            text: null
                        },
                        credits: {
                            enabled: false
                        }
                    }
                }]
            }
        });


    </script>
    <!-- /Page Wrapper -->
@endsection