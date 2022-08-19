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
            <div class="row my-2">
                <div class="col-3">
                            <span class="btn btn gradient-red text-white"
                                  type="button">Due Date : {{\Carbon\Carbon::parse($todo_list->end_date)->toFormattedDateString()}}</span>
                </div>


                <div class="col-3">
                                    <span class="btn btn gradient-purple"
                                          type="button">Employee : {{$todo_list->responsible_emp->name}}</span>
                </div>
                <div class="col-2">
                                    <span class="btn btn {{$todo_list->priority=='High'?'gradient-red text-white':($todo_list->priority=='Medium'?'gradient-blue':'gradient-green')}}"
                                          type="button">Priority : {{$todo_list->priority}}</span>
                </div>
                <div class="col-2">
                                    <span class="btn btn {{$todo_list->status=='Not Working'?'gradient-purple':($todo_list->status=='Working'?"gradient-yellow":
                                                 ($todo_list->status=='Pending'?"gradient-blue":($todo_list->status=='Cancel'?'gradient-red':'gradient-green')))}}"
                                          type="button">Status : {{$todo_list->status}}</span>
                </div>
                <div class="col-2">
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
                        <div class="card " style="min-height: 500px;">
                            <div class="card-body scroll">
                                <ul class="files-list">
                                    @foreach($comments as $comment)
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile" class="avatar">
                                                    <img src="{{$comment->employee->profile_img!=null? url(asset('img/profiles/'.$comment->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content col-12">
                                                        <span class="task-chat-user">{{$comment->employee->name}}</span>
                                                        <p>{{$comment->comment}}</p>
                                                        <span class="chat-time">{{$comment->created_at->toFormattedDateString()}} at {{date('h:i:s a', strtotime($comment->created_at))}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                            <form method="POST" action="{{url("todo/comment")}}" class="mt-2">
                               @csrf
                                <div class="row " >
                                    <div class="col-xl-12 col-md-12 col-12 my-2">
                                        <input type="hidden" name="assignment_id" value="{{$todo_list->id}}">
                                        <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
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
@endsection