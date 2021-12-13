@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Request For Quotation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request For Quotation</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3 offset-md-3">
                            To Send
                        </div>
                        <div class="col-md-3">Waiting</div>
                        <div class="col-md-3">Late</div>
                        <div class="col-md-3">
                          <div class="text-center my-3">
                              All RFQs
                          </div>
                        </div>
                        <div class="card bg-gradient-info col-md-3" style="height: 50px">
                            <div class="text-center text-white my-3">
                                <h4>1</h4>
                            </div>
                        </div>
                        <div class="card bg-gradient-purple col-md-3" style="height: 50px;">
                            <div class="text-center text-white my-3">
                                <h4>2</h4>
                            </div>
                        </div>
                        <div class="card bg-secondary col-md-3" style="height: 50px;">
                            <div class="text-center text-white my-3">
                                <h4>3</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                          <div class="text-center  my-3">
                              My RFQ
                          </div>
                        </div>
                        <div class="card col-md-3 bg-gradient-info" style="height: 50px;">
                            <div class="text-center text-white my-3">
                                <h4>2</h4>
                            </div>
                        </div>
                        <div class="card col-md-3 bg-gradient-purple" style="height: 50px;">
                            <div class="text-center text-white my-3">
                                <h4>3</h4>
                            </div>
                        </div>
                        <div class="card col-md-3 bg-secondary" style="height: 50px;">
                            <div class="text-center text-white my-3">
                                <h4>5</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row">
                <div class="col-12" style="overflow: auto">
                    <table class="table border">
                        <thead>
                        <tr>
                            <th>Purchase ID</th>
                            <th>Deadline</th>
                            <th>Receipt Date</th>
                            <th>Purchase Type</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Vendor</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rfqs as $rfq)
                            <tr>
                                <td>{{$rfq->purchase_id}}</td>
                                <td>{{\Carbon\Carbon::parse($rfq->deadline)->toFormattedDateString()}}</td>
                                <td>{{\Carbon\Carbon::parse($rfq->receipt_date)->toFormattedDateString()}}</td>
                                <td>{{$rfq->type}}</td>
                                <td>{{$rfq->status}}</td>
                                <td>{{$rfq->source->pr_id}}</td>
                                <td>{{$rfq->vendor->name}}</td>
                                <td>
                                    <a href="{{route('rfqs.show',$rfq->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="{{route('rfqs.edit',$rfq->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('rfqs.edit',$rfq->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection