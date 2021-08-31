@extends('layout.mainlayout')
@section('title','Leads')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <style>
        #lead_filter{
            visibility: hidden;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ul>
                </div>

                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn btn-outline-secondary mr-3" data-toggle="modal" data-target="#import">
                        <i class="fa fa-upload mr-2"></i>Import
                    </button>
                    <!-- Button import modal -->
                    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Import Lead</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{url("/lead/import")}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="file" name="file" >
                                        <br>
                                        <button class="btn btn-outline-success float-right"><i class="fa fa-upload mr-2"></i>Import Ticket</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- import ticket -->
                    <a href="{{route("leads.create")}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Lead</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <input type="text" class="form-control floating" id="lead_id" placeholder="All" value="#">
                    <label class="focus-label">Lead ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <label class="focus-label">Sale Man</label>
                    <select name="emp_name" class="form-control floating" id="sale_man">
                        <option value="">All</option>
                        @foreach($allemployees as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="customer_name">
                        <option value="">All</option>
                        @foreach($allcustomers as $key=>$val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach

                    </select>
                    <label class="focus-label">Customer</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" id="priority">
                        <option value="">All</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    <label class="focus-label">Priority</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div>
                        <input type="text" id="min" class="form-control floating " name="min">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div>
                        <input type="text" class="form-control floating " id="max" name="max">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>

        </div>
        <!-- /Search Filter -->
        @include('lead.lead_table')
    </div>
    <!-- /Page Content -->

    <script>
        $("#lead_search").click(function(){
            $(".col-xs-6 , .btn").toggleClass('animated slideOutDown');
            $(".btn i").toggleClass('fa-chevron-up');
            $(".btn i").toggleClass('fa-chevron-down');

        });
        $(document).ready(function() {
            $('#lead').DataTable( {
                dom: 'Bfrtip',
                buttons: [

                    {
                        extend: 'collection',
                        text: '<i class="fa fa-download mr-2"></i>Export',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    }
                ],

            } );

        } );
        $('#lead_id').on('change', function() {
            var table = $('#lead').DataTable();
            table.column(1).search($(this).val()).draw();
        });
        $('#customer_name').on('change', function() {
            var table = $('#lead').DataTable();
            table.column(2).search($(this).val()).draw();
        });
        $('#sale_man').on('change', function() {
            var table = $('#lead').DataTable();
            table.column(6).search($(this).val()).draw();
        });
        $('#priority').on('change', function() {
            var table = $('#lead').DataTable();
            table.column(7).search($(this).val()).draw();
        });

        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[10]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#lead').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });



    </script>
    <!-- /Page Wrapper -->
@endsection
