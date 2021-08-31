@extends('layout.mainlayout')
@section('title','Ticket Details')
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
                                    <span>Status: </span>
                                    <div class="dropdown action-label" id="status_div">
                                        @foreach($status_color as $staus=>$color)
                                            @if($staus==$ticket->ticket_status->name)
                                                <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                   data-toggle="dropdown" aria-expanded="false"><i
                                                            class="fa fa-dot-circle-o mr-1"
                                                            style="color:{{$color}}"></i>{{$ticket->ticket_status->name}}
                                                </a>
                                            @endif
                                        @endforeach
                                        @include('ticket.status_change')
                                    </div>
                                    <span class="m-l-15 text-muted">Client Name: </span>
                                    <a href="#">{{$ticket->sender_info->name}}</a>
                                    <span class="m-l-15 text-muted">Created By : @if($ticket->created_emp_id==null)
                                            <span><a href="profile">"Guest"</a></span>
                                        @else
                                            <span><a href="profile">"{{$ticket->created_by->name}}"</a></span>
                                        @endif </span>&nbsp in
                                    <span>{{$ticket->created_at->toFormattedDateString()}} at {{date('h:i a', strtotime($ticket->created_at))}}</span>

                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i
                                        class="fa fa fa-comment"></i></a>
                        </div>
                    </div>
                    <br>

                    <div class="text-center">
                        @if($assign_ticket!=null)
                            <div class="alert alert-{{$ticket->ticket_status->name=='Complete'?'success':'danger'}} alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{$ticket->ticket_status->name=='Complete'?'Complete ':(\Carbon\Carbon::now()>$end ?'Over Due':'') }}{{Carbon\Carbon::parse($end)->diffForHumans() }}</strong>
                            </div>
                        @else
                            <div class="alert alert-warning alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>This ticket does not assign just!</strong>
                            </div>
                        @endif
                        <span id="end"></span>
                        {{--<b id="day"></b>--}}
                        <b id="hours"></b>
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
                                            <div class="card-header">Description
                                                <div class="float-right ticket-priority"><span>Priority:</span>
                                                    <div class="dropdown action-label" id="priority_div">
                                                        <a class="btn btn-white btn-sm btn-rounded " href="#"
                                                           data-toggle="dropdown" aria-expanded="false"><i
                                                                    class="fa fa-dot-circle-o mr-1 text-{{$ticket->ticket_priority->color}}"></i>{{$ticket->ticket_priority->priority}}
                                                        </a>
                                                        @include('priority.priority_change')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="project-title">
                                                    <div class="m-b-20">
                                                        <span class="h5 card-title ">{{$ticket->title}}</span>

                                                    </div>
                                                </div>
                                                {!! $ticket->message !!}
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">Uploaded image files</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($photos!=null)
                                                        @for($i=0;$i<count($photos);$i++)
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="uploaded-box">
                                                                    <div class="uploaded-img">
                                                                        <img src="{{url(asset("/ticket_picture/$photos[$i]"))}}"
                                                                             class="img-fluid" alt="">
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
                                            <div class="card-header">Uploaded files</div>
                                            <div class="card-body">
                                                <ul class="files-list">
                                                    @if($ticket->attachment!=null)
                                                        <li>
                                                            <div class="files-cont">
                                                                <div class="file-type">
                                                                    <span class="files-icon"><i
                                                                                class="fa fa-file-pdf-o"></i></span>
                                                                </div>
                                                                <div class="files-info">
                                                                    <span class="file-name text-ellipsis"><a
                                                                                href="">{{$ticket->attachment}}</a></span>
                                                                    @if($ticket->created_emp_id==null)
                                                                        <span class="file-author"><a href="#">Guest</a></span>
                                                                    @else
                                                                        <span class="file-author"><a
                                                                                    href="#">{{$ticket->created_by->name}}</a></span>
                                                                    @endif
                                                                    <span class="file-date">{{$ticket->created_at}}</span>
                                                                    <div class="file-size"></div>
                                                                </div>
                                                                <ul class="files-action">
                                                                    <li class="dropdown dropdown-action">
                                                                        <a href="" class="dropdown-toggle btn btn-link"
                                                                           data-toggle="dropdown" aria-expanded="false"><i
                                                                                    class="material-icons">more_horiz</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item"
                                                                               href="{{url(asset("/ticket_attach/$ticket->attachment"))}}">Download</a>
                                                                            <a class="dropdown-item" href="#"
                                                                               data-toggle="modal"
                                                                               data-target="#share_files">Share</a>
                                                                            <a class="dropdown-item"
                                                                               href="javascript:void(0)">Delete</a>
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
                                <span class="assign-title">Assigned Staff : </span>
                                @if($assign_ticket!=null)
                                    @if($assign_ticket->type_of_assign=='agent')
                                        <a href="#" data-toggle="tooltip" data-placement="bottom"
                                           title="{{$assign_ticket->agent->name}}" class="avatar">
                                            <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt=""></a>
                                    @else
                                        <a href="#" data-toggle="tooltip" data-placement="bottom"
                                           title="{{$assign_ticket->dept->name}}" class="avatar">
                                            <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt=""> </a>
                                    @endif
                                @endif
                            </div>
                            <ul class="nav float-right custom-menu">
                                <li class="nav-item dropdown dropdown-action">
                                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                       aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                           data-target="#assignee">{{$ticket->isassign==0 ? 'Assign':'Reassign'}}
                                            Ticket</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                           data-target="#delete_ticket{{$ticket->id}}">Delete Ticket</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats" id="cmt">
                                        @foreach($comment as $cmt)
                                            <div class="chat chat-left">
                                                <div class="nav float-right custom-menu">
                                                    <a href="{{route('ticket_cmt.delete',$cmt->id)}}"
                                                       class="followers-add" data-toggle="tooltip"
                                                       data-placement="bottom"><i class="la la-trash-o"></i></a>
                                                </div>
                                                <div class="chat-avatar">
                                                    <a href="#" class="avatar">
                                                        <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt="">
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div class="chat-content">
                                                            <span class="task-chat-user">{{$cmt->comment_user->name}}</span>
                                                            <span class="chat-time">{{$cmt->created_at->toFormattedDateString()}} at {{date('h:i a', strtotime($cmt->created_at))}}</span>
                                                            <p>{{$cmt->comment}}</p>
                                                        </div>
                                                    </div>
                                                    @if($cmt->document_file!=null)
                                                        <ul class="attach-list">
                                                            <li class="pdf-file"><i class="fa fa-file-pdf-o"></i> <a
                                                                        href="{{url(asset('ticket_attach/'.$cmt->document_file))}}"
                                                                        download="">{{$cmt->document_file}}</a></li>
                                                        </ul>
                                                    @endif
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
                                <form action="{{url("/ticket/comment")}}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="message-area">

                                        <div class="input-group">
                                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                            <input type="file" id="file1" name="attach_file" style="display:none"/>
                                            <button class="btn btn-white" onClick="openSelect('#file1')"
                                                    id="attchment_field" type="button"><i class="la la-paperclip"></i>
                                            </button>
                                            <input type="text" class="form-control" name="comment"
                                                   placeholder="Add Note...">
                                            <span class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="project-members task-followers">
                            <span class="followers-title">Followers</span>
                            @foreach($ticket_followers as $follower)
                                <a href="#" data-toggle="tooltip" title="{{$follower->ticket_followed->name}}"
                                   class="avatar">
                                    <img src="img/profiles/avatar-09.jpg" alt="">
                                </a>
                            @endforeach
                            <a href="#" class="followers-add" data-toggle="modal" data-target="#task_followers"><i
                                        class="material-icons">add</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--@dd($ticket->isassign==1)--}}
    <!-- /Delete Ticket Modal -->
    @include('ticket.delete')
    <!-- Assignee Modal -->
    <div id="assignee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$ticket->isassign== 0 ? 'Assign':'Reassign'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{$ticket->isassign==1?url('reassign/ticket'):route('tickets.assign')}}"
                          method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticket->id}}">
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
                            <button type="submit"
                                    class="btn btn-primary submit-btn">{{$ticket->isassign==0 ? 'Assign':'Reassign'}}</button>
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
                            <select name="follower[]" id="follower" class="select" multiple>
                                @foreach($all_emp as $emp)
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
        $(document).on('click', '#attchment_field', function () {
            $('#attach_div').append('<input type="file" class="form-control" name="attach_file">')
        });
        $(document).ready(function () {
            $("#type").change(function () {
                var val = $(this).val();
                if (val == "dept") {
                    $("#assign_to").html("@foreach($depts as $dept)<option value='{{$dept->id}}'>{{$dept->name}}</option> @endforeach");
                } else if (val == "agent") {
                    $("#assign_to").html(" @foreach($all_emp as $agent)@if($agent->role->name=='Agent')<option value='{{$agent->id}}'>{{$agent->name}}</option> @endif @endforeach");
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
                // var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

                // Result is output to the specific element
                // document.getElementById("days").innerHTML = days + "d ";
                document.getElementById("hours").innerHTML = hours + "h :";
                document.getElementById("mins").innerHTML = minutes + "m :";
                document.getElementById("secs").innerHTML = seconds + "s Remaining";

                // Display the message when countdown is over
                if (timeleft < 0) {
                    clearInterval(myfunc);
                    // document.getElementById("days").innerHTML = "";
                    document.getElementById("hours").innerHTML = "";
                    document.getElementById("mins").innerHTML = "";
                    document.getElementById("secs").innerHTML = "";
                    document.getElementById("end").innerHTML = "Over Due!";
                }
            }, 1000);

        }

        function openSelect(file) {
            $(file).trigger('click');
        }
    </script>
@endsection
