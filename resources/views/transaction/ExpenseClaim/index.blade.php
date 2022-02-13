@extends('layout.mainlayout')
@section('title','Expense Claim')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Expense Claim</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Expense Claim</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('expenseclaims.create')}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>New Expense Claim</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="col-12">
                <div class="row filter-row my-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <input class="form-control form-control-md  shadow-sm" type="text" id="filter_id" name='id' placeholder="Type Invocie ID">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group ">
                            <input class="form-control form-control-md shadow-sm" type="text" name="min" id="min" placeholder="Enter Start Date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <input class="form-control shadow-sm form-control-md" type="text" id="max" name="max" placeholder="Enter End Date">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <select class="select form-control-md" id="filter_status">
                                <option value="" disabled>Select Status</option>
                                <option value="">All</option>
                                <option value="Approved">Approved</option>
                                <option value="Approved">Approved</option>
                                <option value="Approved">Approved</option>
                            </select>
                        </div>
                    </div>

                </div>
                <table class="table table-striped custom-table mb-0 datatable" id="exp_claim">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Employee</th>
                        <th>Amount</th>
                        <th>Approver</th>
                        <th>Status</th>
                        <th>Is Claim</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($expense_claim as $expense)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($expense->date)->toFormattedDateString()}}</td>
                        <td><a href="{{route('expenseclaims.show',$expense->id)}}">{{$expense->title??''}}</a></td>
                    <td>{{$expense->employee->name}}</td>
                    <td>{{$expense->total}}</td>
                    <td>{{$expense->approver->name}}</td>
                    <td>{{$expense->status}}</td>
                        <td>{{$expense->is_claim?'Yes':'No'}}</td>
                        <td>
                            {{--<a href="" class="btn btn-primary btn-s"><i class="fa fa-edit"></i></a>--}}
                            <a href="{{route('expenseclaims.show',$expense->id)}}" class="btn btn-white btn-s"><i class="fa fa-eye"></i></a>
                            {{--<a href="" class="btn btn-danger btn-s"><i class="fa fa-trash"></i></a>--}}
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[3]);
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#invoice').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
        $(document).ready(function() {
            $('#filter_id').keyup(function () {
                var table = $('#invoice').DataTable();
                table.column(1).search($(this).val()).draw();

            });
        });
        $(document).ready(function() {
            $('#filter_status').on('change', function () {
                var table = $('#invoice').DataTable();
                table.column(6).search($(this).val()).draw();

            });
        });
    </script>
@endsection
