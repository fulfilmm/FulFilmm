@extends('layout.mainlayout')
@section('content')
<!-- Page Wrapper -->
<div class="chat-main-row">
    <div class="chat-main-wrapper">
        <div class="col-lg-8 message-view task-view">
            <div class="chat-window">
                <div class="fixed-header">
                    <div class="navbar">
                        <div class="float-left ticket-view-details">
                            <div class="ticket-header">
                                <span>Status: </span> <span class="badge badge-warning">{{$ticket->ticket_status->name}}</span> <span class="m-l-15 text-muted">Client: </span>
                                <a href="#">{{$ticket->sender_info->name}}</a>
                                <span class="m-l-15 text-muted">Created: </span>
                                <span>{{$ticket->created_at->toFormattedDateString()}} at {{date('h:i:s a', strtotime($ticket->created_at))}}</span>
                                <span class="m-l-15 text-muted">Created by:</span>
                               @if($ticket->created_emp_id==null)
                                    <span><a href="profile">Guest</a></span>
                                   @else
                                <span><a href="profile">{{$ticket->created_by->name}}</a></span>
                                   @endif
                            </div>
                        </div>
                        <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                    </div>
                </div>
                <br>

                <div class="text-center">
                    @if(\Carbon\Carbon::now()>$end)
                        <h4 class="text-danger">TimeUp! {{Carbon\Carbon::parse($end)->diffForHumans() }}</h4>
                        @endif
                    <span id="end" ></span>
                    <b id="days"></b>  <b id="hours"></b>
                    <b id="mins"></b>
                    <b id="secs"></b>
                </div>
                <span id="clock-placeholder"></span>
                <div class="chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="task-wrapper">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="project-title">
                                                <div class="m-b-20">
                                                    <span class="h5 card-title ">{{$ticket->title}}</span>
                                                    <div class="float-right ticket-priority"><span>Priority:</span>
                                                        <div class="btn-group">
                                                            <a href="#" class="badge badge-danger dropdown-toggle" data-toggle="dropdown">{{$ticket->ticket_priority->priority}} </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{$ticket->message}}</p>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-20">Uploaded image files</h5>
                                            <div class="row">
                                               @if($photos!=null)
                                                    @for($i=0;$i<count($photos);$i++)
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="uploaded-box">
                                                                <div class="uploaded-img">
                                                                    <img src="{{url(asset("/ticket_picture/$photos[$i]"))}}" class="img-fluid" alt="">
                                                                </div>
                                                                <div class="uploaded-img-name">
                                                                    {{$photos[$i]}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                   @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-20">Uploaded files</h5>
                                            <ul class="files-list">
                                               @if($ticket->attachment!=null)
                                                <li>
                                                    <div class="files-cont">
                                                        <div class="file-type">
                                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                        </div>
                                                        <div class="files-info">
                                                            <span class="file-name text-ellipsis"><a href="">{{$ticket->attachment}}</a></span>
                                                            @if($ticket->created_emp_id==null)
                                                                <span class="file-author"><a href="#">Guest</a></span>
                                                                        @else
                                                                            <span class="file-author"><a href="#">{{$ticket->created_by->name}}</a></span>
                                                                        @endif
                                                                            <span class="file-date">{{$ticket->created_at}}</span>
                                                                <div class="file-size"></div>
                                                        </div>
                                                        <ul class="files-action">
                                                            <li class="dropdown dropdown-action">
                                                                <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{url(asset("/ticket_attach/$ticket->attachment"))}}">Download</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-popup hide">
                                    <p>
                                        <span class="task"></span>
                                        <span class="notification-text"></span>
                                    </p>
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
                            @if($assign_ticket->type_of_assign==0)
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$assign_ticket->agent->name}}" class="avatar">
                                    <img src="img/profiles/avatar-02.jpg" alt=""></a>
                                @else
                                        <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$assign_ticket->dept->name}}" class="avatar">
                                            <img src="img/profiles/avatar-02.jpg" alt=""> </a>
                                @endif
                            <a href="#" class="followers-add" title="Reassign" data-toggle="modal" data-target="#assignee"><i class="la la-arrow-right"></i></a>
                        </div>
                        <ul class="nav float-right custom-menu">
                            <li class="nav-item dropdown dropdown-action">
                                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_status{{$ticket->id}}">Edit Status</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket{{$ticket->id}}">Delete Ticket</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="chat-contents task-chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="chats">
                                    @foreach($comment as $cmt)
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                            <a href="profile" class="avatar">
                                                <img src="img/profiles/avatar-02.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <span class="task-chat-user">{{$cmt->comment_user->name}}</span> <span class="chat-time">{{$cmt->created_at->toFormattedDateString()}} at {{date('h:i:s a', strtotime($cmt->created_at))}}</span>
                                                    <p>{{$cmt->comment}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="completed-task-msg">
                                            <span class="file-attached">attached 3 files <i class="fa fa-paperclip"></i></span>
                                            <ul class="attach-list">
                                                <li><i class="fa fa-file"></i> <a href="#">project_document.avi</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-footer">
                    <div class="message-bar">
                        <div class="message-inner">
                            <a class="link attach-icon" href="#"><img src="img/attachment.png" alt=""></a>
                            <form action="{{url("/ticket/comment")}}" method="POST">
                                {{csrf_field()}}
                                <div class="message-area">
                                    <div class="input-group">
                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <textarea class="form-control" name="comment" placeholder="Type message..."></textarea>
                                        <span class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i></button>
                                    </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="project-members task-followers">
                        <span class="followers-title">Followers</span>
                        @foreach($ticket_followers as $follower)
                        <a href="#" data-toggle="tooltip" title="{{$follower->ticket_followed->name}}" class="avatar">
                            <img src="img/profiles/avatar-09.jpg" alt="">
                        </a>
                        @endforeach
                        <a href="#" class="followers-add" data-toggle="modal" data-target="#task_followers"><i class="material-icons">add</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Ticket Modal -->
@include('ticket.status_change')
<!-- /Edit Ticket Modal -->

<!-- Delete Ticket Modal -->
<div class="modal custom-modal fade" id="delete_ticket" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Ticket</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Ticket Modal -->
@include('ticket.delete')
<!-- Assignee Modal -->
<div id="assignee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reassign to this Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('reassign/ticket')}}" method="POST">
                   @csrf
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="input-group m-b-30">
                    <select class="select" id="type" name="assignType">
                        <option value="item0">Choose Assign Type</option>
                        <option value="dept">Assign To Department</option>
                        <option value="agent">Assign To Agent</option>
                    </select>
                </div>
                <div>
                    <div class="form-group">
                        <label for="">Assign To</label>
                        <select name="assign_id" id="assign_to" class="select">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Re-Assign</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Assignee Modal -->

<!-- Task Followers Modal -->
<div id="task_followers" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add followers to this Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/add/more/follower')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="input-group m-b-30">
                    <select name="follower[]" id="follower"  class="select" multiple>
                        @foreach($unfollowed_emps as $emp)
                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Add to Follow</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Task Followers Modal -->

<!-- /Page Wrapper -->
<script>
    $(document).ready(function () {
        $("#type").change(function () {
            var val = $(this).val();
            if (val == "dept") {
                $("#assign_to").html("@foreach($depts as $dept)<option value='{{$dept->id}}'>{{$dept->name}}</option> @endforeach");
            } else if (val == "agent") {
                $("#assign_to").html(" @foreach($unassign_emp as $agent)@if($agent->role->name=='Agent')<option value='{{$agent->id}}'>{{$agent->name}}</option> @endif @endforeach");
            }
        });
    });

    var start = new Date();
    if (new Date("{{$end}}") >= start) {

        {{--}else if(new Date("{{$end}}")>=start) {--}}
        var countDownDate = new Date("{{ $end->format('M d') .', '.$end->format('Y H:i:s') }}").getTime();
        // Run myfunc every second
        // alert(countDownDate);
        var myfunc = setInterval(function () {

            var now = new Date().getTime();
            // alert(now);
            var timeleft = countDownDate - now;
            // alert(timeleft)
            // Calculating the days, hours, minutes and seconds left
            var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

            // Result is output to the specific element
            document.getElementById("days").innerHTML = days + "d "
            document.getElementById("hours").innerHTML = hours + "h "
            document.getElementById("mins").innerHTML = minutes + "m "
            document.getElementById("secs").innerHTML = seconds + "s remaining"

            // Display the message when countdown is over
            if (timeleft < 0) {
                clearInterval(myfunc);
                document.getElementById("days").innerHTML = ""
                document.getElementById("hours").innerHTML = ""
                document.getElementById("mins").innerHTML = ""
                document.getElementById("secs").innerHTML = ""
                document.getElementById("end").innerHTML = "Time Up!";
            }
        }, 1000);

    }
</script>
@endsection
