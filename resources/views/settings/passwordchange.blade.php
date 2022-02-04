@extends('layout.mainlayout')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid content">
        <form action="{{route('emp_password.update',\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)}}" method="POST">
            @csrf
            <div class="col-md-8 offset-md-2 ">
                <div class="card shadow">
                    <div class="card-header">
                        Password Change
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Current Password</label>
                            <input type="text" class="form-control" name="current_pass" placeholder="Enter your current password">
                        </div>
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm" id="confirm_password" class="form-control">
                            <span id='message'></span>
                        </div>
                        <div class="fom-group">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Correct').css('color', 'green');
            } else
                $('#message').html('Password not Matching').css('color', 'red');
        });
    </script>
@endsection