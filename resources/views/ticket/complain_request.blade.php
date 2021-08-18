@extends('layout.mainlayout')
@section('title','Complains Request')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Request To Open Ticket</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request Ticket</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="ticket">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Product</th>
                            <th>Company</th>
                            <th>Is Open Ticket</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_request as $request)
                           <tr>
                               <th>#{{$request->id}}</th>
                               <td>{{$request->name}}</td>
                               <td>{{$request->email}}</td>
                               <td>{{$request->phone}}</td>
                               <td>{{$request->address??''}}</td>
                               <td><img src="{{url(asset("/product_picture/".$request->compalin_product->image))}}" class="mr-2"  alt="product picture" width="40px" height="40px;">{{$request->compalin_product->name}}</td>
                               <td>{{$request->complain_company->name ??''}}</td>

                               <td>{{$request->is_open==0?'No':'Yes'}}</td>
                               <td>
                                   <div class="dropdown dropdown-action">
                                       <a href="{{route('request_tickets.show',$request->id)}}" class="btn btn-primary btn-sm"><i class="la la-eye"></i></a>
                                       <button class="btn btn-danger btn-sm"><i class="la la-trash-o"></i></button>
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
    @endsection