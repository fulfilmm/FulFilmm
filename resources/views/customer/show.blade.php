@extends('layout.mainlayout')
@section('title','Customer Information')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Customer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customer</li>
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
                                    <a href="#"><img alt="" src="img/profiles/avatar-02.jpg"></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Name:</div>
                                                <div class="text">{{$data['customer']->name}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="">{{$data['customer']->phone}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><a href="">{{$data['customer']->email}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Company:</div>
                                                <div class="text">{{$data['customer']->company->name}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
                                                <div class="text">{{$data['customer']->address}}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#invoice" data-toggle="tab" class="nav-link active">Invoices <span class="badge badge-primary">{{count($data['invoice'])}}</span></a></li>
                        <li class="nav-item"><a href="#ticket" data-toggle="tab" class="nav-link">Tickets <span class="badge badge-primary">{{count($data['tickets'])}}</span></a></li>
                        <li class="nav-item"><a href="#lead" data-toggle="tab" class="nav-link">Lead <span class="badge badge-primary">{{count($data['lead'])}}</span></a></li>
                        <li class="nav-item"><a href="#deal" data-toggle="tab" class="nav-link">Deal <span class="badge badge-primary">{{count($data['deal'])}}</span></a></li>
                        <li class="nav-item"><a href="#quotation" data-toggle="tab" class="nav-link">Quotation <span class="badge badge-primary">{{count($data['quotation'])}}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">

            <!-- Profile Info Tab -->
            <div id="invoice" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table  mb-0" id="invoice">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice Number</th>
                                    <th>Client</th>
                                    <th>Created Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['invoice'] as $invoice)
                                    <tr>
                                        <td>{{$invoice->id}}</td>
                                        <td><a href="{{route('invoices.show',$invoice->id)}}">#{{$invoice->invoice_id}}</a></td>
                                        <td>{{$invoice->customer->name}}</td>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                        <td>{{$invoice->grand_total}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1"></i>{{$invoice->status}}</a>
                                                {{--<a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}"></a>--}}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    {{--                                                    <a class="dropdown-item" href="{{route("invoices.edit",$invoice->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                    <a class="dropdown-item" href="{{route("invoices.show",$invoice->id)}}"><i class="fa fa-eye m-r-5"></i> View</a>
                                                    {{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>--}}
                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delete{{$invoice->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @include('invoice.delete')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--                    <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=Asia%2FYangon&amp;src=Y2luY2luLmNvbUBnbWFpbC5jb20&amp;src=NWpkNG91cWVzNGY5a3NibmwwajB1dmlzY2NAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=Ym5nM2dvZGwzOWo5Y29zY2hsaTdsOXF2bzRAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%237986CB&amp;color=%23D50000&amp;color=%23F09300" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>--}}
                </div>
            </div>
            <!-- /Profile Info Tab -->

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="ticket">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="ticket">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width: 100px;">Ticket Id</th>
                                    <th style="min-width: 150px">Ticket Subject</th>
                                    <th style="min-width: 150px">Assigned Staff</th>
                                    <th style="min-width: 130px">Created Date</th>
                                    <th style="min-width: 150px;">Created Employee</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                    <th style="min-width: 150px;">Last Status Change </th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['tickets'] as $ticket)
                                    <tr>
                                        <td>{{$ticket->id}}</td>
                                        <td><a href="{{route('tickets.show',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                                        <td>{{$ticket->title}}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#">
                                                    @if($ticket->isassign==1)
                                                        @foreach($assign_ticket as $assign_staff)
                                                            @if($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign =="agent")
                                                                <a class="avatar avatar-xs" href=""><img alt="" src="{{url(asset('img/profiles/avatar-10.jpg'))}}"></a>
                                                                {{$assign_staff->agent->name}}
                                                            @elseif($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign =='dept')
                                                                <a class="" href=""><i class="la la-users avatar avatar-xs"></i></a>
                                                                {{$assign_staff->dept->name}}
                                                            @endif
                                                        @endforeach

                                                    @endif

                                                </a>
                                            </h2>

                                        </td>
                                        <td>{{$ticket->created_at->toFormattedDateString()}}</td>
                                        <td>{{$ticket->created_by->name}}</td>

                                        <td style="min-width: 150px;">
                                            <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-{{$ticket->ticket_priority->color}}"></i> {{$ticket->ticket_priority->priority}}</a>

                                        </td>
                                        <td style="min-width: 150px;">
                                            @foreach($status_color as $staus=>$color)
                                                @if($staus==$ticket->ticket_status->name)
                                                    <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o mr-1" style="color:{{$color}}"></i>{{$ticket->ticket_status->name}}</a>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('tickets.show',$ticket->id)}}"><i class="la la-eye m-r-5"></i>View Ticket</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket{{$ticket->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        {{--                                @include('ticket.edit')--}}
                                        @include('ticket.delete')
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Projects Tab -->

            <!-- Bank Statutory Tab -->
            <div class="tab-pane fade" id="lead">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div style="overflow-x: auto">
                            {{--            @dd($followers)--}}
                            <table id="lead" class="table  table-nowrap custom-table mb-0 ">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead ID</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Phone</th>
                                    <th>Lead Title</th>
                                    <th>Sale Person</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Industry</th>
                                    <th>Created</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['lead'] as $lead)
                                    <tr>
                                        <td>{{$lead->id}}</td>
                                        <td>{{$lead->lead_id}}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if($lead->customer->profile==null)
                                                    <a href="#" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                                    <a href="#">{{$lead->customer->customer_name}}</a>
                                                @else
                                                    <a href="{{url("/profile/".$lead->customer->id)}}" ><img alt="" class="avatar" src="{{asset("/profile/".$lead->customer->profile)}}"></a>
                                                    <a href="{{url("/profile/".$lead->customer->id)}}">{{$lead->customer->customer_name}}</a>
                                                @endif
                                            </h2>
                                        </td>
                                        <td>{{$lead->customer->email}}</td>
                                        <td>{{$lead->customer->phone}}</td>
                                        <td><a href="{{route('leads.show',$lead->id)}}">{{$lead->title}}</a></td>
                                        <td><a href="">
                                                @if($lead->customer->profile==null)
                                                    <a href="{{url("/emp/profile/$lead->sale_man_id")}}" class="avatar"><img alt="" src="img/profiles/avatar-11.jpg"></a>
                                                    {{$lead->saleMan->name}}
                                                @else
                                                    <a href="{{url("/emp/profile/$lead->sale_man_id")}}" >
                                                        <img alt="" class="avatar" src="{{asset("/profile/".$lead->saleMan->emp_profile)}}"></a>
                                                    {{$lead->saleMan->name}}
                                            </a>
                                            @endif
                                            </a>
                                        </td>
                                        <td>
                                            {{$lead->priority}}
                                        </td>
                                        <td>@if($lead->is_qulified==1)
                                                <span class="badge bg-inverse-success">Qualified</span>
                                            @else
                                                <span class="badge bg-inverse-danger">Unqualified</span>
                                            @endif
                                        </td>
                                        <td>{{$lead->tags->tag_industry}}
                                        </td>
                                        <td>{{$lead->created_at->toFormattedDateString()}}</td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('leads.edit',$lead->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{url("/lead/delete/$lead->id")}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Bank Statutory Tab -->
            <div class="tab-pane fade" id="deal">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div style="overflow-x: auto">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Deal Name</th>
                                    <th>Amount</th>
                                    <th>Organization</th>
                                    <th>Expected Close Date</th>
                                    <th>Sale Stage</th>
                                    <th>Assign To</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['deal'] as $deal)
                                    <tr>
                                        <td><a href="{{route('deals.show',$deal->id)}}">{{$deal->name}}</a></td>
                                        <td>{{$deal->amount}} <strong class="float-right">{{$deal->unit}}</strong></td>
                                        <td>{{$deal->customer_company->name}}</td>
                                        <td>{{$deal->close_date}}</td>
                                        <td>{{$deal->sale_stage}}</td>
                                        <td>{{$deal->employee->name}}</td>
                                        <td>
                                            <a href="#" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v ml-2 mt-2" style="font-size: 18px;"></i></a>
                                            <div class="dropdown-menu">
                                                <a href="{{route('deals.edit',$deal->id)}}" class="dropdown-item"><i class="fa fa-edit mr-2"></i>Edit</a>
                                                <a href="{{route('deals.destroy',$deal->id)}}" class="dropdown-item"><i class="fa fa-trash-o mr-2"></i>Delete</a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="quotation">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div style="overflow-x: auto">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Sale Person</th>
                                    <th>Payment Term</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['quotation'] as $quotation)
                                    <tr>
                                        <td><a href="{{route('quotations.show',$quotation->id)}}">#{{$quotation->quotation_id}}</a></td>
                                        <td>{{$quotation->customer->name}}</td>
                                        <td>{{$quotation->sale_person->name}}</td>
                                        <td>{{$quotation->payment_term}}</td>
                                        <td>{{$quotation->grand_total}}</td>
                                        <td class="text-center">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url("/quotation/edit/$quotation->id")}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_quotation{{$quotation->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete_quotation{{$quotation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content  modal-sm mr-auto ml-auto">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Quotation</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                <span>
                                                    Are you sure delete "{{$quotation->quotation_id}}"?
                                              </span>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <button data-dismiss="modal" class="btn btn-outline-primary">No</button>
                                                            <a href="{{route("quotations.destroy",$quotation->id)}}" class="btn btn-danger  my-2">Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    </div>
    <!-- /Page Content -->
    @endsection