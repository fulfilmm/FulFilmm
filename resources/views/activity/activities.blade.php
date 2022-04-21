@extends('layout.mainlayout')
@section('noti_section')
    <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{count($unreach_activity)}}</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Sale Activity Notifications</span>
                {{--                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    @foreach($unreach_activity as $alert)
                        <li class="notification-message">
                            <a href="{{route('activity.show',$alert->id)}}">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details">Add new activity <span
                                                    class="noti-title"> {{$alert->title}}</span><span
                                                    class="noti-title"> submitted by {{$alert->employee->name}}. </span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">{{\Carbon\Carbon::parse($alert->date)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($alert->date)))}}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="">View all Notifications</a>
            </div>
        </div>
    </li>
@endsection
@section('title','Sale Activities')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div>
                    <h3 class="page-title">Sales Activities</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sales Activities</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('activity.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add
                        Activity</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" title="Task View" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="la la-tasks"></i></a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" title="Table View" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="la la-table"></i></a>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="activity">
                            <div class="activity-box">
                                <ul class="activity-list">
                                    @foreach($activities as $activity)
                                        <li>
                                            <div class="activity-user">
                                                <a href="profile" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                    <img src="img/profiles/avatar-01.jpg" alt="">
                                                </a>
                                            </div>

                                            <div class="activity-content ">
                                                <div class="timeline-content">
                                                    <a href="{{route('employees.show',$activity->emp_id)}}"
                                                       class="name">{{$activity->employee->name}}</a> added activity <a
                                                            href="{{route('activity.show',$activity->id)}}">{{$activity->title}}</a><span
                                                            class="float-right">Follower </span>
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach($followers as $follower)
                                                        @if($follower->activity_id==$activity->id)
                                                            @if( $i <3)
                                                                <span class="float-right">
                                                        <a href="{{route('employees.show',$follower->id)}}" title="{{$follower->employee->name}}" data-toggle="tooltip" class="avatar">
                                                    <img src="{{$follower->employee->profile_img!=null? url(asset('img/profiles/'.$follower->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt=""></a>
                                                    </span>
                                                            @endif
                                                            @php
                                                                $i ++;

                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if($i>3)
                                                        <span class="float-right avatar"><i class="fa fa-plus" style="font-size: 9px"></i>{{$i - 3}}</span>
                                                    @endif
                                                    <span class="time">{{\Carbon\Carbon::parse($activity->date)->toFormattedDateString()}} <span class="badge badge-{{$activity->status==0?'danger':'success'}} ml-5" style="height: 18px;font-size: 11px">{{$activity->status==0?'New':'Aknowledge'}}</span></span>

                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Township</th>
                                <th>Type</th>
                                <th>Report To</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activities as $activity)
                            <tr>
                                <td>{{$activity->title}}</td>
                                <td>{{\Carbon\Carbon::parse($activity->date)->toFormattedDateString()}}</td>
                                <td>{{$activity->customer->name??'N/A'}}</td>
                                <td>{{$activity->township??'N/A'}}</td>
                                <td>{{$activity->type}}</td>
                                <td>{{$activity->report->name}}</td>
                                <td>{{$activity->created_at->toFormattedDateString()}}</td>
                                <td>
                                    <a href="{{route('activity.show',$activity->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->
@endsection