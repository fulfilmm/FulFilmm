<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
    @yield('styles')
<body>
<!-- Main Wrapper -->
    @include('layout.partials.nav')

    @include('layout.partials.header')
    <!-- Page Wrapper -->
    @include('layout.partials.flash-messages')
    <div class="page-wrapper">
        <div class="chat-main-row">
            <div class="chat-main-wrapper">
                <div class="col-lg-8 message-view task-view task-left-sidebar">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="float-left mr-auto">
{{--                                    <div class="add-task-btn-wrapper">--}}
												<a class="btn btn-white btn-sm" data-toggle="modal" data-target="#create_minutes">
													Add Minutes
												</a>

{{--                                    </div>--}}
                                </div>
                                <div class="float-right">
                                    <div class="input-group"><input type="text" name="search" class="form-control" placeholder="Search with record no"><button type="button" class="btn btn-outline-info"><i class="fa fa-search"></i></button></div>
                                </div>
                            </div>

                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list">

                                                        @foreach($minutes as $minute)
                                                            <input type="hidden" id="minutes_id{{$minute->id}}" value="{{$minute->id}}">

                                                            <li class="task" id="minutelist{{$minute->id}}">
                                                                <div class="task-container">
																		<span class="task-action-btn task-check">
																			<input type="checkbox" name="is_assign" class="custom-control" {{$minute->is_assign  ? 'checked title=Assigned' : 'title=UnAssign'}}>
																		</span>
                                                                    <span class="task-label" contenteditable="true">{{$minute->minutes_text}}</span>
                                                                    <span class="task-action-btn task-btn-right">
																		@if(!$minute->is_assign)
                                                                        <span data-toggle="modal" data-target="#assign{{$minute->id}}" class="action-circle large" title="Assign">
																				<i class="material-icons">person_add</i>
																			</span>
                                                                        @endif
																		<a href="" data-toggle="modal" data-target="#view{{$minute->id}}" >
                                                                            <span class="action-circle large " title="View Details">
																				<i class="fa fa-th-list"></i>
																			</span>
                                                                              </a>
																		</span>
                                                                </div>
                                                            </li>
                                                            <div id="view{{$minute->id}}" class="modal custom-modal fade" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">{{$minute->minutes_no}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                           <p>{{$minute->minutes_text}}</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            @foreach($assign_name as $name)
                                                                                @if($name->minutes_id==$minute->id)
                                                                                    @if($name->assign_type=='group')
                                                                                        <span  class="action-circle large float-right" title="{{$name->group_id}}">
																				            <i class="material-icons">person</i>
																			            </span>
                                                                                    @else
                                                                                        <div class="row">

                                                                                                <strong >Due Date: </strong> <span class="mr-5">{{\Carbon\Carbon::parse($name->due_date)->toFormattedDateString()}}</span>
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <strong class="mr-2">Assign to:</strong>
                                                                                            <span  class="action-circle large mr-2 float-right" title="{{$name->assign_type=='emp' ? $name->emp->name : $name->dept->name}}">
																				            <i class="material-icons">person</i>
																			            </span><span class="mr-2">{{$name->assign_type=='emp' ? $name->emp->name : $name->dept->name}}</span>
                                                                                        </div>
                                                                                    @endif
                                                                                @endif

                                                                            @endforeach</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Assignee Modal -->
                                                            <div id="assign{{$minute->id}}" class="modal custom-modal fade" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header text-sm">
                                                                            <strong class="modal-title">Assign to this Minutes</strong>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group ">
                                                                                <label for="">Assign Type</label>
                                                                                <select class="form-control type" id="type{{$minute->id}}" name="assignType" style="width: 100%">
                                                                                    <option value="item0">Choose Assign Type</option>
                                                                                    <option value="emp">Assign To Employee</option>
                                                                                    <option value="dept">Assign To Department</option>
                                                                                    <option value="group">Assign To Group</option>
                                                                                </select>
                                                                                <span class="text-danger assing_type_err"></span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Assign To</label>
                                                                                <select name="assign_id" id="assign_to{{$minute->id}}" class="form-control assign_to" style="width: 100%;" required>
                                                                                    <option></option>
                                                                                </select>
                                                                                <span class="text-danger assign_to_err"></span>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Due Date</label>
                                                                                <input type="date" class="form-control" id="due_date{{$minute->id}}">
                                                                                <span class="text-danger due_date_err"></span>
                                                                            </div>
                                                                            <div class="submit-section">
                                                                                <button type="button" data-dismiss="modal" id="submit{{$minute->id}}" class="btn btn-primary submit-btn">Assign</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @include('meeting.assign_jquerycode')
                                                            <!-- /Assignee Modal -->
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 message-view task-chat-view task-right-sidebar" id="task_window">
                    <div class="chat-window">
                        <div class="chat-contents task-chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats">
                                            <h4>Meeting Title{{$meeting->title}}({{$meeting->meeting_type}})</h4>
                                            <hr class="task-line">
                                            <div class="col-md-12">
                                                @if($meeting->meeting_type=="Visual")
                                                    <div class=" task-head-title">Meeting Type : {{$meeting->meeting_type}}</div>
                                                    <div class=""><span>ID/Link : {{$meeting->link_id}}</span> </div>
                                                    <div class="task-assignee"><span>Password : {{$meeting->password}}</span> </div>
                                                @else
                                                    <div class=" task-head-title">Meeting Type : {{$meeting->meeting_type}}</div>
                                                    <div class=""><span>Address : {{$meeting->address}}</span> </div>
                                                    <div class="task-assignee"><span>Room No : {{$meeting->room_no}}</span> </div>
                                                @endif
                                            </div>
                                            <hr class="task-line">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="due-icon">
                                                        <span><i class="material-icons">date_range</i></span>
                                                    </div>
                                                    <span>Meeting Date Time</span>
                                                </div>
                                                <div class="due-info ml-4">
                                                    <div class="due-date">{{\Carbon\Carbon::parse($meeting->date_time)->toFormattedDateString()}} at {{date('h:i a', strtotime(\Carbon\Carbon::parse($meeting->date_time)))}}</div>
                                                </div>
                                            </div>
                                            <hr class="task-line">
                                            <h5>Meeting Agenda</h5>
                                            <div class="chat">
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div class="chat-content">
                                                            <ol type="1">
                                                                @foreach($agenda as $key=>$val)
                                                               <li style="min-height: 20px">
                                                                    {{$val}}
                                                               </li>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-footer">
                            <div class="project-members task-followers">
                                <span class="followers-title">Meeting Member</span>
                               @foreach($emp_members as $member)
                                <a class="avatar" href="#" data-toggle="tooltip" title="{{$member->emp_member->name}}">
                                    <img alt="" src="img/profiles/avatar-16.jpg">
                                </a>
                                @endforeach
                                @if($meeting->guest_member!=null)
                                    @foreach($members as $key=>$val)
                                        <a class="avatar" href="#" data-toggle="tooltip" title="{{$val}}">
                                            <img alt="" src="img/profiles/avatar-16.jpg">
                                        </a>
                                    @endforeach
                                    @endif
{{--                                <a href="#" class="followers-add" data-toggle="modal" data-target="#task_followers"><i class="material-icons">add</i></a>--}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Project Modal -->
        <div id="create_minutes" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Minutes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('minutes.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="meeting_id" value="{{$meeting->id}}">
                            <div class="form-group">
                                <label>Minutes Record No</label>
                                <input class="form-control" type="text" name="record_no">
                            </div>
                            <div class="form-group">
                                <label for="minutes">Minutes <span class="text-danger">*</span> </label>
                                <textarea name="minutes" id="minutes" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Attach File</label>
                                <input type="file" class="form-control" name="attach_file[]" multiple>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Create Project Modal -->
    </div>
@include('layout.partials.footer-scripts')

@stack('scripts')

</body>
</html>
