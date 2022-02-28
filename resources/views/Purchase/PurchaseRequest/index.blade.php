@extends('layout.mainlayout')
@section('title','Purchase Request')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Purchase Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Purchase Request</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route("purchase_request.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill shadow-sm" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add PR</a>
                </div>
            </div>
        </div>
        <div class="col-12">
          <div class="card shadow">
             <div class="col-12 my-5">
                 <table class="table table-hover table-nowrap" id="pr_table">
                     <thead>
                     <tr>
                         <th>PR ID</th>
                         <th>Deadline</th>
                         <th>Type</th>
                         <th>Supplier</th>
                         <th>Requester</th>
                         <th>Approver</th>
                         <th>Status</th>
                         <th>Action</th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach($purchase_request as $pr)
                         <tr>
                             <td>{{$pr->pr_id}}</td>
                             <td>{{\Carbon\Carbon::parse($pr->deadline)->toFormattedDateString()}}</td>
                             <td>{{$pr->type}}</td>
                             <td>{{$pr->vendor->name??'N/A'}}</td>
                             <td>{{$pr->employee->name}}</td>
                             <td>{{$pr->approver->name}}</td>
                             <td>
                                 <div class="dropdown action-label" id="status_div">
                                     <a class="btn btn-white btn-sm btn-rounded " href="#"
                                        data-toggle="dropdown" aria-expanded="false" id="status"><i
                                                 class="fa fa-dot-circle-o mr-1"
                                                 style="color:{{$pr->status=='New'?'#909396':($pr->status=='Approved'?'#81E886':($pr->status=='Pending'?'#36D8FF':'Red'))}}"></i>{{$pr->status}}
                                     </a>
                                 </div>
                             </td>
                             <td>
                                 <a href="{{route('purchase_request.edit',$pr->id)}}" class="btn btn-white btn-sm"><i class="fa fa-edit"></i></a>
                                 <a href="{{route('purchase_request.show',$pr->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                             </td>
                         </tr>
                     @endforeach
                     </tbody>
                 </table>
             </div>
          </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('#pr_table').DataTable();
        });
    </script>
@endsection