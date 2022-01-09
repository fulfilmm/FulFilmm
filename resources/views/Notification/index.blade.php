@extends('layout.mainlayout')
@section('title','All Notification')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">All Notifications</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notification</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="activity">
                    <div class="activity-box">
                        <ul class="activity-list">
                            @foreach($allnotification as $allnoti)

                                <li>
                                    <a href="{{route('notifications.show',$allnoti->uuid)}}">
                                    <div class="activity-user">
                                        <a href="profile" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                            @if($allnoti->notifier==null)
                                                <img src="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->profile_img!=null? url(asset('img/profiles/'.\Illuminate\Support\Facades\Auth::guard('employee')->user()->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
                                                @else
                                            <img src="{{$allnoti->notifier->profile_img!=null? url(asset('img/profiles/'.$allnoti->notifier->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
                                       @endif
                                        </a>
                                    </div>

                                    <div class="activity-content ">
                                        <div class="timeline-content">
                                            <a href="{{route('employees.show',$allnoti->notifier==null?$allnoti->notify_user_id:$allnoti->notifier->id)}}"
                                               class="name">{{$allnoti->notifier==null?$allnoti->notify_user->name:$allnoti->notifier->name}}</a> <a
                                                    href="{{route('notifications.show',$allnoti->uuid)}}">{{$allnoti->message}}</a>
                                            <div class="float-right">
                                                <a href="{{route('notifications.delete',$allnoti->id)}}"
                                                   class="followers-add" data-toggle="tooltip"
                                                   data-placement="bottom"><i class="la la-trash-o"></i></a>
                                            </div>
                                            <span class="time">{{\Carbon\Carbon::parse($allnoti->created_at)->toFormattedDateString()}} </span>

                                        </div>

                                    </div>
                                    </a>
                                </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection