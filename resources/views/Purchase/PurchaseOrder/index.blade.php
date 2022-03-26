@extends('layout.mainlayout')
@section('title','Purchase Order')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Order</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase Order</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route("purchaseorders.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Purchase Order</a>
                </div>
            </div>
        </div>
      <div class="card shadow">
          <div class="col-12 my-3" style="overflow:auto;">
              <table class="table table-hover table-nowrap" id="po_table">
                  <thead>
                  <tr>
                      <th>Order ID</th>
                      <th>Order Date</th>
                      <th>Deadline</th>
                      <th>Ordered Employee</th>
                      <th>Type</th>
                      <th>Supplier</th>
                      <th>Approver</th>
                      <th>Discount</th>
                      <th>Total Amount</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($purchase_orders as $po)
                      <tr>
                          <td>{{$po->po_id}}</td>
                          <td>{{\Carbon\Carbon::parse($po->ordered_date)->toFormattedDateString()}}</td>
                          <td>{{\Carbon\Carbon::parse($po->deadline)->toFormattedDateString()}}</td>
                          <td>{{$po->employee->name}}</td>
                          <td>{{$po->purchase_type}}</td>
                          <td>{{$po->vendor->name}}</td>
                          <td>{{$po->approver_name->name}}</td>
                          <td>{{$po->discount}}</td>
                          <td>{{$po->grand_total}}</td>
                          <td>
                              <a href="{{route('purchaseorders.edit',$po->id)}}" class="btn btn-white btn-sm"><i class="fa fa-edit"></i></a>
                              <a href="{{route('purchaseorders.show',$po->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
    <script>
        $(document).ready(function () {
           $('#po_table').DataTable();
        });
    </script>
@endsection