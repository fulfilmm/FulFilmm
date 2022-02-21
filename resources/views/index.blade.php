@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <style>
        /*.highcharts-credits{*/
            /*display: none;*/
        /*}*/
    </style>
    <div class="p-3">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ ucfirst(\Illuminate\Support\Facades\Auth::user()->name)}}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">{{\Illuminate\Support\Facades\Auth::user()->role->name}}
                            Dashboard
                        </li>
                    </ul>
                </div>
              @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='SuperAdmin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO')
                    <div class="col-12">
                        <div class="float-right">
                            <input type="radio" name="report_type" class="radio" value="1" checked><label for="" class="ml-2">Current Year</label>
                            <input type="radio" name="report_type" class="radio" value="2"><label for="" class="ml-2">Jan to June</label>
                            <input type="radio" name="report_type" class="radio" value="3"><label for="" class="ml-2">July to Dec</label>
                            <input type="radio" name="report_type" class="radio" value="4"><label for="" class="ml-2">Current Month</label>
                        </div>
                    </div>
                  @endif
            </div>

        </div>
        <!-- /Page Header -->
        @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Ticket Admin')
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">New </span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$status_report['New']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{$report_percentage['New']}}%;"
                                         aria-valuenow="{{$report_percentage['New']}}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div>
                                    <span class="text-success">{{$report_percentage['New']}}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between ">
                                    <div>
                                        <span class="d-block">Solved </span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$status_report['Complete']+$status_report['Close']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{$report_percentage['Solve']}}%;"
                                         aria-valuenow="{{$report_percentage['Solve']}}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div>
                                    <span class="text-success">{{$report_percentage['Solve']}}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">Open and Progress </span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$status_report['Open']+$status_report['In Progress']}}</h3>

                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{$report_percentage['Open']}}%;"
                                         aria-valuenow="{{$report_percentage['Open']}}" aria-valuemin="0"
                                         aria-valuemax="100"></div>

                                </div>
                                <div>
                                    <span class="text-success">{{$report_percentage['Open']}}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">Pending </span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$status_report['Pending']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{$report_percentage['Pending']}}%;"
                                         aria-valuenow="{{$report_percentage['Pending']}}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div>
                                    <span class="text-danger">{{$report_percentage['Pending']}}%</span>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">Overdue </span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$status_report['Overdue']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{$report_percentage['Overdue']}}%;"
                                         aria-valuenow="{{$report_percentage['Overdue']}}" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <div>
                                    <span class="text-danger">{{$report_percentage['Overdue']}}%</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill shadow">
                        <div class="card-header">
                            <h3 class="card-title mb-0">All Agents Performance</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Total Assign Ticket</th>
                                        <th>Solved Ticket</th>
                                        <th>Over Due Ticket</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($agents as $agent)
                                        <tr>
                                            <th>#{{$agent->id}}</th>
                                            <td>{{$agent->name}}</td>
                                            @php $agent_ticket=[];
                                            $solved_ticket=0;
                                            $overdue_status=\App\Models\status::where('name','Overdue')->first();
                                            $overdue=0;
                                        foreach ($assign_ticket as $item) {
                                             if($item->agent_id==$agent->id ){
                                                 array_push($agent_ticket,$item);
                                                 foreach ($status as $st){
                                                    if($st->id==$item->ticket->status){
                                                        $solved_ticket ++;
                                                    }
                                                }
                                                foreach ($status as $st){
                                                    if($item->dept_id==$agent->department_id){
                                                        $solved_with_dept ++;
                                                    }
                                                }
                                                if($item->ticket->status==$overdue_status->id){
                                                     $overdue ++;
                                                    }

                                             }
                                        }
                                            @endphp
                                            <td><span class="badge badge-pill bg-danger text-white">{{count($agent_ticket)}}&nbsp Tickets</span>
                                            </td>
                                            <td><span class="text-center badge badge-pill bg-info text-white">{{$solved_ticket}}&nbsp Tickets</span>
                                            </td>
                                            <td><span class="text-center badge badge-pill bg-info text-white">{{$overdue}}&nbsp Tickets</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('tickets.index')}}">View all Ticket</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill shadow">
                        <div class="card-header">
                            <h3 class="card-title mb-0">All Department Performance</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department Header</th>
                                        <th>Total Assign Ticket</th>
                                        <th>Solved Ticket</th>
                                        <th>Over Due Ticket</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($depts as $dept)
                                        <tr>
                                            <th>#{{$dept->id}}</th>
                                            <td>{{$dept->name}}</td>
                                            <td></td>
                                            @php $dept_ticket=0;
                                            $solved_with_dept=0;
                                            $overdue_status=\App\Models\status::where('name','Overdue')->first();
                                            $overdue=0;
                                        foreach ($assign_ticket as $item) {
                                             if($item->dept_id==$dept->id ){
                                                 $dept_ticket ++;
                                                 foreach ($status as $st){
                                                    if($st->id==$item->ticket->status){
                                                        $solved_with_dept ++;
                                                    }
                                                        }
                                                if($item->ticket->status==$overdue_status->id){
                                                     $overdue ++;
                                                    }

                                             }
                                        }
                                            @endphp
                                            <td><span class="badge badge-pill bg-danger text-white">{{$dept_ticket}}&nbsp Tickets</span>
                                            </td>
                                            <td><span class="text-center badge badge-pill bg-info text-white">{{$solved_with_dept}}&nbsp Tickets</span>
                                            </td>
                                            <td><span class="text-center badge badge-pill bg-info text-white">{{$overdue}}&nbsp Tickets</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('tickets.index')}}">View all Ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin')

            <div class="row" id="total_card">
                <div class="col-md-4">
                    <div class="card shadow bg-gradient-info">
                        <div class="card-body text-white">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Total Income</span>
                                </div>
                            </div>
                            <h3 class="mb-3"><span id="total_income"></span></h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow bg-gradient-danger">
                        <div class="card-body text-white">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Total Expense</span>
                                </div>
                            </div>
                            <h3 class="mb-3" id="total_expense"></h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow bg-gradient-success">
                        <div class="card-body text-white">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                            </div>
                            <h3 class="mb-3" id="total_profit"></h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-white" role="progressbar" style="width: 100%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
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
                    <a href="{{route('tickets.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="la la-ticket"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['all_ticket']}}</h3>
                                    <div class="row">
                                        <span>Tickets</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('approvals.index')}}">
                        <div class="card dash-widget shadow">
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
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{url('sale/activity')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><img
                                            src="{{url(asset('img/profiles/saleactivity.png'))}}" alt="" width="30"
                                            height="30"></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['saleactivity']}}</h3>
                                    <div class="row">
                                        <span>Sale Activity</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('meetings.index')}}">
                        <div class="card dash-widget shadow">
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
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$total_emp}}</h3>
                                    <div class="row">
                                        <span>Employees</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('customers.index')}}">
                        <div class="card dash-widget shadow">
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
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="la la-retweet"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['transaction']??0}}</h3>
                                    <div class="row">
                                        <span>Transactions</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('groups.index')}}">
                        <div class="card dash-widget shadow">
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
        @elseif(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Employee'&&\Illuminate\Support\Facades\Auth::guard('employee')->user()->department->name=='Sale Department')
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget shadow">
                        <div class="card-body">
                            <span class="dash-widget-icon"><i class="fa fa-group"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$items['my_groups']}}</h3>
                                <span>My Groups</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{url('sale/activity')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><img
                                            src="{{url(asset('img/profiles/saleactivity.png'))}}" alt="" width="30"
                                            height="30"></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['saleactivity']}}</h3>
                                    <div class="row">
                                        <span>Sale Activity</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('meetings.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="la la-calender"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['meeting']}}</h3>
                                    <span>Meeting</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('meetings.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="la la-money"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['assignment']??0}}</h3>
                                    <span>Assignment</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('approvals.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['requestation']}}</h3>
                                    <div class="row">
                                        <span>Requestation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('tickets.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-ticket"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['all_ticket']}}</h3>
                                    @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin')
                                        <span>Total Tickets</span>
                                    @else
                                        <span>My Tickets</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('meetings.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['assignment']??0}}</h3>
                                    <span>Assigment</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{route('meetings.index')}}">
                        <div class="card dash-widget shadow">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-money"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{$items['meeting']??0}}</h3>
                                    <span>Meeting</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        {{--        <div class="row">--}}
        {{--            <div class="col-md-12">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-md-6 text-center">--}}
        {{--                        <div class="card">--}}
        {{--                            <div class="card-body">--}}
        {{--                                <h3 class="card-title">Total Revenue</h3>--}}
        {{--                                <div id="bar-charts"></div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="col-md-6 text-center">--}}
        {{--                        <div class="card">--}}
        {{--                            <div class="card-body">--}}
        {{--                                <h3 class="card-title">Sales Overview</h3>--}}
        {{--                                <div id="line-charts"></div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        {{--        <div class="row">--}}
        {{--            <div class="col-md-12">--}}
        {{--                <div class="card-group m-b-30">--}}
        {{--                    <div class="card">--}}
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
        {{--                    </div>--}}

        {{--                    <div class="card">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex justify-content-between mb-3">--}}
        {{--                                <div>--}}
        {{--                                    <span class="d-block">Earnings</span>--}}
        {{--                                </div>--}}
        {{--                                <div>--}}
        {{--                                    <span class="text-success">+12.5%</span>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <h3 class="mb-3">$1,42,300</h3>--}}
        {{--                            <div class="progress mb-2" style="height: 5px;">--}}
        {{--                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="card">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex justify-content-between mb-3">--}}
        {{--                                <div>--}}
        {{--                                    <span class="d-block">Expenses</span>--}}
        {{--                                </div>--}}
        {{--                                <div>--}}
        {{--                                    <span class="text-danger">-2.8%</span>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <h3 class="mb-3">$8,500</h3>--}}
        {{--                            <div class="progress mb-2" style="height: 5px;">--}}
        {{--                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="card">--}}
        {{--                        <div class="card-body">--}}
        {{--                            <div class="d-flex justify-content-between mb-3">--}}
        {{--                                <div>--}}
        {{--                                    <span class="d-block">Profit</span>--}}
        {{--                                </div>--}}
        {{--                                <div>--}}
        {{--                                    <span class="text-danger">-75%</span>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <h3 class="mb-3">$1,12,000</h3>--}}
        {{--                            <div class="progress mb-2" style="height: 5px;">--}}
        {{--                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                            </div>--}}
        {{--                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        {{--        <!-- Statistics Widget -->--}}
        {{--        <div class="row">--}}
        {{--            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">--}}
        {{--                <div class="card flex-fill dash-statistics">--}}
        {{--                    <div class="card-body">--}}
        {{--                        <h5 class="card-title">Statistics</h5>--}}
        {{--                        <div class="stats-list">--}}
        {{--                            <div class="stats-info">--}}
        {{--                                <p>Today Leave <strong>4 <small>/ 65</small></strong></p>--}}
        {{--                                <div class="progress">--}}
        {{--                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="stats-info">--}}
        {{--                                <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>--}}
        {{--                                <div class="progress">--}}
        {{--                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="stats-info">--}}
        {{--                                <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>--}}
        {{--                                <div class="progress">--}}
        {{--                                    <div class="progress-bar bg-success" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="stats-info">--}}
        {{--                                <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>--}}
        {{--                                <div class="progress">--}}
        {{--                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="stats-info">--}}
        {{--                                <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>--}}
        {{--                                <div class="progress">--}}
        {{--                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">--}}
        {{--                <div class="card flex-fill">--}}
        {{--                    <div class="card-body">--}}
        {{--                        <h4 class="card-title">Task Statistics</h4>--}}
        {{--                        <div class="statistics">--}}
        {{--                            <div class="row">--}}
        {{--                                <div class="col-md-6 col-6 text-center">--}}
        {{--                                    <div class="stats-box mb-4">--}}
        {{--                                        <p>Total Tasks</p>--}}
        {{--                                        <h3>385</h3>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                                <div class="col-md-6 col-6 text-center">--}}
        {{--                                    <div class="stats-box mb-4">--}}
        {{--                                        <p>Overdue Tasks</p>--}}
        {{--                                        <h3>19</h3>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="progress mb-4">--}}
        {{--                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>--}}
        {{--                            <div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>--}}
        {{--                            <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>--}}
        {{--                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>--}}
        {{--                            <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>--}}
        {{--                        </div>--}}
        {{--                        <div>--}}
        {{--                            <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right">166</span></p>--}}
        {{--                            <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right">115</span></p>--}}
        {{--                            <p><i class="fa fa-dot-circle-o text-success mr-2"></i>On Hold Tasks <span class="float-right">31</span></p>--}}
        {{--                            <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>--}}
        {{--                            <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}

        {{--            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">--}}
        {{--                <div class="card flex-fill">--}}
        {{--                    <div class="card-body">--}}
        {{--                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2">5</span></h4>--}}
        {{--                        <div class="leave-info-box">--}}
        {{--                            <div class="media align-items-center">--}}
        {{--                                <a href="profile" class="avatar"><img alt="" src="img/user.jpg"></a>--}}
        {{--                                <div class="media-body">--}}
        {{--                                    <div class="text-sm my-0">Martin Lewis</div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="row align-items-center mt-3">--}}
        {{--                                <div class="col-6">--}}
        {{--                                    <h6 class="mb-0">4 Sep 2019</h6>--}}
        {{--                                    <span class="text-sm text-muted">Leave Date</span>--}}
        {{--                                </div>--}}
        {{--                                <div class="col-6 text-right">--}}
        {{--                                    <span class="badge bg-inverse-danger">Pending</span>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="leave-info-box">--}}
        {{--                            <div class="media align-items-center">--}}
        {{--                                <a href="profile" class="avatar"><img alt="" src="img/user.jpg"></a>--}}
        {{--                                <div class="media-body">--}}
        {{--                                    <div class="text-sm my-0">Martin Lewis</div>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="row align-items-center mt-3">--}}
        {{--                                <div class="col-6">--}}
        {{--                                    <h6 class="mb-0">4 Sep 2019</h6>--}}
        {{--                                    <span class="text-sm text-muted">Leave Date</span>--}}
        {{--                                </div>--}}
        {{--                                <div class="col-6 text-right">--}}
        {{--                                    <span class="badge bg-inverse-success">Approved</span>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="load-more text-center">--}}
        {{--                            <a class="text-dark" href="javascript:void(0);">Load More</a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        <!-- /Statistics Widget -->--}}


        {{--            <div class="col-md-6 d-flex">--}}
        {{--                <div class="card card-table flex-fill">--}}
        {{--                    <div class="card-header">--}}
        {{--                        <h3 class="card-title mb-0">Payments</h3>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body">--}}
        {{--                        <div class="table-responsive">--}}
        {{--                            <table class="table custom-table table-nowrap mb-0">--}}
        {{--                                <thead>--}}
        {{--                                    <tr>--}}
        {{--                                        <th>Invoice ID</th>--}}
        {{--                                        <th>Client</th>--}}
        {{--                                        <th>Payment Type</th>--}}
        {{--                                        <th>Paid Date</th>--}}
        {{--                                        <th>Paid Amount</th>--}}
        {{--                                    </tr>--}}
        {{--                                </thead>--}}
        {{--                                <tbody>--}}
        {{--                                    <tr>--}}
        {{--                                        <td><a href="invoice-view">#INV-0001</a></td>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="#">Global Technologies</a></h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>Paypal</td>--}}
        {{--                                        <td>11 Mar 2019</td>--}}
        {{--                                        <td>$380</td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td><a href="invoice-view">#INV-0002</a></td>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="#">Delta Infotech</a></h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>Paypal</td>--}}
        {{--                                        <td>8 Feb 2019</td>--}}
        {{--                                        <td>$500</td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td><a href="invoice-view">#INV-0003</a></td>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="#">Cream Inc</a></h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>Paypal</td>--}}
        {{--                                        <td>23 Jan 2019</td>--}}
        {{--                                        <td>$60</td>--}}
        {{--                                    </tr>--}}
        {{--                                </tbody>--}}
        {{--                            </table>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-footer">--}}
        {{--                        <a href="payments">View all payments</a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        <div class="row">--}}
        {{--            <div class="col-md-6 d-flex">--}}
        {{--                <div class="card card-table flex-fill">--}}
        {{--                    <div class="card-header">--}}
        {{--                        <h3 class="card-title mb-0">Clients</h3>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body">--}}
        {{--                        <div class="table-responsive">--}}
        {{--                            <table class="table custom-table mb-0">--}}
        {{--                                <thead>--}}
        {{--                                    <tr>--}}
        {{--                                        <th>Name</th>--}}
        {{--                                        <th>Email</th>--}}
        {{--                                        <th>Status</th>--}}
        {{--                                        <th class="text-right">Action</th>--}}
        {{--                                    </tr>--}}
        {{--                                </thead>--}}
        {{--                                <tbody>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2 class="table-avatar">--}}
        {{--                                                <a href="#" class="avatar"><img alt="" src="img/profiles/avatar-19.jpg"></a>--}}
        {{--                                                <a href="client-profile">Barry Cuda <span>CEO</span></a>--}}
        {{--                                            </h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>barrycuda@example.com</td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="dropdown action-label">--}}
        {{--                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
        {{--                                                    <i class="fa fa-dot-circle-o text-success"></i> Active--}}
        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2 class="table-avatar">--}}
        {{--                                                <a href="#" class="avatar"><img alt="" src="img/profiles/avatar-19.jpg"></a>--}}
        {{--                                                <a href="client-profile">Tressa Wexler <span>Manager</span></a>--}}
        {{--                                            </h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>tressawexler@example.com</td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="dropdown action-label">--}}
        {{--                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
        {{--                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2 class="table-avatar">--}}
        {{--                                                <a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-07.jpg"></a>--}}
        {{--                                                <a href="client-profile">Ruby Bartlett <span>CEO</span></a>--}}
        {{--                                            </h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>rubybartlett@example.com</td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="dropdown action-label">--}}
        {{--                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
        {{--                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2 class="table-avatar">--}}
        {{--                                                <a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-06.jpg"></a>--}}
        {{--                                                <a href="client-profile"> Misty Tison <span>CEO</span></a>--}}
        {{--                                            </h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>mistytison@example.com</td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="dropdown action-label">--}}
        {{--                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
        {{--                                                    <i class="fa fa-dot-circle-o text-success"></i> Active--}}
        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2 class="table-avatar">--}}
        {{--                                                <a href="client-profile" class="avatar"><img alt="" src="img/profiles/avatar-14.jpg"></a>--}}
        {{--                                                <a href="client-profile"> Daniel Deacon <span>CEO</span></a>--}}
        {{--                                            </h2>--}}
        {{--                                        </td>--}}
        {{--                                        <td>danieldeacon@example.com</td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="dropdown action-label">--}}
        {{--                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">--}}
        {{--                                                    <i class="fa fa-dot-circle-o text-danger"></i> Inactive--}}
        {{--                                                </a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>--}}
        {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                </tbody>--}}
        {{--                            </table>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-footer">--}}
        {{--                        <a href="clients">View all clients</a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-md-6 d-flex">--}}
        {{--                <div class="card card-table flex-fill">--}}
        {{--                    <div class="card-header">--}}
        {{--                        <h3 class="card-title mb-0">Recent Projects</h3>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body">--}}
        {{--                        <div class="table-responsive">--}}
        {{--                            <table class="table custom-table mb-0">--}}
        {{--                                <thead>--}}
        {{--                                    <tr>--}}
        {{--                                        <th>Project Name </th>--}}
        {{--                                        <th>Progress</th>--}}
        {{--                                        <th class="text-right">Action</th>--}}
        {{--                                    </tr>--}}
        {{--                                </thead>--}}
        {{--                                <tbody>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="project-view">Office Management</a></h2>--}}
        {{--                                            <small class="block text-ellipsis">--}}
        {{--                                                <span>1</span> <span class="text-muted">open tasks, </span>--}}
        {{--                                                <span>9</span> <span class="text-muted">tasks completed</span>--}}
        {{--                                            </small>--}}
        {{--                                        </td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="progress progress-xs progress-striped">--}}
        {{--                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="65%" style="width: 65%"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="project-view">Project Management</a></h2>--}}
        {{--                                            <small class="block text-ellipsis">--}}
        {{--                                                <span>2</span> <span class="text-muted">open tasks, </span>--}}
        {{--                                                <span>5</span> <span class="text-muted">tasks completed</span>--}}
        {{--                                            </small>--}}
        {{--                                        </td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="progress progress-xs progress-striped">--}}
        {{--                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="15%" style="width: 15%"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="project-view">Video Calling App</a></h2>--}}
        {{--                                            <small class="block text-ellipsis">--}}
        {{--                                                <span>3</span> <span class="text-muted">open tasks, </span>--}}
        {{--                                                <span>3</span> <span class="text-muted">tasks completed</span>--}}
        {{--                                            </small>--}}
        {{--                                        </td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="progress progress-xs progress-striped">--}}
        {{--                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="49%" style="width: 49%"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="project-view">Hospital Administration</a></h2>--}}
        {{--                                            <small class="block text-ellipsis">--}}
        {{--                                                <span>12</span> <span class="text-muted">open tasks, </span>--}}
        {{--                                                <span>4</span> <span class="text-muted">tasks completed</span>--}}
        {{--                                            </small>--}}
        {{--                                        </td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="progress progress-xs progress-striped">--}}
        {{--                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="88%" style="width: 88%"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                    <tr>--}}
        {{--                                        <td>--}}
        {{--                                            <h2><a href="project-view">Digital Marketplace</a></h2>--}}
        {{--                                            <small class="block text-ellipsis">--}}
        {{--                                                <span>7</span> <span class="text-muted">open tasks, </span>--}}
        {{--                                                <span>14</span> <span class="text-muted">tasks completed</span>--}}
        {{--                                            </small>--}}
        {{--                                        </td>--}}
        {{--                                        <td>--}}
        {{--                                            <div class="progress progress-xs progress-striped">--}}
        {{--                                                <div class="progress-bar" role="progressbar" data-toggle="tooltip" title="100%" style="width: 100%"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                        <td class="text-right">--}}
        {{--                                            <div class="dropdown dropdown-action">--}}
        {{--                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>--}}
        {{--                                                <div class="dropdown-menu dropdown-menu-right">--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
        {{--                                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </td>--}}
        {{--                                    </tr>--}}
        {{--                                </tbody>--}}
        {{--                            </table>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-footer">--}}
        {{--                        <a href="projects">View all projects</a>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </div>
   @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='SuperAdmin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO')
       <script>
           var chart = Highcharts.chart('yearly', {

               chart: {
                   type: ''
               },
               title: {
                   text: 'Income,Expense and Profit'
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
                   categories: ['Jan','Feb','March','April','May','June','July','Aug','Sep','Oct','Nov','Dec'],
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
                   name: 'Income',
                   data: [
                       {{$monthly_income['Jan']->total??0}},
                       {{$monthly_income['Feb']->total??0}},
                       {{$monthly_income['March']->total??0}},
                       {{$monthly_income['April']->total??0}},
                       {{$monthly_income['May']->total??0}},
                       {{$monthly_income['June']->total??0}},
                       {{$monthly_income['July']->total??0}},
                       {{$monthly_income['Aug']->total??0}},
                       {{$monthly_income['Sep']->total??0}},
                       {{$monthly_income['Oct']->total??0}},
                       {{$monthly_income['Nov']->total??0}},
                       {{$monthly_income['Dec']->total??0}},
                   ]
               }, {
                   name: 'Expense',
                   data: [
                       {{$monthly_expense['Jan']->total??0}},
                       {{$monthly_expense['Feb']->total??0}},
                       {{$monthly_expense['March']->total??0}},
                       {{$monthly_expense['April']->total??0}},
                       {{$monthly_expense['May']->total??0}},
                       {{$monthly_expense['June']->total??0}},
                       {{$monthly_expense['July']->total??0}},
                       {{$monthly_expense['Aug']->total??0}},
                       {{$monthly_expense['Sep']->total??0}},
                       {{$monthly_expense['Oct']->total??0}},
                       {{$monthly_expense['Nov']->total??0}},
                       {{$monthly_expense['Dec']->total??0}},


                   ]
               },{
                   name:'Profit',
                   data:[
                       {{$profit['Jan']??0}},
                       {{$profit['Feb']??0}},
                       {{$profit['March']??0}},
                       {{$profit['April']??0}},
                       {{$profit['May']??0}},
                       {{$profit['June']??0}},
                       {{$profit['July']??0}},
                       {{$profit['Aug']??0}},
                       {{$profit['Sep']??0}},
                       {{$profit['Oct']??0}},
                       {{$profit['Nov']??0}},
                       {{$profit['Dec']??0}},
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
           $(document).ready(function () {
               var current_year=$('input[type=radio]:checked').val();
               if(current_year==1){
                   $('#total_income').text("{{$items['total_income']??0}}");
                   $('#total_expense').text("{{$items['total_expense']??0}}");
                   $('#total_profit').text("{{$items['profit']??0}}");
               }
               $('input[type=radio]').on('change', function() {
                   var type=$(this).val();
                   if(type==1){
                       $('#total_income').text("{{$items['total_income']??0}}");
                       $('#total_expense').text("{{$items['total_expense']??0}}");
                       $('#total_profit').text("{{$items['profit']??0}}");
                   }else if (type==2) {
                       $('#total_income').text("{{$items['first_term_income']??0}}");
                       $('#total_expense').text("{{$items['first_term_expense']??0}}");
                       $('#total_profit').text("{{$items['first_term_profit']??0}}");
                   }else if(type==3){
                       $('#total_income').text("{{$items['second_term_income']??0}}");
                       $('#total_expense').text("{{$items['second_term_expense']??0}}");
                       $('#total_profit').text("{{$items['second_term_profit']??0}}");
                   }else{
                       $('#total_income').text("{{$items['current_month_income']??0}}");
                       $('#total_expense').text("{{$items['current_month_expense']??0}}");
                       $('#total_profit').text("{{$items['current_month_profit']??0}}");
                   }

               });
           });
       </script>
    @endif
@endsection

