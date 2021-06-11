@extends('layout.mainlayout')
@section('content')
    <style>
        .scroll {
            /*width: 300px;*/
            height: 300px;
            overflow: scroll;
        }
        .next_plan_content{
            height: 400px;
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
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Lead Detail</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Next Plan</a>
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
                        <form method="POST" action="{{url("/lead/post/comment")}}" class="mt-2">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="form-group col-xl-9 col-md-9 col-9 ml-5">
                                    <input type="hidden" name="lead_id" value="{{$lead->id}}">
                                    <input type="text" class="form-control" name="comment">
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit" style="font-size: 20px;"><i class="fa fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card next_plan_content">
                        <div class="card-body">
                            <div class="project-title">
                                <h4 class="card-title">Description</h4>
                            </div>
                            @if($next_plan!=null)
                                {!!$next_plan->description!!}
                            @else
                                This lead does not have next plan.
                            @endif
                        </div>
                        @if($next_plan!=null)
                            <div class="card-footer">
                                Duration Date : <strong>  {{\Carbon\Carbon::parse($next_plan->from_date)->format('d-m-Y')}}</strong>  To  <strong>{{\Carbon\Carbon::parse($next_plan->to_date)->format('d-m-Y')}}</strong>
                                @if($next_plan->work_done!=1)
                                    @if(\Carbon\Carbon::now()>$next_plan->to_date)
                                        <button class="btn btn-primary float-right">Overdue Date</button>
                                    @else
                                        <a href="{{route('workdone',$lead->id)}}" class="btn btn-primary float-right">Done</a>
                                    @endif
                                @else
                                    <button class="btn btn-primary float-right">Complete Next Plan</button>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title m-b-15">Lead details</h6>
                        <table class="table table-striped table-border">
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
                        {{--                            <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>--}}
                        {{--                            <div class="progress progress-xs mb-0">--}}
                        {{--                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: 40%"></div>--}}
                        {{--                            </div>--}}
                    </div>
                </div>
                <div class="project-members task-followers">
                    <span class="followers-title">Followers</span>
                    @foreach($followers as $follower)
                        <a href="#" data-toggle="tooltip" title="{{$follower->user->name}}" class="avatar">
                            <img src="img/profiles/avatar-09.jpg" alt="">
                        </a>
                    @endforeach
                    <a href="#" class="followers-add" data-toggle="modal" data-target="#add_followers"><i class="material-icons">add</i></a>
                    <a href="#" class="followers-add ml-2" data-toggle="modal" data-target="#remove_followers"><i class="la la-trash"> </i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
    <div id="add_followers" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Follower</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('leads.followed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" value="{{$lead->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($allemps as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Follow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="remove_followers" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">UnFollow</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('unfollowed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" value="{{$lead->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($allemps as $emp)
                                    @foreach($followers as $follower)
                                        @if($follower->user->id==$emp->id)
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endif

                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">UnFollow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Assign User Modal -->


    <script>
        $("#review").rating({
            "value":$("#prioriyt").val(),
            "stars":3,
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
