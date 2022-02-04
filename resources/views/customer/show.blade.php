@extends('layout.mainlayout')
@section('title','Customer Information')
@section('content')
    <style>
        .scroll {
            /*width: 300px;*/
            height: 550px;
            overflow: scroll;
        }
        .activity_schedule{
            min-height: 630px;
            overflow: scroll;
        }

    </style>
    <!-- Page Content -->
    <link rel="stylesheet" href="{{url(asset('customercss/customershow.css'))}}">
    <div class="content container">
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <h4 class="font-weight-bold d-flex align-items-center">Customer View</h4>
            </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div>
                                <ul class="list-style-1 mb-0">
                                    <li class="list-item d-flex justify-content-start align-items-center">
                                        <div class="">
                                            <img class="avatar avatar-img avatar-60 rounded-circle" src="{{$data['customer']->profile!=null? url(asset('img/profiles/'.$data['customer']->profile)):url(asset('img/profiles/avatar-01.jpg'))}}"  />
                                        </div>
                                        <div class="list-style-detail ml-4 mr-2">
                                            <h5 class="font-weight-bold">{{$data['customer']->name}}</h5>
                                            <p class="mb-0 mt-1 text-muted">{{$data['customer']->company->name}}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 text-center mb-2">
                                    @if($data['customer']->customer_type=='Supplier'||$data['customer']->customer_type=='Courier')
                                        <a href="{{route('supplierbills.create',$data['customer']->id)}}" class="btn btn-block btn-sm btn-primary">
                                            <span class="text-white"><i class="fa fa-money mr-2"></i>Paid Bill</span>
                                        </a>
                                        @else
                                    <button class="btn btn-block btn-sm btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        <span class="">Message</span>
                                    </button>
                                        @endif
                                </div>
                                <div class="col-6 text-center">
                                    <a href="{{route('customers.edit',$data['customer']->id)}}" class="btn btn-block btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span class="">Edit Profile</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Email </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$data['customer']->email}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Birthday</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{\Carbon\Carbon::parse($data['customer']->dob)->toFormattedDateString()}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Phone</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$data['customer']->phone}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">State/Region</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$data['customer']->region}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Address</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$data['customer']->address}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">Contact Level</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$data['customer']->customer_type}}</p>
                                    </td>
                                </tr>
                              @if($data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead')
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Total Invoice</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{count($data['invoice'])}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Total Sale</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$data['total_sale']}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Paid</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$data['paid_total']}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Debt</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$data['open']}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Total ticket</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{count($data['tickets'])}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Total Deal</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{count($data['deal'])}}</p>
                                        </td>
                                    </tr>
                                  @endif
                            </table>
                        </li>
                    </ul>
                </div>
                <div class="card">
                    <div class="card-header">
                        <span class="followers-title">Followers</span>
                        <div class="float-right">
                        <a href="#" class="followers-add" data-toggle="modal" data-target="#add_followers"><i class="la la-plus"></i></a>
                        <a href="#" class="followers-add" data-toggle="modal" data-target="#remove_followers"><i class="la la-trash"> </i></a>
                        </div>
                    </div>
                    <div class="project-members  mt-1 mb-4 ml-3 mr-3">
                        @foreach($followers as $follower)
                            <div class="row my-2">
                                <div class="col-12">
                                    <a href="#" data-toggle="tooltip" title="{{$follower->user->name}}" class="avatar">
                                        <img src="img/profiles/avatar-09.jpg" alt="">
                                    </a><span>{{$follower->user->name}}</span>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow-lg" style="height: 630px">
                    <div class="card-body p-0">
                        <ul class="nav tab-nav-pane nav-tabs pt-2 mb-0" id="mytab">
                            @if($data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead')
                            <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2 {{$data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead'?'active':''}}" href="#invoice">Invoice</a></li>
                            @endif
                            <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2" {{$data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead'?'':'active'}} href="#activity">Activity Schedule</a></li>
                            <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2" href="#comment">Notes</a></li>
                                <li class="pb-2 mb-0 nav-item"><a data-toggle="tab" class="font-weight-bold text-uppercase px-5 py-2" href="#item_sale">Item Amount</a></li>
                        </ul>
                        <div class="tab-content col-12" >
                            <div id="invoice" class="tab-pane fade show {{$data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead'?'active':''}} ">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5>Invoice List</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table data-table mb-0">
                                        <thead class="table-color-heading">
                                        <tr class="text-muted">
                                            <th scope="col">ID</th>
                                            <th scope="col">Date </th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['invoice'] as $invoice)
                                        <tr>
                                            <td><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></td>
                                            <td>{{\Carbon\Carbon::parse($invoice->invoice_date)->toFormattedDateString()}}</td>
                                            <td>
                                                Order OR-561488
                                            </td>
                                            <td>
                                                <p class="mb-0 text-success d-flex justify-content-start align-items-center">
                                                    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle></svg>
                                                    {{$invoice->status}}
                                                </p>
                                            </td>
                                            <td class="text-right">{{$invoice->grand_total}}</td>
                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="activity" class="tab-pane fade show {{$data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead'?'':'active'}} scroll">
                                <h5>Activity Schedule</h5>
                                <div class="bs-offset-main bs-canvas-anim mt-2">
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="canvas"
                                            data-target="#activity_schedule" aria-expanded="false"
                                            aria-controls="bs-canvas-right">Add New
                                    </button>
                                </div>


                                <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative activity_schedule" style="overflow: auto">

                                    <ul class="list-inline p-0 m-0">
                                        @foreach($data['activity_schedule'] as $activity)
                                        <li>
                                            <div class="timeline-dots timeline-dot1 border-primary text-primary pt-1"></div>
                                            <div class="pt-3">
                                                <p class="mb-0 text-muted font-weight-bold text-uppercase">{{\Carbon\Carbon::parse($activity->date_time)->toFormattedDateString()}}   {{date('h:i a', strtotime($activity->date_time))}}</p>
                                            </div>
                                        </li>
                                        <li>


                                            <div class="d-inline-block w-100">
                                                <div class="d-inline-block w-100">
                                                    <p></p>
                                                    <p class="mb-0">{{$activity->description}}</p>
                                                </div>
                                                <a href="{{route('delete_schedule',$activity->id)}}" class="btn btn-danger btn-sm float-right">Delete</a>
                                                @if($activity->work_done!=1)
                                                    @if(\Carbon\Carbon::now()>$activity->date_time)
                                                        <a href="{{route('work.done',$activity->id)}}" class="btn btn-danger float-right btn-sm mr-3">Overdue Date</a>
                                                    @else
                                                        <a href="{{route('work.done',$activity->id)}}"
                                                           class="btn btn-primary float-right btn-sm mr-3">Done</a>
                                                    @endif
                                                @else
                                                    <button class="btn btn-success float-right btn-sm mr-3"><i
                                                                class="la la-check-circle-o"></i> Complete
                                                    </button>
                                                @endif
                                            </div>
                                        </li>

                                            @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div id="comment" class="tab-pane fade " >
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
                                    <hr>
                                    <form method="POST" action="{{url("/lead/post/comment")}}" >
                                        {{csrf_field()}}
                                        <div class="row">
                                                <input type="hidden" name="lead_id" value="{{$data['customer']->id}}">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control shadow" name="comment">
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-primary shadow rounded-right" type="submit">Add Note</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="item_sale" class="tab-pane fade ">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <h5>Item List</h5>
                                </div>
                                <div class="table-responsive" style="overflow: auto">
                                    <table class="table" >
                                        <thead class="table-color-heading">
                                        <tr class="text-muted">
                                            <th style="min-width: 150px;">Date </th>
                                            <th scope="col" style="min-width: 120px;">Invoice ID</th>
                                            <th scope="col" style="min-width: 120px;">Product Code</th>
                                            <th scope="col" style="min-width: 150px;">Product Name</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col" style="min-width: 120px;">Unit</th>
                                            <th scope="col" style="min-width: 120px;">Unit Price</th>
                                            <th scope="col" class="text-right" style="min-width: 120px;">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td style="min-width: 100px;">{{$item->created_at->toFormattedDateString()}}</td>
                                                <td>{{$item->invoice->invoice_id}}</td>
                                                <td>{{$item->variant->product_code}}</td>
                                                <td>{{$item->variant->product_name}}</td>
                                                <td>{{$item->quantity}}</td>
                                                <td>{{$item->unit->unit}}</td>
                                                <td>{{$item->unit_price}}</td>
                                                <td>{{$item->total}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="activity_schedule" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed bg-light h-100"
                 style="max-width: 300px;margin-top: 50px;">
                <header class="bs-canvas-header p-3 bg-primary overflow-auto">
                    <button type="button" class="bs-canvas-close float-left close" aria-label="Close"><span aria-hidden="true"
                                                                                                             class="text-dark">&times;</span>
                    </button>
                    <strong class="d-inline-block text-light mb-0  ml-2 float-left">Add Activity Schedule</strong>
                </header>
                <div class="bs-canvas-content px-3 py-5">
                    <form action="{{route('activity.schedule')}}" method="post">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{$data['customer']->id}}">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Cold Calling">Cold Calling</option>
                                <option value="Phone Call">Phone Call</option>
                                <option value="Follow Up">Follow Up</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Event">Event</option>
                                <option value="Visit">Visit</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="date_time">Date Time</label>
                            <input type="text" name="date_time" id="date_time" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-danger ml-2 text-sm  btn-md" id="add">Add Item</button>
                        </div>
                    </form>
                </div>

            </div>
            <div id="assign" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed bg-light h-100"
                 style="max-width: 300px;margin-top: 50px;">
                <header class="bs-canvas-header p-3 bg-primary overflow-auto">
                    <button type="button" class="bs-canvas-close float-left close" aria-label="Close"><span aria-hidden="true"
                                                                                                            class="text-dark">&times;</span>
                    </button>
                    <strong class="d-inline-block text-light mb-0  ml-2 float-left">Add Activity Schedule</strong>
                </header>
                <div class="bs-canvas-content px-3 py-5">
                    <form action="{{route('activity.schedule')}}" method="post">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{$data['customer']->id}}">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Cold Calling">Cold Calling</option>
                                <option value="Phone Call">Phone Call</option>
                                <option value="Follow Up">Follow Up</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Event">Event</option>
                                <option value="Visit">Visit</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="end_date">Date Time</label>
                            <input type="text" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-danger ml-2 text-sm  btn-md" id="add">Add Item</button>
                        </div>
                    </form>
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
                <form action="{{route('leads.followed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" value="{{$data['customer']->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($allemps as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
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
                <form action="{{route('unfollowed')}}" id="follower" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="lead_id" value="{{$data['customer']->id}}">
                        <div class="row">
                            <select class="select" name="follower[]" multiple style="width: 100%">
                                @foreach($allemps as $key=>$val)
                                    @foreach($followers as $follower)
                                        @if($follower->user->id==$key)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endif

                                    @endforeach
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
    <script>
        jQuery(document).ready(function () {
            'use strict';

            jQuery('#date_time').datetimepicker();
        });
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#mytab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
@endsection