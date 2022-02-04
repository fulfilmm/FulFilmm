@extends('layout.mainlayout')
@section('title','Company Setting')
@section('content')
	<style>
		input[type="file"] {
			display: block;
		}
		.imageThumb {
			max-height: 90px;
			max-width: 150px;
			border: 2px solid;
			padding: 1px;
			cursor: pointer;
		}
		.pip {
			display: inline-block;
			margin: 10px 10px 10px 0;
		}
		.remove {
			display: block;
			background: #edeff2;
			border: 1px solid black;
			color: black;
			text-align: center;
			cursor: pointer;
		}
		.remove:hover {
			background: white;
			color: black;
		}

	</style>
<!-- Page Content -->
<div class="content container-fluid">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="page-title">Company Settings</h3>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 offset-md-2 card shadow">

			<!-- /Page Header -->

			<form action="{{route('companysettings.store')}}" method="POST" class="my-5" enctype="multipart/form-data">
				@csrf
				<div class="text-center">
					<h4 for="">Logo <span class="text-danger">*</span></h4>
					<div class="form-group col-md-2 offset-md-5">
						<img id="output" class="rounded mt-3" src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" width="100px" height="100px;">
					</div>
					<div class="form-group col-md-3 col-6 offset-md-5">
						<input type="file" accept="image/*" name="logo"  class=" offset-md-1" onchange="loadFile(event)" {{$company!=null?'':'required'}}>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Company Name <span class="text-danger">*</span></label>
							<input class="form-control shadow-sm" type="text" name="name" value="{{$company->name??''}}" required>
						</div>
						@error('name')
						<span class="text-danger">{{$message}}</span>
						@enderror
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Contact Person</label>
							<input class="form-control shadow-sm" name="contact_person" value="{{$company->contact_person??''}}" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Address</label>
							<input class="form-control " value="{{$company->address ?? ''}}" name="address" type="text">
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-3">
						<div class="form-group">
							<label>Country</label>
							<input type="text" class="form-control shadow-sm" name="country" value="{{$company->country??''}}" >
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-3">
						<div class="form-group">
							<label>City</label>
							<input class="form-control shadow-sm" name="city" value="{{$company->city??''}}" type="text">
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-3">
						<div class="form-group">
							<label>State/Province</label>
							<input type="text" class="form-control shadow-sm" name="state" value="{{$company->state??''}}">
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-3">
						<div class="form-group">
							<label>Postal Code</label>
							<input class="form-control" name="post_code" value="{{$company->post_code??''}}" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Email</label>
							<input class="form-control shadow-sm" name="email" value="{{$company->email??''}}" type="email">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Phone Number</label>
							<input class="form-control shadow-sm" name="phone" value="{{$company->phone??''}}" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Mobile Number</label>
							<input class="form-control shadow-sm" name="mobile" value="{{$company->mobile_phone??''}}" type="text">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Fax</label>
							<input class="form-control shadow-sm" name="fax" value="{{$company->fax??''}}" type="text">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Website Url</label>
							<input class="form-control shadow-sm" name="web_link" value="{{$company->web_link??''}}" type="text">
						</div>
					</div>
				</div>
				<div class="submit-section">
					<button type="submit" class="btn btn-primary submit-btn">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
	<script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        </script>
<!-- /Page Content -->
@endsection