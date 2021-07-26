@extends('layout.mainlayout')
@section('content')
    <link rel="stylesheet" href="{{url(asset('css/ticket.css'))}}">

        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Tickets</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i class="fa fa-plus"></i> Add Ticket</a>
                        <a href="{{route('inqueries.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Inquery</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">New Tickets</span>
                                    </div>
                                    <div>
                                        <span class="text-success">{{$report_percentage['New']}}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$status_report['New']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Solved Tickets</span>
                                    </div>
                                    <div>
                                        <span class="text-success">{{$report_percentage['Solve']}}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$status_report['Complete']+$status_report['Close']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Open Tickets</span>
                                    </div>
                                    <div>
                                        <span class="text-danger">{{$report_percentage['Open']}}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$status_report['Open']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <span class="d-block">Pending Tickets</span>
                                    </div>
                                    <div>
                                        <span class="text-danger">{{$report_percentage['Pending']}}%</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$status_report['Pending']}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Filter -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <label class="focus-label">Assign Staff</label>
                        <select name="emp_name" class="form-control floating" id="emp_name">
                            <option value="">All</option>
                            @foreach($all_emp as $agent)
                            <option value="{{$agent->name}}">{{$agent->name}}</option>
                            @endforeach
                                <option disabled>Department</option>
                                @foreach($depts as $dept)
                                    <option value="{{$dept->name}}">{{$dept->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="status">
                            <option value="">All</option>
                            @foreach($statuses as $status)
                            <option value="{{$status->name}}"> {{$status->name}} </option>
                            @endforeach
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="priority">
                            <option value="">All</option>
                            @foreach($priorities as $priority)
                                <option value="{{$priority->priority}}">{{$priority->priority}}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Priority</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input type="text" id="min" class="date-range-filter form-control floating datetimepicker" name="min">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input type="text" class="date-range-filter form-control floating datetimepicker" id="max" name="max">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <a href="#" class="btn btn-success btn-block"> Search </a>
                </div>
            </div>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" id="ticket">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket Id</th>
                                <th>Ticket Subject</th>
                                <th>Assigned Staff</th>
                                <th>Created Date</th>
                                <th>Last Reply</th>
                                <th>Priority</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($all_tickets as $ticket)
                            <tr>
                                <td>{{$ticket->id}}</td>
                                <td><a href="{{route('tickets.show',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                                <td>{{$ticket->title}}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#">
                                           @foreach($assign_ticket as $assign_staff)
                                               @if($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign ==0)
                                                    <a class="avatar avatar-xs" href="profile"><img alt="" src="img/profiles/avatar-10.jpg"></a>
                                                        {{$assign_staff->agent->name}}
                                                   @elseif($assign_staff->ticket_id==$ticket->id && $assign_staff->type_of_assign ==1)
                                                    <a class="" href=""><i class="la la-users avatar avatar-xs"></i></a>
                                                   {{$assign_staff->dept->name}}
                                                   @endif
                                            @endforeach
                                        </a>
                                    </h2>
                                </td>
                                <td>{{$ticket->created_at->toFormattedDateString()}}</td>
                                <td></td>

                                <td>
                                    {{$ticket->ticket_priority->priority}}

                                </td>
                                <td>{{$ticket->ticket_status->name}}

                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#change_status{{$ticket->id}}"><i class="fa fa-pencil m-r-5"></i>Status Edit</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_ticket"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                                @include('ticket.edit')
                                @include('ticket.status_change')
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

       @include('ticket.create')



        <!-- Delete Ticket Modal -->
        @include('ticket.delete')
    <script src="{{url(asset('/js/filterdaterange.js'))}}"></script>
        <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('#emp_name').select2({
                        "language": {
                            "noResults": function(){
                                return "No Results";
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        }

                    }

                );
            });
            $('#emp_name').on('change', function () {
                var table = $('#ticket').DataTable();
                table.column(3).search($(this).val()).draw();
            });
        });
        $(document).ready(function() {
            $('#priority').on('change', function () {
                var table = $('#ticket').DataTable();
                table.column(6).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#status').on('change', function () {
                var table = $('#ticket').DataTable();
                table.column(7).search($(this).val()).draw();

            });
        });
//
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#files").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<div class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><div class=\"remove\"><i class='fa fa-remove'>Remove</div>" +
                                "</div>").insertAfter("#files");
                            $(".remove").click(function(){
                                $(this).parent(".pip").remove();
                            });


                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
        $(document).ready(function (){
                // var min=document.getElementById('min').val();
             $('#min').on('select',function (){
                 var max=$('#min').val();
                 var max=$('#max').val();
                 alert(max);
             })


        });
    </script>
        <!-- /Delete Ticket Modal -->
@endsection

