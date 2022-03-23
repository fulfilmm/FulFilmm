@extends('layout.mainlayout')
@section('title','Chart Of Account')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Chart Of Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chart Of Account</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_new_coa"><i class="fa fa-plus"></i> Add New</a>
                </div>
                @include('ChartOfAccount.create')
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3">
                    <table class="table table-hover table-nowrap">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Account Type</th>
                                <th>Financial Statement</th>
                                <th>Group</th>
                                <th>Sub Group</th>
                                <th>Normally</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coas as $coa)
                                <tr>
                                    <td>{{$coa->code}}</td>
                                    <td>{{$coa->name}}</td>
                                    <td>{{$coa->account_type->name}}</td>
                                    <td>{{$coa->financial_statement??'N/A'}}</td>
                                    <td>{{$coa->group??'N/A'}}</td>
                                    <td>{{$coa->sub_group??'N/A'}}</td>
                                    <td>{{$coa->normally??'N/A'}}</td>
                                    <td><div class="row">
                                            <a href="#" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#edit_coa{{$coa->id}}"><i class="fa fa-edit"></i></a>
                                            <form action="{{route('chartofaccount.destroy',$coa->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                            </form>
                                        </div>
                                        @include('ChartOfAccount.edit')
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
    @endsection