@extends('layout.mainlayout')
@section('title','Meetings')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Meeting</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Meeting</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('meetings.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Meeting</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">My Created Meeting</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Meeting Invite Me</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Meeting Title</th>
                            <th>Date</th>
                            <th>Meeting Type</th>
                            <th>Address/Link</th>
                            <th>Room No./Password</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meetings as $meeting)

                            <tr>
                                <td>{{$meeting->title}}</td>
                                <td>{{\Carbon\Carbon::parse($meeting->due_date)->toFormattedDateString()}}</td>
                                <td>{{$meeting->meeting_type}}</td>
                                <td>{{$meeting->room_no  ? $meeting->meeting_room->address:$meeting->link_id}}</td>
                                <td>{{$meeting->room_no ? $meeting->meeting_room->room_no :$meeting->password}}</td>
                                <th><a href="{{route('meetings.show',$meeting->id)}}" class="btn btn-outline-info btn-sm" ><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$meeting->id}}"><i class="fa fa-trash-o"></i></a>
                                </th>
                                @include('meeting.delete')
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Meeting Title</th>
                            <th>Date</th>
                            <th>Meeting Type</th>
                            <th>Address/Link</th>
                            <th>Room No./Password</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invites_me as $invite_me)
                            <tr>
                                <td>{{$invite_me->meeting->title}}</td>
                                <td>{{\Carbon\Carbon::parse($invite_me->meeting->due_date)->toFormattedDateString()}}</td>
                                <td>{{$invite_me->meeting->meeting_type}}</td>
                                <td>{{$invite_me->meeting->address ? :$invite_me->meeting->link_id}}</td>
                                <td>{{$invite_me->meeting->room_no ? :$invite_me->meeting->password}}</td>
                                <th><a href="{{route('meetings.show',$invite_me->meeting->id)}}" class="btn btn-outline-info btn-sm" ><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$invite_me->meeting->id}}"><i class="fa fa-trash-o"></i></a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Content -->
@endsection
