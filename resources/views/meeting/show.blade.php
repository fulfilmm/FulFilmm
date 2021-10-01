<!DOCTYPE html>
<html lang="en">

<head>
@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
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
                                <form action="{{route('filter.minutes',$meeting->id)}}" method="get">
                                    <div class="input-group"><input type="text" id="filter" name="search"
                                                                    class="form-control" placeholder="Search...">
                                        <button type="submit" id="search" class="btn btn-outline-info"><i
                                                    class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="task-wrapper">
                                        <div class="task-list-container" id="minute_list">
                                            <div class="task-list-body" id="list_view">
                                                <ul id="task-list">
                                                    @foreach($minutes as $minute)
                                                        <input type="hidden" id="minutes_id{{$minute->id}}"
                                                               value="{{$minute->id}}">

                                                        <li class="task" id="minutelist{{$minute->id}}">
                                                            <div class="task-container">
                                                                    <span class="task-action-btn task-check"
                                                                          id="complete_todo{{$minute->id}}">
																			<span class="action-circle large complete-btn {{$minute->is_complete==1  ? 'bg-info ':''}}"
                                                                                  title="">
																				<i class="material-icons">{{$minute->is_complete==1  ? 'check' : ''}}</i>
																			</span>
																		</span>

                                                                <span class="task-label" contenteditable="true"
                                                                      style="{{ $minute->is_complete==0 ?'':'color: #989c9e'}}">{{substr($minute->minutes_text,0,20)}}
                                                                        <a href="" data-toggle="modal"
                                                                           data-target="#view{{$minute->id}}">
                                                                            <span class="large text-center "
                                                                                  title="View Details">
																				{{strlen($minute->minutes_text) > 20 ?'..more':''}}
																			</span>
                                                                              </a></span>
                                                                @foreach($assign_name as $name)
                                                                    @if($name->minutes_id==$minute->id)
                                                                        <span class="task-label {{ $minute->is_complete==0 ?"text-danger":'text-success'}}"
                                                                              contenteditable="true">{{ $minute->is_complete==0 ?\Carbon\Carbon::now() > $name->due_date ? 'Over Due Date':'':'Completed at'.$minute->updated_at}}</span>
                                                                    @endif
                                                                @endforeach
                                                                <span class="task-action-btn task-btn-right">
                                                                         @if($minute->attach_file!=null)
                                                                        <span data-toggle="modal"
                                                                              data-target="#attach{{$minute->id}}"
                                                                              class="action-circle large"
                                                                              title="It has attachment file">
																				<i class="material-icons">attach_file</i>
																			</span>
                                                                    @endif
                                                                        <span data-toggle="modal"
                                                                              data-target="#assign{{$minute->is_assign ?'':$minute->id}}"
                                                                              class="action-circle large"
                                                                              title="{{$minute->is_assign ? 'Has been assigned' :'Assign'}}">
																				<i class="material-icons ml-1">{{$minute->is_assign ? 'checked':'person_add'}}</i>
																			</span>
																		<a href="" data-toggle="modal"
                                                                           data-target="#view{{$minute->id}}">
                                                                            <span class="action-circle large text-center "
                                                                                  title="View Details">
																				<i class="la la-eye sm mt-1"></i>
																			</span>
                                                                              </a>
																		</span>
                                                            </div>
                                                        </li>
                                                        <div id="view{{$minute->id}}" class="modal custom-modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Minutes
                                                                            No:{{$minute->minutes_no}}</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="">Record No.</label>
                                                                            <input type="text" class="form-control"
                                                                                   readonly
                                                                                   value="{{$minute->minutes_no}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="description">Minutes</label>
                                                                            <textarea readonly id="description"
                                                                                      class="form-control">{{$minute->minutes_text}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    @if($minute->is_assign==1)
                                                                        @foreach($assign_name as $name)
                                                                            @if($name->minutes_id==$minute->id)
                                                                                <div class="col-md-8 offset-md-4">
                                                                                    <label>Assign To</label>
                                                                                @if($name->assign_type=='group')
                                                                                    <span class="action-circle large"
                                                                                          title="{{$name->group_id}}">
																				            <i class="material-icons">person</i>
																			            </span>
                                                                                @elseif($name->assign_type=='emp')
                                                                                        <span class="action-circle large">
                                                                                            <i class="material-icons">person</i></span>
                                                                                            {{$name->emp->name}}
                                                                                @else
                                                                                        span class="action-circle large">
                                                                                        <i class="material-icons">person</i></span>
                                                                                        {{$name->det->name}}
                                                                                @endif
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <span class="ml-2 {{\Carbon\Carbon::now() >$name->due_date && $minute->is_complete==0 ?'btn btn-danger':''}}">
                                                                                            {{ $minute->is_complete==0 ? \Carbon\Carbon::now() >$name->due_date ?'Over Due Date':'Due Date:'.\Carbon\Carbon::parse($name->due_date)->toFormattedDateString():'Complete in '.$minute->updated_at->toFormattedDateString().' at '.date('h:i a', strtotime($minute->updated_at))}}
                                                                                        </span>
                                                                                    </div>

                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="attach{{$minute->id}}" class="modal custom-modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Attachment Files</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @if($minute->attach_file!=null)
                                                                            @php $attach=json_decode($minute->attach_file) @endphp
                                                                            <div class="row">
                                                                                @foreach($attach as $key=>$val)
                                                                                    <div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                                        <div class="card card-file"
                                                                                             style="min-width: 100px;">
                                                                                            @php
                                                                                                $infoPath = pathinfo(public_path('minutes_attach/'.$val));
                                                                                                 $extension = $infoPath['extension'];
                                                                                            @endphp
                                                                                            <div class="card-file-thumb">
                                                                                                @if($extension=='xlsx')
                                                                                                    <i class="fa fa-file-excel-o"></i>
                                                                                                @elseif($extension=='pdf')
                                                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                                                @else
                                                                                                    <i class="fa fa-file-word-o"></i>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <h6>
                                                                                                    <a href="{{url(asset('minutes_attach/'.$val))}}"
                                                                                                       download>{{$val}}</a>
                                                                                                </h6>
                                                                                            </div>
                                                                                            <div class="card-footer">{{$minute->created_at->toFormattedDateString()}}
                                                                                                <a href="{{url(asset('minutes_attach/'.$val))}}"
                                                                                                   class="float-right"><i
                                                                                                            class="fa fa-download"
                                                                                                            style="font-size: 16px;"></i></a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Assignee Modal -->
                                                        <div id="assign{{$minute->id}}" class="modal custom-modal fade"
                                                             role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header text-sm">
                                                                        <strong class="modal-title">Assign to this
                                                                            Minutes</strong>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group ">
                                                                            <label for="">Assign Type</label>
                                                                            <select class="form-control type"
                                                                                    id="type{{$minute->id}}"
                                                                                    name="assignType"
                                                                                    style="width: 100%">
                                                                                <option value="item0">Choose Assign
                                                                                    Type
                                                                                </option>
                                                                                <option value="emp">Assign To Employee
                                                                                </option>
                                                                                <option value="dept">Assign To
                                                                                    Department
                                                                                </option>
                                                                                <option value="group">Assign To Group
                                                                                </option>
                                                                            </select>
                                                                            <span class="text-danger assing_type_err"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Assign To</label>
                                                                            <select name="assign_id"
                                                                                    id="assign_to{{$minute->id}}"
                                                                                    class="form-control assign_to"
                                                                                    style="width: 100%;" required>
                                                                                <option></option>
                                                                            </select>
                                                                            <span class="text-danger assign_to_err"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Due Date</label>
                                                                            <input type="date" class="form-control"
                                                                                   id="due_date{{$minute->id}}">
                                                                            <span class="text-danger due_date_err"></span>
                                                                        </div>
                                                                        <div class="submit-section">
                                                                            <button type="button" data-dismiss="modal"
                                                                                    id="submit{{$minute->id}}"
                                                                                    class="btn btn-primary submit-btn">
                                                                                Assign
                                                                            </button>
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
                                                <div class=" task-head-title">Meeting Type
                                                    : {{$meeting->meeting_type}}</div>
                                                <div class=""><span>ID/Link : {{$meeting->link_id}}</span></div>
                                                <div class="task-assignee">
                                                    <span>Password : {{$meeting->password}}</span></div>
                                            @else
                                                <div class=" task-head-title">Meeting Type
                                                    : {{$meeting->meeting_type}}</div>
                                                <div class=""><span>Address : {{$meeting->meeting_room->address}}</span>
                                                </div>
                                                <div class="task-assignee">
                                                    <span>Room No : {{$meeting->meeting_room->room_no}}</span></div>
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
                                                <div class="due-date">{{\Carbon\Carbon::parse($meeting->date_time)->toFormattedDateString()}}
                                                    at {{date('h:i a', strtotime(\Carbon\Carbon::parse($meeting->date_time)))}}</div>
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

                                @if($member->is_external==0)
                                    <a class="avatar" href="#" data-toggle="tooltip"
                                       title="{{$member->emp_member->name}}">
                                        <img src="{{$member->emp_member->profile_img!=null? url(asset('img/profiles/'.$member->emp_member->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
                                    </a>
                                @else
                                    <a class="avatar" href="#" data-toggle="tooltip"
                                       title="{{$member->external->name}}">
                                        <img alt="" src="{{url(asset('img/icon_image/guest.png'))}}">
                                    </a>
                                @endif
                            @endforeach
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
                            <textarea name="minutes" id="minutes" cols="30" rows="5" class="form-control"
                                      required></textarea>
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

</body>
</html>