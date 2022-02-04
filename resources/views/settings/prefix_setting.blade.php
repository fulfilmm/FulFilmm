@extends('layout.mainlayout')
@section("title",'Prefix Setting')
@section('content')
	<div class="content container-fluid">
		<div class="row">
			<div class="col-md-8 offset-md-2 card shadow">
				<div class="col-12 my-3">
					<div class="card-header">
						<h4>Prefix Setting</h4>
					</div>

					<!-- Page Header -->

					<!-- /Page Header -->

					<form action="{{route('companysetting.setprefix')}}" class="mt-3" method="POST">
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
	</div>
	@endsection