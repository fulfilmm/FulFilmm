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
                    <a href="{{route('saletargets.create')}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add Sales Target</a>
                </div>
            </div>
        </div>
        <form action="{{url('sales/target/assigned')}}" method="get">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Employee</label>
                        <select name="emp_id" id="emp" class="form-control">
                            @if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'||$auth->role->name=='Sale Manager')
                                <option value="">All</option>
                                @foreach($employee as $key=>$val)
                                    <option value="{{$key}}" {{$key==$emp?'selected':''}}>{{$val}}</option>
                                @endforeach
                            @else
                                @foreach($employee as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Month</label>
                        <select name="month" id="month" class="form-control">
                            @foreach($month as $key=>$val)
                                <option value="{{$val}}" {{$val==$searchmonth?'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Year</label>
                        <select name="year" id="month" class="form-control">
                            @foreach($year as $key=>$val)
                                <option value="{{$val}}" {{$val==$searchyear?'selected':''}}>{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col mt-4">
                    <button type="submit" class="btn btn-primary col-12 mt-2"><i class="la la-search"></i> Search</button>
                </div>
            </div>
        </form>
        <div class="card shadow">
            <div class="col-12 my-2"style="overflow: auto">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Target Amount</th>
                        <th>Target Quantity</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    @foreach($mothly_targets as $target)
                            <tr>
                                <td>{{$target->employee->name}}</td>
                                <td>{{$target->month}}</td>
                                <td>{{$target->target_sale}}</td>
                                <td>{{$target->qty??''}}</td>
                                <td>
                                    <a href="{{route('saletargets.edit',$target->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('saletargets.show',$target->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('select').select2();
        })
    </script>
@endsection
