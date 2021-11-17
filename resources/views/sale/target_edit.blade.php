@extends('layout.mainlayout')
@section('title','Add Sale Target')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Monthly Target Edit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sale Target</li>
                        <li class="breadcrumb-item float-right">Edit</li>
                    </ul>
                </div>

            </div>
        </div>
<form method="POST" action="{{route('saletargets.update',$target->id)}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate"  class="form-loading-button needs-validation">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date">Month</label>
                    <select name="month" id="month" class="form-control" style="width: 100%">
                        @foreach($month as $key=>$val)
                            <option value="{{$val}}" {{$val==$target->month?'selected':''}}>{{$val}}</option>
                        @endforeach
                    </select>
                    @error('month')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="target_sale">Sale Target</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                        </div>
                        <input type="text" class="form-control" id="target_sale" name="target_sale" value="{{$target->target_sale}}">
                    </div>
                    @error('target_sale')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <label for="recurring">Employee</label>
                <div class="input-group">
                    <select name="emp_id" id="emp_id" class="form-control" style="width: 100%" >
                        @foreach($employee as $key=>$val)
                            <option value="{{$key}}" {{$key==$target->emp_id?'selected':''}}>{{$val}}</option>
                        @endforeach
                    </select>
                    @error('emp_id')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="year" value="{{date('Y')}}">
        </div>
    </div>
    <div class="card-footer">
        <div class="row save-buttons">
            <div class="col-md-12">
                <button type="submit" class="btn btn-icon btn-success"><!----> <span
                            class="btn-inner--text">Update</span></button>
            </div>
        </div>
    </div>
</form>
        @endsection
