@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Receive</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Receive</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row my-3">
               <div class="col-12">
                   <button class="btn btn-primary">Save</button>
                   <button class="btn btn-primary">Create</button>
               </div>
            </div>
            <div class="card" >
                <div class="card-header">
                    <a href="{{route('rfq.preparemail',$receipt->id)}}"  class="btn btn-primary btn-sm">Validate</a>
                    <a href="{{route('rfq.preparemail',$receipt->id)}}"  class="btn btn-primary btn-sm">Print</a>
                </div>
                <div class="card-body border" id="pdfarea" >
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{$receipt->received_id}}</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <span class="text-muted">Received From</span>
                                </div>
                                <div class="col-md-6">
                                    {{$receipt->vendor->name}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="row mt-3">
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4 offset-md-2">
                                        <span class="text-muted">Schedule Date</span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="schedule_date" value="{{\Carbon\Carbon::parse($receipt->schedule_date)->format('Y-m-d')}}">
                                    </div>
                                </div>
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 offset-md-2">
                                    <span class="text-muted">Deadline</span>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="deadline" value="{{\Carbon\Carbon::parse($receipt->deadline)->format('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-4 offset-md-2">
                                    <span class="text-muted">Source</span>
                                </div>
                                <div class="col-md-6">
                                    <span><input type="text" class="form-control" value="{{$receipt->rfq->purchase_id}}"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Demand</th>
                                    <th>Done</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($receipt_item as $item)
                                    <td>{{$item->product->name}}</td>
                                    <td><input type="number" name="demand" class="form-control" value="{{$item->demand}}"></td>

                                    <td><input type="text" name="done" class="form-control" value="{{$item->qty}}"></td>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection