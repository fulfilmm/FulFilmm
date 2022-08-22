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
        <div class="card my-3" style="background-color: #e9e9e6">
            <div class="col-12 ml-2 mr-2">
                <div class="row my-2 justify-content-between">
                    <div class="col">
                                    <span class="btn btn gradient-purple"
                                          type="button">{{$todo_list->responsible_emp->name}}</span>
                    </div>
                    <div class="col">
                            <span class="btn btn gradient-red text-white"
                                  type="button">{{\Carbon\Carbon::parse($todo_list->end_date)->toFormattedDateString()}}</span>
                    </div>

                    <div class="col">
                                    <span class="btn btn {{$todo_list->priority=='High'?'gradient-red text-white':($todo_list->priority=='Medium'?'gradient-blue':'gradient-green')}}"
                                          type="button">Priority : {{$todo_list->priority}}</span>
                    </div>
                    <div class="col">
                                    <span class="btn btn {{$todo_list->status=='Not Started'?'gradient-purple':($todo_list->status=='Working'?"gradient-yellow":
                                                 ($todo_list->status=='Pending'?"gradient-blue":($todo_list->status=='Cancel'?'gradient-red':'gradient-green')))}}"
                                          type="button">{{$todo_list->status}}</span>
                    </div>
                    <div class="col">
                            <span class="btn btn {{$todo_list->progress==100?"bg-success":($todo_list->progress>=75?"bg-info":($todo_list->progress>=50?'bg-warning':'bg-danger text-white'))}}"
                                  type="button">Percentage : {{$todo_list->progress}} %</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card" style="min-height: 550px;">
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
            </div>
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-body scroll" style="height: 470px;overflow: auto">
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
                                                <a href="{{asset('attach_file/'.$comment->attach)}}" download="" title="One Click For Download">
                                                    <i class="fa fa-file"></i><br>
                                                    <span style="font-size: 12px;"> {{$comment->attach}}</span>

                                                </a>
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
                                    <form method="POST" action="{{url("todo/comment")}}" class="my-2" enctype="multipart/form-data" style="padding: 10px;">
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
                                        <button class="btn btn-primary" type="submit"><i
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
        <script>
            function openSelect(file) {
                $(file).trigger('click');
            }
        </script>
@endsection