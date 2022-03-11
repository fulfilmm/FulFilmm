@extends('layout.mainlayout')
@section('title','Delivery Transaction')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Delivery Transaction</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Delivery Transaction</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12" style="overflow: auto">
            <table class="table ">
                <thead>
                <tr>
                    <th>Delivery ID</th>
                    <th>Date</th>
                    <th>Courier</th>
                    <th>Delivery Fee Status</th>
                    <th>COD Cash Transaction Status</th>
                    <th>Amount</th>
                    <th>Delivery Fee</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $deli)
                    <tr>
                        <td>{{$deli->delivery_code}}</td>
                        <td>{{$deli->delivery->created_at->toFormattedDateString()}}</td>
                        <td>{{$deli->courier->name}}</td>
                        <td><span class="badge badge-{{$deli->paid_delivery_fee?'success':'danger'}}">{{$deli->paid_delivery_fee?'Paid':'Unpaid'}}</span></td>
                        <td><span class="badge badge-{{$deli->receiver_invoice_amount?'success':'danger'}}">{{$deli->receiver_invoice_amount?'Yes':'No'}}</span></td>
                        <td>{{number_format($deli->invoice_amount)}}</td>
                        <td>{{number_format($deli->delivery_fee)}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>
@endsection