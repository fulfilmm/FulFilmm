@extends('layout.mainlayout')
@section('title','Sale Performance')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Permission </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Add Permission</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route('permission.store')}}" method="post">
            @csrf
            <div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Route Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Display Name</label>
                            <input type="text" class="form-control" name="display_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Type</label>
                            <input type="text" class="form-control" name="type">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Guard Name</label>
                            <input type="text" class="form-control" name="guard_name" value="employee">
                        </div>
                    </div>
                   <div class="col-12">
                       <div class="form-group text-center">
                           <button type="submit" class="btn btn-primary col-md-4">Add</button>
                       </div>
                   </div>

                </div>
            </div>
        </form>
    </div>
@endsection