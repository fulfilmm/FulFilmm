@extends('layout.mainlayout')
@section('content')
{{--    <link rel="stylesheet" href="{{url(asset("js/kaban/style.css"))}}">--}}
<style>
   #cke_12,#cke_13,#cke_14,#cke_15,.cke_toolbar_separator,#cke_16,#cke_17,#cke_18,#cke_19{
        visibility: hidden;
    }
</style>
    <!-- Page Wrapper -->

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Deal</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Deal</li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto ml-auto mb-3">
                    <a href="{{route('deals.create')}}" class="btn add-btn rounded-pill" ><i class="fa fa-plus"></i> Add New</a>
                    <div class="view-icons">
                        <ul class="nav mb-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a  id="profile-tab" data-toggle="tab" href="#kaban_view" role="tab" aria-controls="profile" aria-selected="false" class="list-view btn btn-link nav-link active"><i class="fa fa-trello "></i></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="grid-view btn btn-link nav-link " id="home-tab" data-toggle="tab" href="#list_view" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-th"></i></a>
                            </li>

{{--                            <li class="nav-item" role="presentation">--}}
{{--                                <a class="list-view btn btn-link nav-link"><i class="fa fa-history mr-2"></i>Sync</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item" role="presentation">--}}
{{--                                <div class="dropdown">--}}
{{--                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                        Sort By & View By--}}
{{--                                    </button>--}}
{{--                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                                        <a class="dropdown-item" href="#">Action</a>--}}
{{--                                        <a class="dropdown-item" href="#">Another action</a>--}}
{{--                                        <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade " id="list_view" role="tabpanel" aria-labelledby="home-tab">
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
                        @foreach($alldeals as $deal)
                        <tr>
                            <td><a href="{{route('deals.show',$deal->id)}}">{{$deal->name}}</a></td>
                            <td>{{$deal->amount}} <strong class="float-right">{{$deal->unit}}</strong></td>
                            <td>{{$deal->customer_company->name}}</td>
                            <td>{{$deal->close_date}}</td>
                            <td>{{$deal->sale_stage}}</td>
                            <td>{{$deal->employee->name}}</td>
                            <td>
                                <a href="#"class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ellipsis-v ml-2 mt-2" style="font-size: 18px;"></i></a>
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
                <div class="tab-pane fade show active" id="kaban_view" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row board-view-header">
{{--                        <div class="col-4">--}}
{{--                            <div class="pro-teams">--}}
{{--                                <div class="pro-team-lead">--}}
{{--                                    <h4>Lead</h4>--}}
{{--                                    <div class="avatar-group">--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-11.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-01.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-16.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <a href="" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_leader"><i class="fa fa-plus"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="pro-team-members">--}}
{{--                                    <h4>Team</h4>--}}
{{--                                    <div class="avatar-group">--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-02.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-09.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <img class="avatar-img rounded-circle border border-white" alt="User Image" src="img/profiles/avatar-12.jpg">--}}
{{--                                        </div>--}}
{{--                                        <div class="avatar">--}}
{{--                                            <a href="" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i></a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-8 text-right">--}}
{{--                            <a href="#" class="btn btn-white float-right ml-2" data-toggle="modal" data-target="#add_task_board"><i class="fa fa-plus"></i> Create List</a>--}}
{{--                            <a href="project-view" class="btn btn-white float-right" title="View Board"><i class="fa fa-link"></i></a>--}}
{{--                        </div>--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="pro-progress">--}}
{{--                                <div class="pro-progress-bar">--}}
{{--                                    <h4>Progress</h4>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%"></div>--}}
{{--                                    </div>--}}
{{--                                    <span>20%</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div class="kanban-board card mb-0">
                        <div class="card-body">
                            <div class="kanban-cont">
                                <div class="kanban-list kanban-info">
                                    <div class="kanban-header">
                                        <span class="status-title">New</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="New")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="{{route('deals.show',$deal->id)}}">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>
                                                                </div>
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{route("deals.status_change")}}" method="POST">
                                                                                    @method('POST')
                                                                                    @csrf
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Negotiation </option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('Deal.delete')
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="kanban-list kanban-danger">
                                    <div class="kanban-header">
                                        <span class="status-title">Qualified</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="Qualified")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="task-view">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>

                                                                </div>
                                                                @include('Deal.delete')
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url("deal/status/change")}}" method="POST">
                                                                                    {{csrf_field()}}
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Negotiation </option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                                <div class="kanban-list kanban-success">
                                    <div class="kanban-header">
                                    <span class="status-title">Quotation</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap ks-empty">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="Quotation")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="task-view">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>

                                                                </div>
                                                                @include('Deal.delete')
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url("deal/status/change")}}" method="POST">
                                                                                    {{csrf_field()}}
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Negotiation </option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('Deal.delete')
                                            @endif
                                        @endforeach
                                    </div>

                                </div>
                                <div class="kanban-list kanban-warning">
                                    <div class="kanban-header">
                                        <span class="status-title">Invoicing</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="Invoicing")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="task-view">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>
                                                                </div>
                                                                @include('Deal.delete')
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url("deal/status/change")}}" method="POST">
                                                                                    {{csrf_field()}}
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Negotiation </option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>

                                <div class="kanban-list kanban-purple">
                                    <div class="kanban-header">
                                        <span class="status-title">Win</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="Win")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="task-view">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>

                                                                </div>
                                                                @include('Deal.delete')
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url("deal/status/change")}}" method="POST">
                                                                                    {{csrf_field()}}
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Negotiation </option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="kanban-list kanban-primary">
                                    <div class="kanban-header">
                                        <span class="status-title">Lost</span>
{{--                                        <div class="dropdown kanban-action">--}}
{{--                                            <a href="" data-toggle="dropdown">--}}
{{--                                                <i class="fa fa-ellipsis-v"></i>--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>--}}
{{--                                                <a class="dropdown-item" href="#">Delete</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="kanban-wrap">
                                        @foreach($alldeals as $deal)
                                            @if($deal->sale_stage=="Lost")
                                                <div class="card panel">
                                                    <div class="kanban-box">
                                                        <div class="task-board-header">
                                                            <span class="status-title"><a href="task-view">{{$deal->name}}</a></span>
                                                            <div class="dropdown kanban-task-action">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('deals.edit',$deal->id)}}">Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_modal{{$deal->id}}">Change Stage</a></li>
                                                                    <a class="dropdown-item" href="{{route('deals.show',$deal->id)}}">Detail View</a></li>
                                                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete_deal{{$deal->id}}">Delete</a></li>
                                                                </div>
                                                                @include('Deal.delete')
                                                                <div id="edit_task_modal{{$deal->id}}" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Deal Sale Stage Change</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{url("deal/status/change")}}" method="POST">
                                                                                    {{csrf_field()}}
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="deal_id" class="form-control" value="{{$deal->id}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Sale Stage</label>
                                                                                        <select name="sale_stage" id="sale_stage" class="form-control">
                                                                                            <option value="New">New</option>
                                                                                            <option value="Qualified">Qualified</option>
                                                                                            <option value="Quotation">Quatation</option>
                                                                                            <option value="Invoicing">Invoicing</option>
                                                                                            <option value="Win">Win</option>
                                                                                            <option value="Lost">Lost</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="submit-section text-center">
                                                                                        <button class="btn btn-primary submit-btn">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="task-board-body">
                                                            <div class="kanban-info">
                                                                Organization Name: <strong>{{$deal->customer_company->name}}</strong>

                                                            </div>
                                                            Amount: {{$deal->amount}} <strong class="ml-3">{{$deal->unit}}</strong>
                                                            <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o mr-2"></i>{{\Carbon\Carbon::parse($deal->close_date)->toFormattedDateString() }}</span>
                                                        <span class="task-priority badge bg-inverse-danger">{{$deal->sale_stage}}</span>
                                                    </span>
                                                                <span class="task-users">
                                                        <img src="img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24">
                                                            <span>{{$deal->employee->name}}</span>
                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
</script>
@endsection
