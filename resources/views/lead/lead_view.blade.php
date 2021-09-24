@extends('layout.mainlayout')
@section('title','Lead Details')
@section('content')
    <style>
        .scroll {
            /*width: 300px;*/
            height: 300px;
            overflow: scroll;
        }

        .next_plan_content {
            height: 600px;
            overflow: scroll;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <script src="{{asset("/js/rating.js")}}"></script>
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{$lead->title}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("leads")}}">Lead</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route("leads.edit",$lead->id)}}" class="btn add-btn"><i class="fa fa-edit"></i> Edit Lead</a>
                    @if($lead->is_qualified==1)
                        <a href="{{route('qualified',$lead->id)}}" class="btn add-btn mr-2"><i class="fa fa-check"></i>Qualified</a>
                    @else
                        <a href="{{route('qualified',$lead->id)}}" class="btn add-btn mr-2"><i class="fa fa-square"></i>Qualified</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Lead Detail</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile" aria-selected="false">Activity Schedule</a>
            </li>
        </ul>
        <div class="row">
            <div class="tab-content col-lg-8 col-xl-8" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card scroll">
                        <div class="card-body">
                            <div class="project-title">
                                <h4 class="card-title">{{$lead->title}}</h4>
                            </div>
                            {!!$lead->description!!}
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-body scroll">
                            <h5 class="card-title m-b-20">Comments</h5>
                            <ul class="files-list">
                                @foreach($comments as $comment)
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                            <a href="profile" class="avatar">
                                                <img src="img/profiles/avatar-02.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <span class="task-chat-user">{{$comment->user->name}}</span>
                                                    <p>{{$comment->comment}}</p>
                                                    <span class="chat-time">{{$comment->created_at->toFormattedDateString()}} at {{date('h:i:s a', strtotime($comment->created_at))}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                        <hr>
                        <form method="POST" action="{{url("/lead/post/comment")}}" class="mt-2">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-xl-9 col-md-9 col-9">
                                    <input type="hidden" name="lead_id" value="{{$lead->id}}">
                                    <div class="form-group col-12">
                                        <input type="text" class="form-control" name="comment">
                                    </div>
                                </div>
                                <div class=" col-3">
                                    <div class="row">
                                        <button class="btn btn-primary col-8" type="submit" style="font-size: 20px;">Add Note</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card next_plan_content">
                        <div class="card-header">
                            <div class="bs-offset-main bs-canvas-anim">
                                <button class="btn btn-primary" type="button" data-toggle="canvas"
                                        data-target="#bs-canvas-left" aria-expanded="false"
                                        aria-controls="bs-canvas-right">Add New
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($next_plan as $activity)
                                <div class="row border rounded my-1">
                                    <div class="col-md-12 border-bottom my-1">
                                        <div class="float-left">
                                            <span class="badge badge-primary">  {{\Carbon\Carbon::parse($activity->from_date)->format('d-m-Y')}}</span>
                                            To
                                            <span class="badge badge-danger">{{\Carbon\Carbon::parse($activity->to_date)->format('d-m-Y h:m:a')}}</span>
                                        </div>
                                        <a href="{{route('delete_schedule',$activity->id)}}" class="float-right"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div class="col-md-9 my-2">{!!$activity->description!!}</div>

                                    <div class="col-md-3 my-2">
                                        @if($activity->work_done!=1)
                                            @if(\Carbon\Carbon::now()>$activity->to_date)
                                                <button class="btn btn-danger float-right bt">Overdue Date</button>
                                            @else
                                                <a href="{{route('workdone',$activity->id)}}"
                                                   class="btn btn-primary float-right">Done</a>
                                            @endif
                                        @else
                                            <button class="btn btn-success float-right"><i
                                                        class="la la-check-circle-o"></i> Complete
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-left position-fixed bg-light h-100"
         style="max-width: 250px">
        <header class="bs-canvas-header p-3 bg-primary overflow-auto">
            <button type="button" class="bs-canvas-close float-right close" aria-label="Close"><span aria-hidden="true"
                                                                                                     class="text-light">&times;</span>
            </button>
            <h4 class="d-inline-block text-light mb-0 float-left">Add Activity Schedule</h4>
        </header>
        <div class="bs-canvas-content px-3 py-5">
            <form action="{{route('activity.schedule')}}" method="post">
                @csrf
                <input type="hidden" name="lead_id" value="{{$lead->id}}">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-danger ml-2 text-sm  btn-sm" id="add">Add Item</button>
                </div>
            </form>
        </div>

    </div>
            <div class="col-lg-4 col-xl-4">
        <div class="card-body col-md-12">
            <h6 class="card-title">Lead details</h6>
            <table class="col-12 table table-striped table-border">
                <tbody>
                <tr>
                    <td>Lead ID:</td>
                    <td class="text-right">{{$lead->lead_id}}</td>
                </tr>
                <tr>
                    <td>Sale Person:</td>
                    <td class="text-right">{{$lead->saleMan->name}}</td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td class="text-right">{{$lead->customer->name}}</td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td class="text-right">{{$lead->customer->email}}</td>
                </tr>
                <tr>
                    <td>Contact Phone:</td>
                    <td class="text-right">{{$lead->customer->phone}}</td>
                </tr>
                <tr>
                    <td>Priority:</td>
                    <td class="text-right">
                        {{$lead->priority}}
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td class="text-right">
                        @if($lead->is_qualified==1)
                            Qualified
                        @else
                            Unqualified
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="project-members task-followers">
            <span class="followers-title">Followers</span>
            @foreach($followers as $follower)
                <a href="#" data-toggle="tooltip" title="{{$follower->user->name}}" class="avatar">
                    <img src="img/profiles/avatar-09.jpg" alt="">
                </a>
            @endforeach
            <a href="#" class="followers-add" data-toggle="modal" data-target="#add_followers"><i
                        class="material-icons">add</i></a>
            <a href="#" class="followers-add ml-2" data-toggle="modal" data-target="#remove_followers"><i
                        class="la la-trash"> </i></a>
        </div>
    </div>
        </div>
    </div>

    <!-- /Assign User Modal -->


    <script>
        $("#review").rating({
            "value": $("#prioriyt").val(),
            "stars": 3,
            "click": function (e) {
                console.log(e);
                $("#starsInput").val(e.stars);
            }
        });
        $(document).ready(function () {
            $(".mul-select").select2({
                placeholder: "Select Employee", //placeholder
                tags: true,
                tokenSeparators: ['/', ',', ';', " "]
            });
        });
    </script>
    <!-- /Page Wrapper -->
@endsection
