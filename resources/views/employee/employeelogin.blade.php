<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{url(asset("css/bootstrap.min.css"))}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{url(asset("/css/font-awesome.min.css"))}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{url(asset('css/logincss/animate.css'))}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{url(asset('css/logincss/hamburgers.min.css'))}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{asset("css/select2.min.css")}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{url(asset('css/logincss/util.css'))}}">
    <link rel="stylesheet" type="text/css" href="{{url(asset('css/logincss/main.css'))}}">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            @php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)):url(asset('img/icon_image/img-01.png'))}}" width="300px" height="300px" alt="IMG">
            </div>

            <form class="login100-form validate-form" method="POST" action="{{route('employees.emplogin')}}">
                @csrf
					<span class="login100-form-title">
						Employee Login
					</span>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="email" placeholder="Email" value="{{old('email')}}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>

                </div>
                @error('email')
                <small class="text-danger mb-3">{{ $message }}</small>
                @enderror
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    @error('password')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
                    <a class="txt2" href="#">
                        Username / Password?
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>
<!--===============================================================================================-->
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('js/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{url(asset('js/loginjs/tilt.jquery.min.js'))}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{url(asset('js/loginjs/main.js'))}}"></script>


</body>
</html>