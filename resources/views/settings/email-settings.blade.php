@extends('layout.mainlayout')
@section('title','Email Setting')
@section('content')
	<!-- Page Content -->
	<div class="content container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2 card shadow">
				<div class="card-header">
					<h4>Email Setting</h4>
				</div>
				<form action="{{route('mail.setting')}}" method="POST" class="my-5 mx-3">
					@csrf
					<div class="form-group">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="mail_server" id="phpmail" value="phpmail" @if($mail!=null){{$mail->mail_server=='phpmail'?'checked':''}}@endif>
							<label class="form-check-label" for="phpmail">PHP Mail</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="mail_server" id="smtpmail" value="smtp" @if($mail!=null){{$mail->mail_server=='smtp'?'checked':''}}@endif>
							<label class="form-check-label" for="smtpmail">SMTP</label>
						</div>
					</div>
					<h4 class="page-title">PHP Email Settings</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Email From Address</label>
								<input class="form-control" type="email" name="from_address" value="{{$mail->from_address??''}}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Emails From Name</label>
								<input class="form-control" type="text" name="from_name" value="{{$mail->from_name??''}}">
							</div>
						</div>
					</div>
					<h4 class="page-title m-t-30">SMTP Email Settings</h4>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP HOST</label>
								<input class="form-control" type="text" name="host" value="{{$mail->host??''}}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP USER</label>
								<input class="form-control" type="text" name="user" value="{{$mail->user??''}}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP PASSWORD</label>
								<input class="form-control" type="password" name="password" value="{{$mail->password??''}}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP PORT</label>
								<input class="form-control" type="text" name="port" value="{{$mail->port??''}}">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP Security</label>
								<select class="select" name="security">
									@if($mail==null)
										<option >None</option>
										<option  >SSL</option>
										<option >TLS</option>
										@else
										<option {{$mail->security=='None'?'selected':''}}>None</option>
										<option {{$mail->security=='SSL'?'selected':''}} >SSL</option>
										<option {{$mail->security=='TLS'?'selected':''}}>TLS</option>
									@endif
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>SMTP Authentication Domain</label>
								<input class="form-control" type="text" name="auth_domain" value="{{$mail->auth_domain??''}}">
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Save &amp; update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /Page Content -->
	@endsection