@extends('layout.mainlayout')
@section('title','Revenue Budget')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Revenue Budget</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Revenue Budget</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('revenuebudget.create')}}" class="btn add-btn shadow-sm"><i class="fa fa-plus"></i> Add New</a>
                </div>

            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3">
                    <table class="table table-hover table-nowrap" id="budget">
                        <thead>
                            <tr>
                                <th>Created Date</th>
                                <th>Budget Name</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($reve_budget as $budget)
                            <tr>
                                <td>{{$budget->created_at->toFormattedDateString()}}</td>
                                <td>{{$budget->name}}</td>
                                <td>{{$budget->year}}</td>
                                <td><a href="{{route('revenuebudget.show',$budget->id)}}" class="btn btn-success btn-sm"><i class="la la-eye"></i></a></td>
                            </tr>
                              @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('#budget').DataTable();
        });
    </script>
    @endsection