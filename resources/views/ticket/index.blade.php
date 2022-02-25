@extends('layout.mainlayout')
@section('title','Tickets')
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
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{route('tickets.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Ticket</a>
                        {{--ပြန်ဖြတ်ထားတာ--}}
                        {{--<a href="{{route('inqueries.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Inquery</a>--}}
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <input type="text" class="form-control floating shadow-sm" id="ticket_id" placeholder="All" value="#">
                        <label class="focus-label">Ticket ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <label class="focus-label">Assign Staff</label>
                        <select name="emp_name" class="form-control floating" id="emp_name">
                            <option value="">All</option>
                            @foreach($all_emp as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                                <option disabled>Department</option>
                                @foreach($depts as $key=>$val)
                                    <option value="{{$val}}">{{$val}}</option>
                                @endforeach
                            <option value="Unassign">Unassign</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="status">
                            <option value="">All</option>
                            @foreach($statuses as $key=>$val)
                            <option value="{{$val}}"> {{$val}} </option>
                            @endforeach
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" id="priority">
                            <option value="">All</option>
                            @foreach($priorities as $key=>$val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <label class="focus-label">Priority</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div>
                            <input type="text" id="min" class="form-control floating shadow-sm" name="min">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div>
                            <input type="text" class="form-control floating shadow-sm" id="max" name="max">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>

            </div>
            <!-- /Search Filter -->

            <div class="row">
                <div class="col-md-12">
                   <div class="card shadow">
                       <div class="table-responsive col-12 my-3">
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
                               @foreach($all_tickets as $ticket)
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
                                                       @else
                                                       Unassign

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
                                           <a href="{{route('tickets.show',$ticket->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                           <button type="button" data-toggle="modal" data-target="#delete_ticket{{$ticket->id}}" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
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
        </div>
        <!-- /Page Content -->
        <!-- Delete Ticket Modal -->


        <script>
            $(document).ready(function () {
                $('#ticket_filter').hide();
            });
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
            $('#ticket_id').keyup(function () {
                var table = $('#ticket').DataTable();
                table.column(1).search($(this).val()).draw();
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
        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[4]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#ticket').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    </script>
        <!-- /Delete Ticket Modal -->
@endsection

