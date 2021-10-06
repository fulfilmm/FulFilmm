@extends('layout.mainlayout')

@section('name', 'Lead')

@section('content')

    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Lead</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('customers.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Lead</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="float-right">
                    <input type="text" wire:model="search_key">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-nowrap datatable mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->company->name }}</td>
                                <td>{{$customer->customer_type}}</td>
                                <td style="display: flex">
                                    <a class="btn btn-success" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                    <a class="btn btn-success" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                    <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></button>
                                    </form>
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


