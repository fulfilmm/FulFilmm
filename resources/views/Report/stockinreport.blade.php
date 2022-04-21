@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="card shadow">
            <div class="col-12 my-3">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right"><a href="{{url('reports')}}" class="btn btn-danger btn-sm rounded-circle"><i class="la la-close"></i></a></div>
                            <h3 class="page-title">Stock In Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>

                                <li class="breadcrumb-item active"><a href="{{url('reports')}}">Report</a></li>
                                <li class="breadcrumb-item active">Stock In Report</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection