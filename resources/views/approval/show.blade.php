@extends('layout.mainlayout')
@section('title','Approval Detail View')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->

        <div class="chat-main-row mt-4">
            <div class="chat-main-wrapper">
                <div class="col-lg-8 message-view task-view">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <div class="navbar">
                                <div class="float-left ticket-view-details">
                                    <div class="ticket-header">
                                        <span class="m-l-15 text-muted">Approver: </span>
                                        <a href="#">{{$details_approval->approver->name}}</a>
                                        <span class="m-l-15 text-muted">Secondary Approver: </span>
                                        <span>{{$details_approval->secondary_approved ? $details_approval->secondary_approver->name:"N/A"}}</span>
                                        <span class="m-l-15 text-muted">Target Date: </span>
                                        <span>{{\Carbon\Carbon::parse($details_approval->target_date)->toFormattedDateString()}} </span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <span>Status: </span>
                                    <div class="nav-item dropdown dropdown-action btn btn-outline-white border btn-sm rounded-pill">
                                        <a href="" class="dropdown-toggle rounded-pill" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$details_approval->state=='Approve'?'success':($details_approval->state=='Reject'?'danger':($details_approval->state=='Pending'?'primary':'secondary'))}}"></i> {{$details_approval->state ? :"New"}}</a>
                                        @if($details_approval->approved_id == \Illuminate\Support\Facades\Auth::guard('employee')->user()->id||$details_approval->secondary_approved==\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#add-category">Change Status</a>
                                            </div>
                                        @else
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item">You Doesn't not have permission to Change Status</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                            </div>
                        </div>
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="task-wrapper">
                                            <div class="card">
                                                <div class="card-header">
                                                    Approval Details
                                                </div>
                                                <div class="card-body">
                                                    <table>
                                                        <tr style="padding-top: 20px">
                                                            <td style="min-width: 150px" class="text-muted">Approval Type</td>
                                                            <td>: {{$details_approval->type}}</td>
                                                        </tr>
                                                        <tr style="padding-top: 20px">
                                                            <td style="min-width: 150px" class="text-muted">Approval Title</td>
                                                            <td>: {{$details_approval->title}}</td>
                                                        </tr>
                                                       @if($details_approval->type=='Business Trip')

                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Period Date</td>
                                                                <td>: {{\Carbon\Carbon::parse($details_approval->from_date)->toFormattedDateString()}} - {{\Carbon\Carbon::parse($details_approval->to_date)->toFormattedDateString()}} </td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Location</td>
                                                                <td>: {{$details_approval->location}} </td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Budget</td>
                                                                <td>: {{$details_approval->amount}} MMK</td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                @php
                                                                    $members=json_decode($details_approval->trip_members);
                                                                @endphp
                                                                <td style="min-width: 150px" class="text-muted">Trip Member</td>
                                                                <td>: @foreach($members as $member) {{trim($member,',')}}, @endforeach</td>

                                                            </tr>
                                                           @elseif($details_approval->type=='Payment')
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Contact</td>
                                                                <td>: {{$details_approval->contact->name}} </td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Amount</td>
                                                                <td>: {{$details_approval->amount}} MMK</td>

                                                            </tr>
                                                        @elseif($details_approval->type=='Procurement')
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Contact</td>
                                                                <td>: {{$details_approval->contact->name??'N/A'}} </td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Quantity</td>
                                                                <td>: {{$details_approval->quantity}} </td>

                                                            </tr>
                                                            <tr style="padding-top: 20px">
                                                                <td style="min-width: 150px" class="text-muted">Amount</td>
                                                                <td>: {{$details_approval->amount}} MMK</td>

                                                            </tr>
                                                           @endif
                                                        <tr>
                                                           <td class="text-muted" style="min-width: 150px">Requester Name</td>
                                                            <td> : {{$details_approval->request_emp->name}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="project-title">
                                                        <div class="m-b-20">
                                                            <span class="h5 card-title ">Description</span>

                                                        </div>
                                                    </div>

                                                    <p>{{$details_approval->content}} </p>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title m-b-20">Uploaded Document files</h5>
                                                    <div class="row">
                                                        @if($doc_files!=null)
                                                            <div class="card-body">
                                                                <div class="row row-sm">
                                                                    @foreach($doc_files as $key=>$val)
                                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                                                                            <div class="card card-file" style="min-width: 100px;">

                                                                                @php

                                                                                    $infoPath = pathinfo(public_path('approval_doc/'.$val));
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
                                                                                    <h6><a href="{{url(asset('approval_doc/'.$val))}}" download>{{$val}}</a></h6>
                                                                                </div>
                                                                                <div class="card-footer">{{$details_approval->created_at->toFormattedDateString()}}
                                                                                    <a href="{{url(asset('approval_doc/'.$val))}}" class="float-right" ><i class="fa fa-download" style="font-size: 16px;"></i></a>
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
                                        <div class="notification-popup hide">
                                            <p>
                                                <span class="task">dgfsdg</span>
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
                                <div class="task-assign mt-2">
                                    <span class="m-l-15 text-muted ">  Comment</span>
                                </div>

                            </div>
                        </div>
                        <div class="chat-contents task-chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats" id="cmt">
                                            @foreach($all_cmt as $cmt)
                                            <div class="chat chat-left">
                                                <div class="nav float-right custom-menu">
                                                    <a href="{{route('approval_cmt.delete',$cmt->id)}}" class="followers-add" data-toggle="tooltip" data-placement="bottom" ><i class="la la-trash-o"></i></a>
                                                </div>
                                                <div class="chat-avatar">
                                                    <a href="#" class="avatar">
                                                        <img src="{{url(asset('img/profiles/avatar-02.jpg'))}}" alt="">
                                                    </a>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-bubble">
                                                        <div class="chat-content">
                                                            <span class="task-chat-user">{{$cmt->cmt_user->name}}</span> <span class="chat-time">{{$cmt->created_at->toFormattedDateString()}}</span>
                                                            <p>{{$cmt->cmt_text}}</p>
                                                        </div>
                                                    </div>
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
                                    <div class="message-area" id="input_area">
                                        <div class="input-group">
                                            <textarea class="form-control" id="message" name="message" placeholder="Type message..."></textarea>
                                            <span class="input-group-append">
                                                <button class="btn btn-primary" type="button" id="comment_submit"><i class="fa fa-send"></i></button>
                                            </span>
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

    <!-- Add Category Modal-->
    <div class="modal custom-modal fade" id="add-category">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Status</h4>
                </div>
                    <form action="{{route('approvals.update',$details_approval->id)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body p-20">
                        <div class="col-md-12">
                            <label for="status" class="col-form-label">Choose Status</label>
                            <select id="status" class="form-control" data-placeholder="Choose a color..." name="status">
                                @foreach($status as $key=>$val)
                                    <option value="{{$val}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success ">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#comment_submit', function () {

                // var customer_id=$("#customer_id").val();
                var cmt_text=$("#message").val();
                $.ajax({
                    data : {
                        cmt_text:cmt_text
                    },
                    type:'POST',
                    url:"{{url("approval/post/comment/$details_approval->id")}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        $("#cmt").load(location.href + " #cmt>* ");
                        $("#input_area").load(location.href + " #input_area>* ");

                    }
                });
            });
        });
    </script>
    <!-- /Add Category Modal-->
    <!-- /Page Wrapper -->
@endsection
