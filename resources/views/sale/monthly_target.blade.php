@extends('layout.mainlayout')
@section('title','Add Sales Target')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Monthly Target</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sales Target</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" data-toggle="modal" data-target="#add_target" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add Sales Target</a>
                </div>
            </div>
        </div>
        <div class="card">
            <form class="search-nav hidden-md-up my-3 mx-2">
                <div class="input-group" style="margin-bottom: 8px;">
                    <label class="col-form-label">Search In:</label>
                    <div class="text-right">
                        <select id="search-nav-select" class="form-control">
                            <option value='0' data-toggle="#Jan" {{date('M')=='Jan'?"selected":''}}>January</option>
                            <option value='1' data-toggle="#Feb" {{date('M')=='Feb'?"selected":''}}>February</option>
                            <option value='2' data-toggle="#Mar" {{date('M')=='Mar'?"selected":''}}>March</option>
                            <option value='3' data-toggle="#Apr" {{date('M')=='Apr'?"selected":''}}>April</option>
                            <option value='4' data-toggle="#May" {{date('M')=='May'?"selected":''}}>May</option>
                            <option value='5' data-toggle="#Jun" {{date('M')=='Jun'?"selected":''}}>June</option>
                            <option value='6' data-toggle="#Jul" {{date('M')=='Jul'?"selected":''}}>July</option>
                            <option value='7' data-toggle="#Aug" {{date('M')=='Aug'?"selected":''}}>August</option>
                            <option value='8' data-toggle="#Sep" {{date('M')=='Sep'?"selected":''}}>September</option>
                            <option value='9' data-toggle="#Oct" {{date('M')=='Oct'?"selected":''}}>October</option>
                            <option value='10' data-toggle="#Nov" {{date('M')=='Nov'?"selected":''}}>November</option>
                            <option value='11' data-toggle="#Dec" {{date('M')=='Dec'?"selected":''}}>December</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade" id="Jan" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="col-12" style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Jan')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade" id="Feb" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Feb')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Mar" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Mar')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Apr" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Apr')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="May" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='May')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Jun" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Jun')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Jul" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Jul')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Aug" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Aug')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Sep" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Sep')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Oct" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Oct')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Nov" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Nov')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="Dec" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="col-12"style="overflow: auto">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Month</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($mothly_targets as $target)
                                @if($target->month=='Dec')
                                    <tr>
                                        <td>{{$target->employee->name}}</td>
                                        <td>{{$target->month}}</td>
                                        <td>{{$target->target_sale}}</td>
                                        <td><a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div id="add_target" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Sale Target</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('saletargets.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate"  class="form-loading-button needs-validation">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Month</label>
                                            <select name="month" id="month" class="form-control" style="width: 100%">
                                                @foreach($month as $key=>$val)
                                                    <option value="{{$val}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                            @error('month')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <select name="year" id="year" class="form-control" style="width: 100%">
                                                @foreach($year as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="target_sale">Sale Target</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-money"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="target_sale" name="target_sale">
                                            </div>
                                            @error('target_sale')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="recurring">Employee</label>
                                        <div class="input-group">
                                            <select name="emp_id[]" id="emp_id" class="form-control" style="width: 90%" multiple>
                                                @foreach($employee as $key=>$val)
                                                    <option value="{{$key}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                            @error('emp_id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row save-buttons">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                                    class="btn-inner--text">Save</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        /* select tab on select change */

            $(document).ready(function() {
                $('select').select2();
                $("#{{date('M')}}").addClass('show');
                $("#{{date('M')}}").addClass('active');
            });
        $(document).ready(function () {
            $('#search-nav-select').on('change', function() {
                $('.tab-pane').removeClass('show');
                $('.tab-pane').removeClass('active');
                var tabID = $(this).find(":selected").data('toggle');
                $(tabID).addClass('show');
                $(tabID).addClass('active');

                // alert(tabID);
                // $('#nav-tabContent li a[href="' + tabID + '"]').tab('show');
            });
        })
    </script>
@endsection
