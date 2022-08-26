@extends('layout.mainlayout')
@section('title','Request For Quotation')
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
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">To Send</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$tosend}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width:100%;"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">Waiting</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$waiting}}</h3>

                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="d-block">PO Confirmed</span>
                                    </div>

                                </div>
                                <h3 class="mb-3">{{$confirm}}</h3>

                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between ">
                                    <div>
                                        <span class="d-block">OverDue</span>
                                    </div>
                                </div>
                                <h3 class="mb-3">{{$overdue}}</h3>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="overflow: auto">
                <div class="card shadow">
                    <div class="col-12 my-3">
                        <table class="table table-hover table-hover" id="rfq">
                            <thead>
                            <tr>
                                <th>RFQs ID</th>
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
                                    <td>{{$rfq->source->pr_id??'None'}}</td>
                                    <td>{{$rfq->vendor->name??'N/A'}}</td>
                                    <td>
                                        <div class="row">
                                            <a href="{{route('rfqs.duplicate',$rfq->id)}}"
                                               class="btn btn-white btn-sm mr-1"><i class="fa fa-copy"></i></a>
                                            <a href="{{route('rfqs.show',$rfq->id)}}"
                                               class="btn btn-white btn-sm mr-1"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('rfqs.edit',$rfq->id)}}"
                                               class="btn btn-success btn-sm mr-1"><i class="fa fa-edit"></i></a>
                                            <form action="{{route('rfqs.destroy',$rfq->id)}}" method="post">
                                                @csrf @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm mr-1"><i
                                                            class="fa fa-trash"></i></button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#rfq').DataTable();
        })
    </script>
@endsection