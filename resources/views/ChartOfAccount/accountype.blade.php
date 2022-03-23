@extends('layout.mainlayout')
@section('title','Account Type')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account Type</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account Type</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_new_revenue_budget"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div id="add_new_revenue_budget" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 my-3">
                                    <form action="{{route('coatype.store')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-5">
                    <h4>List Of Account Type</h4>
                    <ul style="list-style-type:circle">
                        @foreach($type as $item)
                           <li><b>{{$item->name}}</b></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection