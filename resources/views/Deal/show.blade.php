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
                                    <span>Sale Stage: </span> <span class="badge badge-warning">{{$deal->sale_stage}}</span>
                                    <span class="m-l-15 text-muted">Client Organization: </span>
{{--                                    @dd($deal)--}}
                                    <a href="#">{{$deal->customer_company->name}}</a>
                                    <span class="m-l-15 text-muted">Created: </span>
                                    <span>{{$deal->created_at->toFormattedDateString()}}</span>
                                    <span class="m-l-15 text-muted">Created by:</span>
                                    <span><a href="profile">{{$deal->created_person->name}}</a></span>

                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                        </div>
                    </div>
                    <br>

                    <span id="clock-placeholder"></span>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="task-wrapper">
                                        <div class="card">
                                            <div class="card-header">Description</div>
                                            <div class="card-body">
                                                <div class="project-title">
                                                    <div class="m-b-20">
                                                        <span class="h5 card-title ">{{$deal->description}}</span>
                                                    </div>
                                                </div>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="card mb-0">
                                            <h5 class="card-header m-b-20">Next Plan</h5>
                                            <div class="card-body">
                                                <span>{{$deal->next_step}}</span>
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
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$deal->employee->name}}" class="avatar">
                                    <img src="img/profiles/avatar-02.jpg" alt=""></a>
{{--                                            <a href="#" class="followers-add" title="Reassign" data-toggle="modal" data-target="#assignee"><i class="la la-arrow-right"></i></a>--}}
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
                                        <div class="row " style="background-color: #d6ded5">
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
                                        <div class="row mt-2" style="background-color: #d6ded5">
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
                                        <div class="row mt-2" style="background-color: #d6ded5" >
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
                                        <div class="row mt-2" style="background-color: #d6ded5">
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
                                        <div class="row mt-2" style="background-color: #d6ded5">
                                            <div class="col-6">
                                                <span>Lost Reason</span>
                                            </div>
                                            <div class="col-6">: {{$deal->lost_reason}}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Page Wrapper -->
@endsection
