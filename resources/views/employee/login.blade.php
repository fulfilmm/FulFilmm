
<!doctype html>
<html lang="en">
@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
<head>

	<meta charset="utf-8" />
	<title> Login </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="yLUyjD9WW8ILTF5XMcNtgTQv0gKB8AsRb0U4czo8">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesbrand" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/logo2.png'))}}">

	<!-- preloader css -->
	<link rel="stylesheet" href="{{url(asset('css/logincss/preloader.css'))}}" type="text/css"/>
	<!-- Bootstrap Css -->
	<link href="{{url(asset('css/logincss/bootstap.min.css'))}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
	<!-- Icons Css -->
	<link href="{{url(asset('css/logincss/icon.min.css'))}}" rel="stylesheet" type="text/css"/>
	<!-- App Css-->
	<link href="{{url(asset('css/logincss/app.css'))}}" id="app-style" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="{{url("css/line-awesome.min.css")}}">
</head>


<body>
<div class="auth-page">
	<div class="container-fluid p-0">
		<div class="row g-0">
			<div class="col-xxl-3 col-lg-4 col-md-5">
				<div class="auth-full-page-content d-flex p-sm-5 p-4">
					<div class="w-100">
						<div class="d-flex flex-column h-100">
							<div class="mb-4 mb-md-5 text-center">
								{{--<a href="index" class="d-block auth-logo">--}}
									{{--<img src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/logo2.png'))}}" alt="" height="28">--}}
									{{--<span class="logo-txt">{{$maincompany->name??''}}</span>--}}
								{{--</a>--}}
							</div>
							<div class="auth-content my-auto">
								<div class="text-center">
									<h5 class="mb-0">Welcome Back !</h5>
									{{--<p class="text-muted mt-2">Sign in to continue to {{$maincompany->name}}.</p>--}}
								</div>
								<form  method="POST" action="{{route('customers.customerlogin')}}">
									@csrf
									<div class="mb-3">
										<label for="username" class="form-label">Email</label>
										<input name="email" type="email" class="form-control " value="{{old('email')}}" id="username" placeholder="Enter Email" autocomplete="email" autofocus>
										@error('email')
										<strong class="text-danger">{{ $message }}</strong>
										@enderror
									</div>
									<div class="mb-3">
										<div class="d-flex align-items-start">
											<div class="flex-grow-1">
												<label class="form-label">Password</label>
											</div>
											<div class="flex-shrink-0">
												<div class="">
													<a href="#" class="text-muted">Forgot password?</a>
												</div>
											</div>
										</div>
										<div class="input-group auth-pass-inputgroup ">
											<input type="password" name="password" class="form-control  " id="userpassword"  placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
											<span class="btn btn-light" type="button" id="password-addon"><i class="la la-eye"></i></span>
										</div>
										@error('password')
										<strong class="text-danger">{{ $message }}</strong>
										@enderror
									</div>
									<div class="row mb-4">
										<div class="col">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="remember" >
												<label class="form-check-label" for="remember">
													Remember me
												</label>
											</div>
										</div>

									</div>
									<div class="mb-3">
										<button class="btn btn-primary w-100 waves-effect waves-light" type="submit" formaction="">Login</button>
									</div>
								</form>

								<div class="mt-4 pt-2 text-center">

									<ul class="list-inline mb-0">
										<li class="list-inline-item">
											<a href="javascript:void()" class="social-list-item bg-info text-white border-info">
												<b style="font-size: 18px">f</b>
											</a>
										</li>
										<li class="list-inline-item">
											<a href="javascript:void()" class="social-list-item bg-info text-white border-info">
												<i class="la la-twitter"></i>
											</a>
										</li>
										<li class="list-inline-item">
											<a href="javascript:void()" class="social-list-item bg-danger text-white border-danger">
												<i class="la la-google"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
							{{--<div class="mt-4 mt-md-5 text-center">--}}
								{{--<p class="mb-0">© <script>--}}
                                        {{--document.write(new Date().getFullYear())--}}
									{{--</script> Minia . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>--}}
							{{--</div>--}}
						</div>
					</div>
				</div>
				<!-- end auth full page content -->
			</div>
			<!-- end col -->
			<div class="col-xxl-9 col-lg-8 col-md-7">
				<div class="auth-bg pt-md-5 p-4 d-flex">
					<div class="bg-overlay bg-primary"></div>
					<ul class="bg-bubbles">
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
					<!-- end bubble effect -->
					<div class="row justify-content-center align-items-center">
						<div class="col-xl-7">
							<div class="p-0 p-sm-4 px-xl-0">
								<div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
										<button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
										<button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
										<button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
									</div>
									<!-- end carouselIndicators -->
									<div class="carousel-inner">
										<div class="carousel-item active">
											<div class="testi-contain text-white">
												<img src="{{url(asset('product_picture/iphone12.png'))}}" class=" img-fluid " alt="..." width="100px" height="100px">
												<i class="bx bxs-quote-alt-left text-success display-6"></i>

												<h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
													imposing change
													on myself. It's a lot more progressing fun than looking back.
													That's why
													I ultricies enim
													at malesuada nibh diam on tortor neaded to throw curve balls.”
												</h4>
												<div class="mt-4 pt-3 pb-5">
													<div class="d-flex align-items-start">
														<div class="flex-shrink-0">
															<img src="{{url(asset('img/3612581_18010316150060733791.jpg'))}}" class="avatar-md img-fluid rounded-circle" alt="...">
														</div>
														<div class="flex-grow-1 ms-3 mb-4">
															<h5 class="font-size-18 text-white">Richard Drews
															</h5>
															<p class="mb-0 text-white-50">Web Designer</p>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="carousel-item">
											<div class="testi-contain text-white">
												<i class="bx bxs-quote-alt-left text-success display-6"></i>
												<img src="{{url(asset('product_picture/laptop.png'))}}" class=" img-fluid " alt="..." height="100px">
												<h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
													free ourselves by widening our circle of compassion to embrace
													all living
													creatures and
													the whole of quis consectetur nunc sit amet semper justo. nature
													and its beauty.”</h4>
												<div class="mt-4 pt-3 pb-5">
													<div class="d-flex align-items-start">
														<div class="flex-shrink-0">
															<img src="{{url(asset('img/3612581_18010316150060733791.jpg'))}}" class="avatar-md img-fluid rounded-circle" alt="...">
														</div>
														<div class="flex-grow-1 ms-3 mb-4">
															<h5 class="font-size-18 text-white">Rosanna French
															</h5>
															<p class="mb-0 text-white-50">Web Developer</p>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="carousel-item">
											<div class="testi-contain text-white">
												<i class="bx bxs-quote-alt-left text-success display-6"></i>
												<img src="{{url(asset('product_picture/watch.png'))}}" class=" img-fluid " alt="..." width="100px" height="100px">
												<h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
													people will forget what you said, people will forget what you
													did,
													but people will never forget
													how donec in efficitur lectus, nec lobortis metus you made them
													feel.”</h4>
												<div class="mt-4 pt-3 pb-5">
													<div class="d-flex align-items-start">
														<img src="{{url(asset('img/3612581_18010316150060733791.jpg'))}}" class="avatar-md img-fluid rounded-circle" alt="...">
														<div class="flex-1 ms-3 mb-4">
															<h5 class="font-size-18 text-white">Ilse R. Eaton</h5>
															<p class="mb-0 text-white-50">Manager
															</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- end carousel-inner -->
								</div>
								<!-- end review carousel -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end col -->
		</div>
		<!-- end row -->
	</div>
	<!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->
<script src="{{url(asset('js/jquery-3.2.1.min.js'))}}"></script>-
<script src="{{url(asset('js/loginjs/bootstrap.bundle.min.js'))}}"></script>
<script src="{{url(asset('js/loginjs/metismenu.js'))}}"></script>
<script src="{{url(asset('js/loginjs/simblebar.js'))}}"></script>
<script src="{{url(asset('js/loginjs/wave.js'))}}"></script>
<script src="{{url(asset('js/loginjs/feather.js'))}}"></script>
<!-- pace js -->
<script src="{{url(asset('js/loginjs/peace.js'))}}"></script>

<script>
    $("#password-addon").on('click', function () {
        if ($(this).siblings('input').length > 0) {
            $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
        }
    })
    $('#change-password').on('submit',function(event){
        event.preventDefault();
        var Id = $('#data_id').val();
        var current_password = $('#current-password').val();
        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        $('#current_passwordError').text('');
        $('#passwordError').text('');
        $('#password_confirmError').text('');
        $.ajax({
            url: "http://minia-light.laravel.themesbrand.com/update-password" + "/" + Id,
            type:"POST",
            data:{
                "current_password": current_password,
                "password": password,
                "password_confirmation": password_confirm,
                "_token": "yLUyjD9WW8ILTF5XMcNtgTQv0gKB8AsRb0U4czo8",
            },
            success:function(response){
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');
                if(response.isSuccess == false){
                    $('#current_passwordError').text(response.Message);
                }else if(response.isSuccess == true){
                    setTimeout(function () {
                        window.location.href = "http://minia-light.laravel.themesbrand.com";
                    }, 1000);
                }
            },
            error: function(response) {
                $('#current_passwordError').text(response.responseJSON.errors.current_password);
                $('#passwordError').text(response.responseJSON.errors.password);
                $('#password_confirmError').text(response.responseJSON.errors.password_confirmation);
            }
        });
    });
</script>


<!-- App js -->
<script src="{{url(asset('js/loginjs.app.js'))}}"></script>

</body>
</html>
















{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}

    {{--<head>--}}
        {{--<meta charset="utf-8">--}}
        {{--<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">--}}
        {{--<meta name="description" content="Smarthr - Bootstrap Admin Template">--}}
		{{--<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">--}}
        {{--<meta name="author" content="Dreamguys - Bootstrap Admin Template">--}}
        {{--<meta name="robots" content="noindex, nofollow">--}}
        {{--<title>{{$title ?? 'Login'}}</title>--}}

		{{--<!-- Favicon -->--}}
        {{--<link rel="shortcut icon" type="image/x-icon" href="">--}}

		{{--<!-- Bootstrap CSS -->--}}


		{{--<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->--}}
		{{--<!--[if lt IE 9]>--}}
			{{--<script src="assets/js/html5shiv.min.js"></script>--}}
			{{--<script src="assets/js/respond.min.js"></script>--}}
		{{--<![endif]-->--}}
    {{--</head>--}}

    {{--<body class="account-page">--}}
		{{--<title>Login</title>--}}
		{{--<!-- Main Wrapper -->--}}
        {{--<div class="main-wrapper">--}}
			{{--<div class="account-content">--}}
				{{-- <a href="job-list" class="btn btn-primary apply-btn">Apply Job</a> --}}
				{{--<div class="container">--}}

					{{--<!-- Account Logo -->--}}
					{{--<div class="account-logo">--}}
						{{--<a href="index"><img class="rounded-circle" src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/logo2.png'))}}" alt="Company Logo"></a>--}}
					{{--</div>--}}
					{{--<!-- /Account Logo -->--}}
                        {{-- {{dump($errors)}} --}}
					{{--<div class="account-box">--}}
						{{--<div class="account-wrapper">--}}
							{{--<h3 class="account-title">Login</h3>--}}
							{{--<p class="account-subtitle">Access to our dashboard</p>--}}
							{{--<ul class="nav nav-tabs text-center" id="myTab" role="tablist">--}}
								{{--<li class="nav-item" role="presentation">--}}
									{{--<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">--}}
										{{--<label>Login as Customer</label></a>--}}
								{{--</li>--}}
								{{--<li class="nav-item" >--}}
									{{--<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">--}}
										{{--<label for="">Login as Employee</label></a>--}}
								{{--</li>--}}
							{{--</ul>--}}
							{{--<div class="tab-content" id="myTabContent">--}}
								{{--<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">--}}
									{{--<form action="{{  route('customers.login') }}" method="POST">--}}
										{{--@csrf--}}
										{{--<div class="form-group">--}}
											{{--<label>{{__('E-Mail Address')}}</label>--}}
											{{--<input name="email" class="form-control" type="email" value="{{old('email')}}">--}}
											{{----}}
										{{--</div>--}}
										{{--<div class="form-group">--}}
											{{--<div class="row">--}}
												{{--<div class="col">--}}
													{{--<label>{{__('Password')}}</label>--}}
												{{--</div>--}}
												{{-- <div class="col-auto">--}}
                                                    {{--<a class="text-muted" href="forgot-password.html">--}}
                                                        {{--Forgot password?--}}
                                                    {{--</a>--}}
                                                {{--</div> --}}
											{{--</div>--}}
											{{--<input name="password" class="form-control" type="password">--}}
											{{----}}
										{{--</div>--}}
										{{--<div class="form-group text-center">--}}
											{{--<button class="btn btn-primary account-btn" type="submit">Login</button>--}}
										{{--</div>--}}
										{{-- <div class="account-footer">--}}
                                            {{--<p>Don't have an account yet? <a href="register">Register</a></p>--}}
                                        {{--</div> --}}
									{{--</form>--}}
								{{--</div>--}}
								{{--<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">--}}
									{{----}}
										{{--<div class="form-group">--}}
											{{--<label>{{__('E-Mail Address')}}</label>--}}
											{{--<input name="email" class="form-control" type="email" value="{{old('email')}}">--}}
											{{--@error('email')--}}
											{{-- <span class="invalid-feedback" role="alert"> --}}
											{{--<strong class="text-danger">{{ $message }}</strong>--}}
											{{-- </span> --}}
											{{--@enderror--}}
										{{--</div>--}}
										{{--<div class="form-group">--}}
											{{--<div class="row">--}}
												{{--<div class="col">--}}
													{{--<label>{{__('Password')}}</label>--}}
												{{--</div>--}}
												{{-- <div class="col-auto">--}}
                                                    {{--<a class="text-muted" href="forgot-password.html">--}}
                                                        {{--Forgot password?--}}
                                                    {{--</a>--}}
                                                {{--</div> --}}
											{{--</div>--}}
											{{--<input name="password" class="form-control" type="password">--}}
											{{--@error('password')--}}
											{{-- {{dd($message)}} --}}
											{{-- <span class="invalid-feedback" role="alert"> --}}
											{{--<strong>{{ $message }}</strong>--}}
											{{-- </span> --}}
											{{--@enderror--}}
										{{--</div>--}}
										{{--<div class="form-group text-center">--}}
											{{--<button class="btn btn-primary account-btn" type="submit">Login</button>--}}
										{{--</div>--}}
										{{-- <div class="account-footer">--}}
                                            {{--<p>Don't have an account yet? <a href="register">Register</a></p>--}}
                                        {{--</div> --}}
									{{--</form>--}}
								{{--</div>--}}

							{{--</div>--}}

							{{--<!-- Account Form -->--}}

							{{--<!-- /Account Form -->--}}

						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			{{--</div>--}}
        {{--</div>--}}
		{{--<!-- /Main Wrapper -->--}}

		{{--<!-- jQuery -->--}}
        {{---}}

		{{--<!-- Bootstrap Core JS -->--}}
        {{--<script src="{{url(asset('js/popper.min.js'))}}"></script>--}}
        {{--<script src="{{url(asset('js/bootstrap.min.js'))}}"></script>--}}

		{{--<!-- Custom JS -->--}}
		{{--<script src="{{url(asset('js/app.js'))}}"></script>--}}

    {{--</body>--}}
{{--</html>--}}
