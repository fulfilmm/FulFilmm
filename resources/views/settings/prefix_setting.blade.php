@extends('layout.mainlayout')
@section("title",'Prefix Setting')
@section('content')
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Invoice Settings</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 offset-md-2">

				<!-- Page Header -->

				<!-- /Page Header -->

				<form action="{{route('companysetting.setprefix')}}" method="POST">
					@csrf
					<div class="form-group row">
						<label class="col-lg-3 col-form-label">Invoice prefix</label>
						<div class="col-lg-9">
							<input type="text" name="invoice_prefix" value="{{$company->invoice_prefix ??''}}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label">Ticket prefix</label>
						<div class="col-lg-9">
							<input type="text" name="ticket_prefix" value="{{$company->ticket_prefix??''}}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label">Quotation prefix</label>
						<div class="col-lg-9">
							<input type="text" name="quotation_prefix" value="{{$company->quotation_prefix??''}}" class="form-control">
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endsection