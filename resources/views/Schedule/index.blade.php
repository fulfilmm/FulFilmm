@extends('layout.mainlayout')
@section('title','Schedules List')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Schedules </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Schedules</li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#lead_schedule" role="tab" aria-controls="home" aria-selected="true">Lead Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#deal_schedule" role="tab" aria-controls="profile" aria-selected="false">Deal Schedule</a>
            </li>
        </ul>
        <form action="{{route('schedule.index')}}" method="get">
            @csrf
            <div class="row">
                <div class="col">
                    <select name="customer_id" id="" class="form-control">
                        <option value="">None</option>
                        @foreach($customers as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="end_date">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        {{--@dd($stock)--}}
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="lead_schedule" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-12 col-xl-12">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">Employee</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($next_plan as $activity)
                            <tr class="fw-normal">
                                <th>
                                    <img src="{{$activity->employee->profile_img!=null? url(asset('img/profiles/'.$activity->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                         class="shadow-1-strong rounded-circle" alt="avatar 1"
                                         style="width: 55px; height: auto;">
                                    <span class="ms-2">{{$activity->employee->name}}</span>
                                </th>
                                <th class="align-middle">{{$activity->customer->name}}</th>
                                <td class="align-middle">
                                    {{$activity->description}}
                                </td>
                                <td class="align-middle">
                                    <span>{{$activity->type}}</span>
                                </td>
                                <td class="align-middle">{{\Carbon\Carbon::parse($activity->date_time)->toFormattedDateString()}} {{date('h:i a', strtotime(\Carbon\Carbon::parse($activity->date_time)))}}</td>
                                <td class="align-middle">
                                    <h6 class="mb-0"> @if($activity->work_done!=1)
                                            @if(\Carbon\Carbon::now()>$activity->date_time)
                                                <span class="text-danger"> Overdue </span>
                                            @else
                                                <span class="text-info">Working</span>
                                            @endif
                                        @else
                                            <span class="text-success  btn-sm mr-3"> Done
                                                                           </span>
                                        @endif</h6>
                                </td>
                                <td class="align-middle">
                                    <a href="{{route('work.done',$activity->id)}}"
                                       class="btn btn-info  btn-sm mr-3">Done</a>
                                    <a href="{{route('delete_schedule',$activity->id)}}"
                                       class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="deal_schedule" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-12 col-xl-12">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">Employee</th>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schedules as $activity)
                            <tr class="fw-normal">
                                <th>
                                    <img src="{{$activity->employee->profile_img!=null? url(asset('img/profiles/'.$activity->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                         class="shadow-1-strong rounded-circle" alt="avatar 1"
                                         style="width: 55px; height: auto;">
                                    <span class="ms-2">{{$activity->employee->name}}</span>
                                </th>
                                <td class="align-middle">
                                    {{$activity->description}}
                                </td>
                                <td class="align-middle">{{$activity->type}}</td>
                                <td class="align-middle">{{\Carbon\Carbon::parse($activity->from_date)->toFormattedDateString()}}</td>
                                <td class="align-middle">
                                    @if($activity->work_done!=1)
                                        @if($activity->type=="Meeting")
                                            @if(\Carbon\Carbon::now()>$activity->meeting_time)
                                                <span class="text-danger">Overdue</span>
                                            @else
                                                <span class="text-info">Working</span>
                                            @endif
                                        @else
                                            @if(\Carbon\Carbon::now()>$activity->to_date)
                                                <span class="text-danger">Overdue</span>
                                            @else
                                                <span class="text-info">Working</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="text-success"> Complete
                                                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="row">
                                        <a href="{{route('schedule.done',$activity->id)}}"
                                           class="btn btn-info  btn-sm mr-3">Done</a>
                                        <a href="{{route('delete_schedule',$activity->id)}}"
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection