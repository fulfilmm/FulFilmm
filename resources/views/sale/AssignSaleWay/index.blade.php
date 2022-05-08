@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sales Ways</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sales Ways</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{route('assignsaleway.create')}}" class="btn btn-primary rounded-pill">Assign Sales Way</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3" style="overflow: auto">
                    <table class="table table-hover table-nowrap">
                        <thead>
                        <tr>
                            <th>Way Id</th>
                            <th>Way Name</th>
                            <th>Assign Type</th>
                            <th>Assign Group/Employee</th>
                            <th>Start Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assgin_way as $item)
                            <tr>
                                <td>{{$item->way->way_id}}</td>
                                <td>{{$item->way->name}}</td>
                                <td>
                                    {{$item->type?'Group':'Individual'}}
                                </td>
                                <td>
                                    {{$item->type?$item->group->name:$item->emp->name}}
                                </td>
                                <td>{{\Carbon\Carbon::parse($item->start_date)->toFormattedDateString()}}</td>
                                <td>
                                    <a href="{{route('assignsaleway.show',$item->id)}}" class="btn btn-success btn-sm"><i class="la la-eye"></i></a>
                                    {{--<a href="{{route('saleway.edit',$item->id)}}" class="btn btn-warning btn-sm"><i class="la la-edit"></i></a>--}}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection