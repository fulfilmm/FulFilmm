@extends('layout.mainlayout')
@section('title','Sales Activity Details')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div >
                    <h3 class="page-title">Details Sales Activities</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('activity.index')}}">Sales Activities</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="my-2">
            {{--@dd($activity)--}}
            <span class="btn btn-primary btn-sm">Report :{{$activity->report->name}}</span>
            <a href="{{route('read',$activity->id)}}" class="btn btn-{{$activity->status==0?'warning':'success'}} btn-sm ml-2"><i class="fa fa-{{$activity->status==0?'close':'check'}} mr-2"></i>Aknowledge</a>
        </div>
        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span>{{$activity->title}}</span>
                        <span class="float-right">{{\Carbon\Carbon::parse($activity->date)->toFormattedDateString()}}</span>
                    </div>
                    <div class="card-body" style="min-height: 300px;">
                        <div class="row">
                            <div class="col-12">
                                <span class="text-muted">Customer Name</span> : {{$activity->customer->name}}
                            </div>
                            <div class="col-12">
                                <span class="text-muted">Type Of Activity</span> : {{$activity->type}}
                            </div>
                            @if($activity->address!=null)
                            <div class="col-12">
                               <span class="text-muted">Address</span> :{{$activity->address}} {{$activity->township!=null?','.$activity->township:''}}
                            </div>
                            @endif
                            @if($activity->shop!=null)
                            <div class="col-12">
                               <span class="text-muted">Shop Name :</span> {{$activity->shop}}
                            </div>
                                <div class="col-12">
                                    <span class="text-muted">Sale Volume :</span> {{$activity->amount??0}}
                                </div>
                                @endif
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <strong class="mb-2">Description</strong>
                                {!! $activity->description!!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                       <span>Follower :</span>
                        @foreach($followers  as $follower )
                            <span class="mr-1">
                                <a href="" title="{{$follower->employee->name}}" data-toggle="tooltip" class="avatar">
                                    <img src="{{$follower->employee->profile_img!=null? url(asset('img/profiles/'.$follower->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                                </a>
                            </span>
                            @endforeach
                        <a href="#" class="followers-add" data-toggle="modal" data-target="#add_followers"><i class="la la-plus"></i></a>
                        <a href="#" class="followers-add" data-toggle="modal" data-target="#remove_followers"><i class="la la-trash"> </i></a>
                    </div>
                </div>
                <div class="card" style="height: 330px">
                    <div class="card-header">
                        Upload Attachment
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($files!=null)
                                <div class="card-body">
                                    <div class="row row-sm">
                                        @foreach($files as $key=>$val)
                                            <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                <div class="card card-file" style="min-width: 100px;">

                                                    @php

                                                        $infoPath = pathinfo(public_path('attach_file/'.$val));
                                                         $extension = $infoPath['extension'];

                                                    @endphp
                                                    <div class="card-file-thumb">
                                                        @if($extension=='xlsx')
                                                            <i class="fa fa-file-excel-o"></i>
                                                        @elseif($extension=='pdf')
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        @elseif($extension=='png'||'jpeg'||'gif'||'svg'||'jpg')
                                                            <i class="fa fa-image"></i>
                                                            @else
                                                            <i class="fa fa-file-word-o"></i>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <h6><a href="{{url(asset('attach_file/'.$val))}}" download>{{$val}}</a></h6>
                                                    </div>
                                                    <div class="card-footer">{{$activity->created_at->toFormattedDateString()}}
                                                        <a href="{{url(asset('attach_file/'.$val))}}" class="float-right" ><i class="fa fa-download" style="font-size: 16px;"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="commentbox">
                    <div class="card-header">Comment
                        <div class="card-body" style="overflow: scroll;max-height: 600px">
                            <ul class="files-list">
                                @foreach($comments as $comment)
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                            <a href="profile" class="avatar">
                                                <img src="{{$comment->user->profile_img!=null? url(asset('img/profiles/'.$comment->user->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
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
                        <div class="card-footer">
                            <form action="{{route('activity.comment')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="hidden" name="activity_id" value="{{$activity->id}}">
                                    <input type="text" id="text" class="form-control" name="comment">
                                    <button class="btn bnt btn-outline-primary" type="submit"><i class="fa fa-paper-plane-o"></i></button>
                                </div>
                            </form>
                        </div>
                </div>
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
                <form action="{{route('activity.addfollowed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="activity_id" value="{{$activity->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($unfollowed_emps as $emp)
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
                <form action="{{route('activity.unfollowed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="activity_id" value="{{$activity->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($followers as $follower)
                                    <option value="{{$follower->employee->id}}">{{$follower->employee->name}}</option>
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
    <!-- /Page Wrapper -->
@endsection