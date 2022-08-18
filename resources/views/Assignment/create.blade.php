@extends('layout.mainlayout')
@section('name', 'Add Todo List')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Todo List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add Todo List</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection