@extends('layout.mainlayout')
@section('name', 'Details Todo List')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Details Todo List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Details Todo List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 border bg-lightgrey rounded">
            <div class="card my-3" style="background-color: #e9e9e6">
                <div class="col-12 ml-2 mr-2">
                    <div class="row my-2 justify-content-between">
                        <div class="col">
                            <button class="btn btn-white text-red col-12"
                                    type="button">Due Date :<span class="text-red">{{\Carbon\Carbon::parse($todo_list->end_date)->toFormattedDateString()}}</span></button>
                        </div>
                        <div class="col">
                                    <span class="btn btn-white col-12"
                                          type="button">{{$todo_list->responsible_emp->name}}</span>
                        </div>


                        <div class="col">
                                    <button class="col-12 btn btn-white text-{{$todo_list->priority=='High'?'danger':($todo_list->priority=='Medium'?'info':'success')}}"
                                          type="button">Priority : {{$todo_list->priority}}</button>
                        </div>
                        <div class="col">
                            <button data-toggle="modal" data-target="#change_status{{$todo_list->id}}" class="btn btn-white col-12 "
                                    type="button"><span class="{{$todo_list->status=='Not Started'?'text-dark':($todo_list->status=='Working'?"text-warning":
                                                 ($todo_list->status=='Pending'?"text-info":($todo_list->status=='Cancel'?'text-danger':'text-success')))}}">{{$todo_list->status}}</span></button>
                        </div>

                        <div class="col">
                            <a href="{{route('assignments.edit',$todo_list->id)}}" class="btn btn-white col-12"><i
                                        class="fa fa-edit mr-2"></i>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card" style="height: 200px;">
                        <div class="card-header">
                            {{$todo_list->title}}
                        </div>
                        <div class="card-body">
                            <div class="col-12"><h5>Description</h5></div>
                            <div class="col-12">
                                <p>{{$todo_list->description}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="progress my-2">

                        <div class="progress-bar {{$todo_list->progress==100?"bg-success":($todo_list->progress>=75?"bg-info":($todo_list->progress>=50?'bg-warning':'bg-danger'))}}"
                             role="progressbar"
                             style="width:{{$todo_list->progress}}%"
                             aria-valuenow="75" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                    <label for="">Process Percentage({{$todo_list->progress}} %)</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="bs-offset-main bs-canvas-anim mt-2">
                                <button class="btn btn-primary btn-sm mb-2" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Check List
                                </button>

                            </div>
                            <div class="border-bottom"></div>
                            <div class="col-12" style="list-style-type: none;height:350px;overflow: auto">
                                @foreach($check_list as $item)
                                    <div class="row my-2 border rounded " style="height: 40px;">
                                        <div class="col-11 my-2">
                                            @if($item->done==1)
                                                <input type="checkbox" id="not_complete{{$item->id}}" value="0" checked>
                                                <strike class="ml-2">{{$item->description}}</strike>
                                            @else
                                                <input type="checkbox" class="complete{{$item->id}}" id="complete{{$item->id}}" value="1">
                                                <span class="ml-2">{{$item->description}}</span>
                                            @endif
                                        </div>
                                        <div class="col-1 my-2">
                                            <div class="row">
                                                @if($item->remark==1)
                                                    <a href="" id="cancel_remark{{$item->id}}" class="mx-2"><i class="fa fa-star" style="color:yellow"></i></a>
                                                @else
                                                    <a href="" id="remark{{$item->id}}" class="mx-2 gray"><i class="fa fa-star"></i></a>

                                                @endif
                                                <a href="" data-toggle="modal" data-target="#delete_check{{$item->id}}"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    @include('Assignment.jquerypost')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-body scroll" style="height: 650px;overflow: auto">
                            <ul class="files-list">
                                @foreach($comments as $comment)
                                    <div class="chat chat-left chat-content-wrap">
                                        <div class="chat-avatar">
                                            <a href="{{route('employees.show',$comment->employee->id)}}" class="avatar">
                                                <img src="{{$comment->employee->profile_img!=null? url(asset('img/profiles/'.$comment->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                                     alt="">
                                            </a>
                                        </div>
                                        <div class="chat-body" style="width: 100%">
                                            <div class="chat-bubble">
                                                <div class="chat-content col-12">
                                                    <span class="task-chat-user">{{$comment->employee->name}}</span><br>
                                                    @if($comment->attach!=null)
                                                        <a href="{{asset('attach_file/'.$comment->attach)}}" download=""
                                                           title="One Click For Download">
                                                            <i class="fa fa-file"></i><br>
                                                            <span style="font-size: 12px;"> {{$comment->attach}}</span>

                                                        </a>
                                                    @endif
                                                    <p>{{$comment->comment}}</p>
                                                    <span class="chat-time">{{$comment->created_at->toFormattedDateString()}} at {{date('h:i:s a', strtotime($comment->created_at))}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                        <div class="message-bar">

                            <div class="message-inner">
                                <div class="message-area">
                                    <form method="POST" action="{{url("todo/comment")}}" class="my-2"
                                          enctype="multipart/form-data" style="padding: 10px;">
                                        @csrf
                                        <input type="hidden" name="assignment_id" value="{{$todo_list->id}}">
                                        <input type="hidden" name="emp_id"
                                               value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                                        <div class="input-group">
                                            {{--<input type="hidden" name="ticket_id" value="{{$ticket->id}}">--}}
                                            <input type="file" id="file1" name="attach" style="display:none"/>
                                            <button class="btn btn-white" onClick="openSelect('#file1')"
                                                    id="attchment_field" type="button"><i class="la la-paperclip"></i>
                                            </button>
                                            <input type="text" class="form-control" name="comment"
                                                   placeholder="Add Note...">
                                            <span class="input-group-append">
                                        <button class="btn btn-primary text-white" type="submit"><i
                                                    class="la la-save"></i></button>
                                    </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Add Check List</h5>
                    <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="offcanvas" aria-label="Close"><i class="la la-close"></i></button>
                </div>
                <div class="offcanvas-body">
                    <form action="{{route('todo_checklists.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                        <input type="hidden" name="assignment_id" value="{{$todo_list->id}}">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea name="description" id="" cols="30" class="form-control"  rows="5" placeholder="Add text" required>

                                </textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-white">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="delete{{$todo_list->id}}"
                 class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title">Delete</h5>
                            <button type="button" class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('assignments.destroy',$todo_list->id)}}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <h4> Are you sure ?</h4>
                                <div class="form-group mt-5">
                                    <button type="submit"
                                            class="btn btn-info">
                                        Yes
                                    </button>
                                    <button type="button" data-dimiss="modal"
                                            class="btn btn-info">
                                        No
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="change_process{{$todo_list->id}}"
                 class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title">Finish
                                Percentage</h5>
                            <button type="button" class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('assignments.update',$todo_list->id)}}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden"
                                       name="title"
                                       value="{{$todo_list->title}}">
                                <input type="hidden"
                                       name="emp_id"
                                       value="{{$todo_list->emp_id}}">
                                <input type="hidden"
                                       name="assignee_id"
                                       value="{{$todo_list->assignee_id}}">
                                <input type="hidden"
                                       name="end_date"
                                       value="{{$todo_list->end_date}}">
                                <input type="hidden"
                                       name="status"
                                       value="{{$todo_list->status}}">
                                <input type="hidden"
                                       name="priority"
                                       value="{{$todo_list->priority}}">
                                <div class="form-group">
                                    <label for="percentage">Finished
                                        Percentage</label>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               name="progress"
                                               id="percentage"
                                               value="{{$todo_list->progress}}">
                                        <div class="input-group-append">
                                            <button type="button"
                                                    class="btn btn-white">
                                                %
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-info">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="change_status{{$todo_list->id}}"
                 class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title">Finish
                                Percentage</h5>
                            <button type="button" class="close"
                                    data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('assignments.update',$todo_list->id)}}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden"
                                       name="title"
                                       value="{{$todo_list->title}}">
                                <input type="hidden"
                                       name="emp_id"
                                       value="{{$todo_list->emp_id}}">
                                <input type="hidden"
                                       name="assignee_id"
                                       value="{{$todo_list->assignee_id}}">
                                <input type="hidden"
                                       name="end_date"
                                       value="{{$todo_list->end_date}}">
                                <input type="hidden"
                                       name="progress"
                                       value="{{$todo_list->progress}}">
                                <input type="hidden"
                                       name="priority"
                                       value="{{$todo_list->priority}}">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status"
                                            id="status"
                                            class="form-control">
                                        <option value="Not Started">
                                            Not Started
                                        </option>
                                        <option value="Working">
                                            Working
                                        </option>
                                        <option value="Pending">
                                            Pending
                                        </option>
                                        <option value="Finished">
                                            Finished
                                        </option>
                                        <option value="Cancel">
                                            Cancel
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-info">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function openSelect(file) {
                $(file).trigger('click');
            }

        </script>
@endsection