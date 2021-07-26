@extends('layout.mainlayout')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

					<!-- Page Header -->
					<div class="page-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="page-title">Invoice</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index">Dashboard</a></li>
									<li class="breadcrumb-item active">Invoice</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<div class="btn-group btn-group-sm">
									<a href="{{route('invoice.sendmail',$detail_inv->id)}}" class="btn btn-white">Send</a>
									<button class="btn btn-white">CSV</button>
									<button class="btn btn-white">PDF</button>
									<button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-sm-6 m-b-20">
											<img src="img/logo2.png" class="inv-logo" alt="">
				 							<ul class="list-unstyled">
												<li>{{$company->name ?? null}}</li>
                                                <li>{{$company->address}},</li>
												<li>GST No:</li>
											</ul>
										</div>
										<div class="col-sm-6 m-b-20">
											<div class="invoice-details">
												<h3 class="text-uppercase">Invoice #{{$detail_inv->invoice_id}}</h3>
												<ul class="list-unstyled">
													<li>Date: <span>{{\Illuminate\Support\Carbon::parse($detail_inv->invoice_date)->toFormattedDateString()}}</span></li>
													<li>Due date: <span>{{\Illuminate\Support\Carbon::parse($detail_inv->due_date)->toFormattedDateString()}}</span></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
											<h5>Invoice to:</h5>
				 							<ul class="list-unstyled">
												<li><h5><strong>{{$detail_inv->customer->name}}</strong></h5></li>
												<li><span>{{$detail_inv->customer->company->name}}</span></li>
												<li>{{$detail_inv->customer->address}}</li>
												<li>Coosada, AL, 36020</li>
												<li>United States</li>
												<li>{{$detail_inv->customer->phone}}</li>
												<li><a href="#">{{$detail_inv->customer->email}}</a></li>
											</ul>
										</div>
{{--										<div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">--}}
{{--											<span class="text-muted">Payment Details:</span>--}}
{{--											<ul class="list-unstyled invoice-payment-details">--}}
{{--												<li><h5>Total Due: <span class="text-right">$8,750</span></h5></li>--}}
{{--												<li>Bank name: <span>Profit Bank Europe</span></li>--}}
{{--												<li>Country: <span>United Kingdom</span></li>--}}
{{--												<li>City: <span>London E1 8BF</span></li>--}}
{{--												<li>Address: <span>3 Goodman Street</span></li>--}}
{{--												<li>IBAN: <span>KFH37784028476740</span></li>--}}
{{--												<li>SWIFT code: <span>BPT4E</span></li>--}}
{{--											</ul>--}}
{{--										</div>--}}
									</div>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>ITEM</th>
													<th class="d-none d-sm-table-cell">DESCRIPTION</th>
													<th>UNIT COST</th>
                                                    <th>Tax(%)</th>
                                                    <th>Discount</th>
                                                    <th>Discount Type</th>
													<th>QUANTITY</th>
													<th class="text-right">TOTAL</th>
                                                    <th></th>
												</tr>
											</thead>
											<tbody>
                                            @foreach($invoic_item as $item)
												<tr>
{{--                                                    @dd($item->tax)--}}
													<td>{{$item->id}}</td>
													<td>{{$item->product->name}}</td>
													<td class="d-none d-sm-table-cell">{{$item->description}}</td>
													<td>{{$item->unit_price}}
                                                    <td>{{$item->tax_id}}%</td>
                                                    <td>{{$item->discount}}</td>
                                                    <td>{{$item->discount_type}}</td>
													<td>{{$item->quantity}}</td>
													<td class="text-right">{{$item->total}}</td>
													<td class="text-right">{{$item->currency_unit}}</td>
												</tr>
                                            @endforeach
											</tbody>
										</table>
									</div>
									<div>
										<div class="row invoice-payment">
											<div class="col-sm-7">
											</div>
											<div class="col-sm-5">
												<div class="m-b-20">
													<div class="table-responsive no-border">
														<table class="table mb-0">
															<tbody>
																<tr>
																	<th>Total:</th>
																	<td class="text-right text-primary"><h5>{{$grand_total}}</h5>{{$invoic_item[0]->currency_unit}}</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="invoice-info">
											<h5>Other information</h5>
											<p class="text-muted">{{$detail_inv->other_information}}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
    <!-- /Page Content -->
@endsection
