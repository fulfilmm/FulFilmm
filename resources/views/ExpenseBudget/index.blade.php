@extends('layout.mainlayout')
@section('title','Expense Budget')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Expense Budget</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Expense Budget</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_exp_budget"><i class="fa fa-plus"></i> Add New</a>
                </div>

            </div>
        </div>
    </div>
@endsection