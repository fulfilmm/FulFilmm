@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="container">
    <form action="{{route('password.update',\Illuminate\Support\Facades\Auth::guard('customer')->user()->id)}}">
        @csrf
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Password Change
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="">Current Password</label>
                            <input type="text" class="form-control" name="current_pass">
                        </div>
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm" class="form-control">
                        </div>
                        <div class="fom-group">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection