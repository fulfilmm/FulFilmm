@extends('layout.mainlayout')
@section('title','Password Reset')
@section('content')
    <div class="container-fluid content">

        <form action="{{route('password.reset')}}" method="POST">
            @csrf
            <div class="col-md-6 offset-md-3 my-5">
                <div class="card shadow">
                    <div class="card-header">
                        Password Reset
                    </div>
                    <div class="card-body">
                        @if(session()->has('empty'))
                            <div class="alert alert-danger">
                                {{ session()->get('empty') }}
                            </div>
                        @endif
                            @if(session()->has('reset'))
                                <div class="alert alert-success">
                                    {{ session()->get('reset') }}
                                </div>
                            @endif
                        <div class="form-group">
                            <label for="email">Employee ID or Email</label>
                            <input type="text" class="form-control" name="emp" placeholder="Enter Employee Id or Email">
                            @error('emp')
                            <span class="text-danger">Please enter employee Id or email</span>
                            @enderror
                        </div>
                        <div class="fom-group">
                            <button type="button" data-toggle="modal" data-target="#confirm" class="btn btn-primary">Reset</button>
                            <div id="confirm" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title">Confirm Reset</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                           <span class="text-danger">Are you sure you want to reset your password?</span>
                                        </div>
                                        <div class="card-footer text-center">
                                            <button type="button" class="btn btn-danger">No</button>
                                            <button type="submit" class="btn btn-success">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection