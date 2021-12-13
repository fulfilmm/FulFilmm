@extends('layout.mainlayout')
@section('title','Receipt Process List')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Receipt Process</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Receipt Process</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12" style="overflow: auto">
                    <table class="table border">
                        <thead>
                        <tr>
                            <th>Purchase ID</th>
                            <th>Deadline</th>
                            <th>Schedule Date</th>
                            <th>Vendor</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($process as $process)
                            <tr>
                                <td><a href="{{url('/receipt/show/'.$process->id)}}">{{$process->received_id}}</a></td>
                                <td>{{\Carbon\Carbon::parse($process->deadline)->toFormattedDateString()}}</td>
                                <td>{{\Carbon\Carbon::parse($process->schedule_date)->toFormattedDateString()}}</td>
                                <td><a href="{{route('customers.show',$process->id)}}">{{$process->vendor->name}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection