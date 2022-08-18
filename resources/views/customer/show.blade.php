@extends('layout.mainlayout')
@section('title','Customer Information')
@section('content')
    <link rel="stylesheet" href="{{url(asset('customercss/customershow.css'))}}">
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Customer Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="">
                                        <img src="{{$data['customer']->profile!=null? url(asset('img/profiles/'.$data['customer']->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0">{{$data['customer']->company->name}}</h3>
                                            <h5 class="company-role m-t-0 mb-0">{{$data['customer']->name}}</h5>
                                            <small class="text-muted">{{$data['customer']->position??'N/A'}}</small>
                                            <div class="staff-id">Gender : {{$data['customer']->gender}}</div>
                                            <div class="staff-id">DOB : {{$data['customer']->dob==null?'N/A':\Carbon\Carbon::parse($data['customer']->dob)->toFormattedDateString()}}</div>
                                            <div class="staff-id">Department : {{$data['customer']->department??'N/A'}}</div>
                                            <div class="staff-id">Contact Level : {{$data['customer']->customer_type}}</div>
                                            <div class="staff-id">Customer ID : {{$data['customer']->customer_id}}</div>
                                            <div class="staff-id">Report To : {{$data['customer']->report_to??'N/A'}} ({{$data['customer']->position_of_report_to??'Unkown Position'}})</div>
                                            <div>
                                                {{$data['customer']->bio}}
                                            </div>
                                            <div class="row">
                                                <div class="staff-msg"><a href="#" class="btn btn-custom">Send Message</a></div>
                                                <div class="staff-msg ml-2"><a href="{{route('customers.edit',$data['customer']->id)}}" class="btn btn-info">Edit</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Phone:</span>
                                                <span class="text">{{$data['customer']->phone}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text">{{$data['customer']->email}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Address:</span>
                                                <span class="text">{{$data['customer']->address??'N/A'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Facebook:</span>
                                                <span class="text">{{$data['customer']->facebook??'N/A'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Linkedin:</span>
                                                <span class="text">{{$data['customer']->linkedin??'N/A'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Total Deal:</span>
                                                <span class="text">{{count($data['deal'])}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Credit Amount:</span>
                                                <span class="text">{{$data['customer']->current_credit??0}} MMK</span>
                                            </li>
                                            @if($data['customer']->status=='Qualified' && $data['customer']->customer_type=='Lead')
                                                <li>
                                                    <span class="title">Total Invoice:</span>
                                                    <span class="text">{{count($data['invoice'])}}</span>
                                                </li>
                                                <li>
                                                    <span class="title">Total tickets:</span>
                                                    <span class="text">{{count($data['tickets'])}}</span>
                                                </li>
                                                <li>
                                                    <span class="title">Total Sales:</span>
                                                    <span class="text">{{$data['total_sale']}}</span>
                                                </li>
                                                <li>
                                                    <span class="title">Paid:</span>
                                                    <span class="text">{{$data['paid_total']}}</span>
                                                </li>


                                            @endif
                                            <li>
                                                <span class="title">Followers :</span>
                                                <span class="text"><a href="#" class="followers-add" data-toggle="modal" data-target="#add_followers"><i class="la la-plus"></i></a>
                                                    <a href="#" class="followers-add" data-toggle="modal" data-target="#remove_followers"><i class="la la-trash"> </i></a></span>

                                            </li>
                                            <li>
                                                @foreach($followers as $follower)
                                                    <div class="row my-2">
                                                        <div class="col-12">
                                                            <a href="#" data-toggle="tooltip" title="{{$follower->user->name}}" class="avatar">
                                                                <img src="img/profiles/avatar-09.jpg" alt="">
                                                            </a><span>{{$follower->user->name}}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <!-- Task Tab -->
               <div class="col-12 card">
                   <div class="project-task mt-3">
                       <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                           <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">Invoices</a></li>
                           <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Activity Schedule</a></li>
                           <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Notes</a></li>
                       </ul>
                       <div class="tab-content">
                           <div class="tab-pane show active" id="all_tasks">
                             <div class="col-12" style="overflow: auto">
                                 <h5>Invoice :</h5>
                                 <table class="table table-nowrap mb-0 table-hover" id="invoice">
                                     <thead>
                                     <tr>
                                         <th>Invoice Number</th>
                                         <th>Sale Type</th>
                                         <th>Invoice Type</th>
                                         <th>Sale Man</th>
                                         <th>Created Date</th>
                                         <th>Due Date</th>
                                         <th>Amount</th>
                                         <th>Due Amount</th>
                                         <th>Status</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     @foreach($data['invoice'] as $invoice)
                                         <tr>
                                             @if(\Illuminate\Support\Facades\Auth::guard('employee')->check())
                                                 <td>@if($invoice->cancel==1)
                                                         <strike><a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a></strike>
                                                     @else
                                                         <a href="{{route('invoices.show',$invoice->id)}}">{{$invoice->invoice_id}}</a>
                                                     @endif
                                                 </td>
                                             @else
                                                 <td>
                                                     @if($invoice->cancel==1)
                                                         <strike>
                                                             <a href="{{route("customer.invoice_show",$invoice->id)}}">#{{$invoice->invoice_id}}</a></strike>
                                                     @else
                                                         <a href="{{route("customer.invoice_show",$invoice->id)}}">#{{$invoice->invoice_id}}</a>
                                                     @endif
                                                 </td>
                                             @endif
                                             <td>@if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->inv_type}}</strike>
                                                 @else
                                                     {{$invoice->inv_type}}
                                                 @endif
                                             </td>
                                             <td>@if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->invoice_type}}</strike>
                                                 @else
                                                     {{$invoice->invoice_type}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->employee->name}}
                                                     </strike>
                                                 @else
                                                     {{$invoice->employee->name}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->created_at->toFormattedDateString()}}
                                                     </strike>
                                                 @else
                                                     {{$invoice->created_at->toFormattedDateString()}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <strike>
                                                         {{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}
                                                     </strike>
                                                 @else
                                                     {{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->grand_total}}
                                                     </strike>
                                                 @else
                                                     {{$invoice->grand_total}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <strike>
                                                         {{$invoice->due_amount}}
                                                     </strike>
                                                 @else
                                                     {{$invoice->due_amount}}
                                                 @endif
                                             </td>
                                             <td>
                                                 @if($invoice->cancel==1)
                                                     <div class="dropdown action-label">
                                                         <a class="btn btn-danger btn-sm btn-rounded " href="#" data-toggle="dropdown"
                                                            aria-expanded="false"><i
                                                                     class="fa fa-dot-circle-o mr-1"></i>Cancel</a>
                                                     </div>
                                                 @else
                                                     <div class="dropdown action-label">
                                                         <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown"
                                                            aria-expanded="false"><i
                                                                     class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                         {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                                     </div>
                                                 @endif
                                             </td>
                                         </tr>
                                         @include('invoice.delete')
                                     @endforeach
                                     </tbody>
                                 </table>
                             </div>
                           </div>
                           <div class="tab-pane" id="pending_tasks">
                               <div class="col-12">
                                   <section class="vh-100" style="background-color: #eee;">

                                   <div class="container py-5 h-100">
                                       <div class="row d-flex justify-content-center align-items-center h-100">
                                           <div class="col-md-12 col-xl-12">

                                               <div class="card">
                                                   <div class="card-header p-3">
                                                       <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Activity Schedule :</h5>
                                                   </div>
                                                   <div class="col-12">
                                                       <div class="bs-offset-main bs-canvas-anim mt-2">
                                                           <button class="btn btn-primary btn-sm" type="button" data-toggle="canvas"
                                                                   data-target="#activity_schedule" aria-expanded="false"
                                                                   aria-controls="bs-canvas-right">Add New
                                                           </button>
                                                       </div>
                                                   </div>
                                                   <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">

                                                       <table class="table mb-0">
                                                           <thead>
                                                           <tr>
                                                               <th scope="col">Employee</th>
                                                               <th scope="col">Title</th>
                                                               <th scope="col">Type</th>
                                                               <th scope="col">Date</th>
                                                               <th scope="col">Status</th>
                                                               <th scope="col">Actions</th>
                                                           </tr>
                                                           </thead>
                                                           <tbody>
                                                           @foreach($data['activity_schedule'] as $activity)
                                                           <tr class="fw-normal">
                                                               <th>
                                                                   <img src="{{$activity->employee->profile_img!=null? url(asset('img/profiles/'.$activity->employee->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}"
                                                                        class="shadow-1-strong rounded-circle" alt="avatar 1"
                                                                        style="width: 55px; height: auto;">
                                                                   <span class="ms-2">{{$activity->employee->name}}</span>
                                                               </th>
                                                               <td>
                                                                   {{$activity->description}}
                                                               </td>
                                                               <td class="align-middle">
                                                                   <span>{{$activity->type}}</span>
                                                               </td>
                                                               <td>{{\Carbon\Carbon::parse($activity->date_time)->toFormattedDateString()}} {{date('h:i a', strtotime(\Carbon\Carbon::parse($activity->date_time)))}}</td>
                                                               <td class="align-middle">
                                                                   <h6 class="mb-0"> @if($activity->work_done!=1)
                                                                           @if(\Carbon\Carbon::now()>$activity->date_time)
                                                                               <span class="text-danger"> Overdue </span>
                                                                           @else
                                                                               <span class="text-info">Working</span>
                                                                           @endif
                                                                       @else
                                                                           <span class="text-success  btn-sm mr-3"> Done
                                                                           </span>
                                                                       @endif</h6>
                                                               </td>
                                                               <td class="align-middle">
                                                                   <a href="{{route('work.done',$activity->id)}}" class="btn btn-info  btn-sm mr-3">Done</a>
                                                                   <a href="{{route('delete_schedule',$activity->id)}}" class="btn btn-danger btn-sm">Delete</a>
                                                               </td>
                                                           </tr>
                                                           @endforeach
                                                           </tbody>
                                                       </table>

                                                   </div>
                                               </div>

                                           </div>
                                       </div>
                                   </div>
                                   </section>
                               </div>
                           </div>
                           <div class="tab-pane" id="completed_tasks">
                              <div class="col-12 my-3">
                                  <h5>Notes :</h5>
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
                       </div>
                   </div>
               </div>
                <!-- /Task Tab -->

            </div>
        </div>
        <div id="activity_schedule" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed bg-light h-100"
             style="max-width: 300px;margin-top: 50px;">
            <header class="bs-canvas-header p-3 bg-info overflow-auto">
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