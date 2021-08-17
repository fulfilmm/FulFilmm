<!DOCTYPE html>
<html lang="en">
@php $maincompany=\App\Models\MainCompany::where('ismaincompany',true)->first(); @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>{{$title ?? 'Login'}}</title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/logo2.png'))}}">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{url(asset('/css/font-awesome.min.css'))}}">

		<!-- Main CSS -->
        <link rel="stylesheet" href="{{url(asset('/css/style.css'))}}">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>

    <body class="account-page">
		<title>Login</title>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				{{-- <a href="job-list" class="btn btn-primary apply-btn">Apply Job</a> --}}
				<div class="container">

					<!-- Account Logo -->
					<div class="account-logo">
						<a href="index"><img class="rounded-circle" src="{{$maincompany!=null ? url(asset('/img/profiles/'.$maincompany->logo)): url(asset('/img/logo2.png'))}}" alt="Company Logo"></a>
					</div>
					<!-- /Account Logo -->
                        {{-- {{dump($errors)}} --}}
					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">Login</h3>
							<p class="account-subtitle">Access to our dashboard</p>

							<!-- Account Form -->
                            <form action="{{  route('employees.emplogin') }}" method="POST">
                                @csrf
								<div class="form-group">
									<label>{{__('E-Mail Address')}}</label>
                                     <input name="email" class="form-control" type="email" value="{{old('email')}}">
									@error('email')
                                    {{-- <span class="invalid-feedback" role="alert"> --}}
                                        <strong class="text-danger">{{ $message }}</strong>
                                    {{-- </span> --}}
                                    @enderror
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col">
											<label>{{__('Password')}}</label>
										</div>
										{{-- <div class="col-auto">
											<a class="text-muted" href="forgot-password.html">
												Forgot password?
											</a>
										</div> --}}
									</div>
                                    <input name="password" class="form-control" type="password">
                                    @error('password')
                                    {{-- {{dd($message)}} --}}
                                    {{-- <span class="invalid-feedback" role="alert"> --}}
                                        <strong>{{ $message }}</strong>
                                    {{-- </span> --}}
                                    @enderror
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="submit">Login</button>
								</div>
								{{-- <div class="account-footer">
									<p>Don't have an account yet? <a href="register">Register</a></p>
								</div> --}}
							</form>
							<!-- /Account Form -->

						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
        <script src="{{url(asset('js/jquery-3.2.1.min.js'))}}"></script>

		<!-- Bootstrap Core JS -->
        <script src="{{url(asset('js/popper.min.js'))}}"></script>
        <script src="{{url(asset('js/bootstrap.min.js'))}}"></script>

		<!-- Custom JS -->
		<script src="{{url(asset('js/app.js'))}}"></script>

    </body>
</html>
