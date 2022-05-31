@extends('layout.mainlayout')
@section('title','Sales Groups')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sales Groups</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sales Group</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{route('salegroup.create')}}" class="btn btn-primary rounded-pill">Add Sales Group</a>
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
                            <th>Group Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                    <a href="{{route('salegroup.show',$item->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                   <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#edit{{$item->id}}"><i class="la la-edit"></i></button>
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