@extends('layout.mainlayout')
@section('title','Deal Detail View')
@section('content')
    <style>
        .scroll {
            /*width: 300px;*/
            max-height: 350px;
            overflow: scroll;
        }
        .activity_schedule{
            min-height: 200px;
            max-height: 400px;
            overflow: scroll;
        }

    </style>
    <link rel="stylesheet" href="{{url(asset('customercss/customershow.css'))}}">
    <!-- Page Wrapper -->
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-8 message-view task-view">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-left ticket-view-details">
                                <div class="ticket-header justify-content-between">
                                    <span>Sale Stage: </span> <span class="badge badge-warning">{{$deal->sale_stage}}</span>
                                    <span class="m-l-15 text-muted">Organization: </span>
{{--                                    @dd($deal)--}}
                                    <a href="#">{{$deal->customer_company->name}}</a>
                                    <span class="m-l-15 text-muted">Submitted by:</span>
                                    <span><a href="{{route('employees.show',$deal->created_person->id)}}"><img src="{{$deal->created_person->profile_img!=null? url(asset('img/profiles/'.$deal->created_person->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar avatar-xs">{{$deal->created_person->name}}</a></span>

                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">Description</div>
                        <div class="card-body">
                           <p>{!! $deal->description !!}</p>
                        </div>
                        <div class="card-footer mb-3">
                            <strong>Notes : </strong><span>{{$deal->next_step}}</span>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-body p-0">
                            <ul class="nav tab-nav-pane nav-tabs pt-2 mb-0">
                                <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2 active" href="#activity">Activity Schedule</a></li>
                                <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2" href="#comment">Comment </a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="activity" class="tab-pane fade show active p-3">
                                    <div class="bs-offset-main bs-canvas-anim">
                                        <button class="btn btn-primary btn-sm" type="button" data-toggle="canvas"
                                                data-target="#bs-canvas-left" aria-expanded="false"
                                                aria-controls="bs-canvas-right">Add New
                                        </button>
                                    </div>

                                    <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative activity_schedule">

                                        <ul class="list-inline p-0 m-0">
                                            @foreach($schedules as $activity)
                                                <li>
                                                    <div class="pt-5">

                                                        <h5>{{$activity->type}}</h5>
                                                        <div class="timeline-dots timeline-dot1 border-primary text-primary mt-5"></div>
                                                        @if($activity->type=='Meeting')

                                                            <p class="mb-0 text-muted font-weight-bold text-uppercase">{{\Carbon\Carbon::parse($activity->meeting_time)->toFormattedDateString()}} {{date('h:i a', strtotime($activity->meeting_time))}}</p>
                                                            @else
                                                            <p class="mb-0 text-muted font-weight-bold text-uppercase">{{\Carbon\Carbon::parse($activity->from_date)->toFormattedDateString()}} - {{\Carbon\Carbon::parse($activity->to_date)->toFormattedDateString()}}</p>
                                                            @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-inline-block w-100">
                                                        <div class="d-inline-block w-100">
                                                            <p>{{$activity->description}}</p>
                                                        </div>
                                                        @if($activity->work_done!=1)
                                                           @if($activity->type=="Meeting")
                                                                @if(\Carbon\Carbon::now()>$activity->meeting_time)
                                                                    <a href="{{route('schedule.done',$activity->id)}}" class="btn btn-danger float-right btn-sm mr-3">Overdue Date</a>
                                                                @else
                                                                    <a href="{{route('schedule.done',$activity->id)}}"
                                                                       class="btn btn-primary float-right btn-sm mr-3">Done</a>
                                                                @endif
                                                               @else
                                                                @if(\Carbon\Carbon::now()>$activity->to_date)
                                                                    <a href="{{route('schedule.done',$activity->id)}}" class="btn btn-danger float-right btn-sm mr-3">Overdue Date</a>
                                                                @else
                                                                    <a href="{{route('schedule.done',$activity->id)}}"
                                                                       class="btn btn-primary float-right btn-sm mr-3">Done</a>
                                                                @endif
                                                               @endif
                                                        @else
                                                            <button class="btn btn-success float-right btn-sm mr-3"><i
                                                                        class="la la-check-circle-o"></i> Complete
                                                            </button>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div id="comment" class="tab-pane fade p-3">
                                    <div class="card ">
                                        <div class="card-body scroll">
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
                                        <form method="POST" action="{{url("/deal/post/comment")}}" class="mt-2">
                                            {{csrf_field()}}
                                            <div class="row " >
                                                <div class="col-xl-9 col-md-9 col-9">
                                                    <input type="hidden" name="deal_id" value="{{$deal->id}}">
                                                    <div class="input-group col-12" >
                                                        <input type="text" class="form-control" name="comment" style="border-color: black">
                                                        <button class="btn btn-outline-dark" type="submit" >Add Note</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 message-view task-chat-view ticket-chat-view" id="task_window">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="task-assign">
                                <span class="assign-title">Assigned to </span>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$deal->employee->name??''}}" class="avatar">
                                    <img src="{{$deal->assign_to!=null? url(asset('img/profiles/'.$deal->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar avatar-sm"></a>
{{--                                            <a href="#" class="followers-add" title="Reassign" data-toggle="modal" data-target="#assignee"><i class="la la-arrow-right"></i></a>--}}
                                <span class="mt-3">{{$deal->employee->name??''}}</span>
                            </div>
                            <ul class="nav float-right custom-menu">
                                <li class="nav-item dropdown dropdown-action">
                                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit Deal</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket">Delete Deal</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                   <div class="col-12">
                                    <h4 class="mt-2">More Information</h4>
                                   </div>
                                    <div class="chats">
                                        <div class="row ">
                                            <div class="col-6">
                                                <span>Contact</span>
                                            </div>
                                            <div class="col-6">:<a href="{{route('customers.show',$deal->customer->id)}}"> <img src="{{$deal->customer->profile!=null? url(asset('img/profiles/'.$deal->customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar avatar-sm">{{$deal->customer->name}}</a></div>
                                        </div>
                                        <div class="row mt-2 ">
                                            <div class="col-6">
                                                <span>Pipe Line</span>
                                            </div>
                                            <div class="col-6">: {{$deal->pipeline}}</div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <span>Amount</span>
                                            </div>
                                            <div class="col-6">: {{$deal->amount}} {{$deal->unit}}</div>
                                        </div>
                                        <div class="row mt-2" >
                                            <div class="col-6">
                                                <span>Lead Source</span>
                                            </div>
                                            <div class="col-6">: {{$deal->lead_source}}</div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <span>Expected Close Date</span>
                                            </div>
                                            <div class="col-6">: {{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString()}}</div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <span>Probability</span>
                                            </div>
                                            <div class="col-6">: {{$deal->probability}} %</div>
                                        </div>
                                       @if($deal->contact!=null)
                                            <div class="row mt-2"  >
                                                <div class="col-6">
                                                    <span>Customer Contact</span>
                                                </div>
                                                <div class="col-6">: {{$deal->contact}}</div>

                                            </div>
                                           @endif
                                        @if($deal->type!=null)
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <span>Type</span>
                                            </div>
                                            <div class="col-6">: {{$deal->type}}</div>
                                        </div>
                                        @endif
                                        @if($deal->weighted_revenue!=null)
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <span>Weighted Revenue</span>
                                            </div>
                                            <div class="col-6">: {{$deal->weighted_revenue}} {{$deal->weighed_revenue_unit}}</div>
                                        </div>
                                        @endif
                                        @if($deal->lost_reason!=null)
                                        <div class="row mt-2" >
                                            <div class="col-6">
                                                <span>Lost Reason</span>
                                            </div>
                                            <div class="col-6">: {{$deal->lost_reason}}</div>
                                        </div>
                                        @endif
                                        <div class="row mt-2" >
                                            <div class="col-6">
                                                <span>Created at</span>
                                            </div>
                                            <div class="col-6">: {{$deal->created_at->toFormattedDateString()}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed bg-light h-100"
         style="max-width: 300px">
        <header class="bs-canvas-header p-3 bg-primary overflow-auto">
            <button type="button" class="bs-canvas-close float-left close" aria-label="Close"><span aria-hidden="true"
                                                                                                    class="text-dark">&times;</span>
            </button>
            <strong class="d-inline-block text-light mb-0  ml-2 float-left">Add Activity Schedule</strong>
        </header>
        <div class="bs-canvas-content px-3 py-5">
            <form action="{{route('deals.schedule')}}" method="post">
                @csrf
                <input type="hidden" name="deal_id" value="{{$deal->id}}">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="act_type">Schedule Type</label>
                    <select name="type" id="act_type" class="form-control" >
                        <option value="Cold Calling">Cold Calling</option>
                        <option value="Phone Call">Phone Call</option>
                        <option value="Follow Up">Follow Up</option>
                        <option value="Meeting">Meeting</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Event">Event</option>
                        <option value="Visit">Visit</option>
                    </select>
                </div>
                <div class="form-group" id="start_date_div">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group" id="end_date_div">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
                <div class="form-group" id="meeting_time">
                    <label>Meeting Date </label>
                    <input type="date" class="form-control" name="meeting_time">
                </div>
                <div class="form-group">
                    <label for="time" id="time_label">End Time</label>
                    <input type="time" class="form-control" id="time" name="time">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-outline-danger ml-2 text-sm  btn-md" id="add">Add Item</button>
                </div>
            </form>
        </div>

    </div>
    <script>
       $(document).ready(function () {
           $('#meeting_time').hide();
           $(document).on('change','#act_type',function () {
               var type=$(this).val();
               if(type=='Meeting'){
                   $('#start_date_div').hide();
                   $('#end_date_div').hide();
                   $('#time_label').html('Time');
                   $('#meeting_time').show();
               }else {
                   $('#start_date_div').show();
                   $('#end_date_div').show();
                   $('#time_label').html('End Time')
                   $('#meeting_time').hide();
               }
           });
       })
    </script>
    <!-- /Page Wrapper -->
@endsection
