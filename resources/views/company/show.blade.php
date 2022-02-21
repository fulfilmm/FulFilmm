@extends('layout.mainlayout')
@section('title', $record->name)
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        {{--@dd($record->logo)--}}
        <div class="card shadow mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="">
                                        <img src="{{$record->logo}}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0">{{$record->name}}</h3>
                                            <ul class="personal-info">
                                                <li title="Email">
                                                    <span class="text-muted"> <i class="la la-envelope"></i> {{$record->email}}</span><br>
                                                </li>
                                                <li title="Phone">
                                                    <span class="text-muted"> <i class="la la-phone"></i> {{$record->phone}}</span><br>
                                                </li>
                                                <li title="Address">
                                                    <span class="text-muted"> <i class="la la-map"></i> {{$record->address}}</span><br>
                                                </li>
                                                <li title="Business Type">
                                                    <span class="text-muted"> <i class="la la-building"></i> {{$record->business_type}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Web Link:</span>
                                                <span class="text">{{$record->web_link ?? '-'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Linkedin:</span>
                                                <span class="text">{{$record->linkedin ?? '-'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Facebook:</span>
                                                <span class="text">{{$record->facebook_page ?? '-'}}</span>
                                            </li>
                                            <li>
                                                <span class="title">Registery:</span>
                                                <span class="text">{{$record->company_registry ?? '-'}}</span>

                                            </li>

                                            <li class="mb-4">
                                                <span class="title">Parent Company :</span>
                                                <span class="text">{{$record->parent_company ?$record->parentCompany->name: '-'}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pro-edit"><a class="edit-icon"
                                                         href="{{route('companies.edit',$record->id)}}"><i
                                                class="fa fa-pencil"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="col-12 my-5">
                <h4>{{$record->name}}'s Employee</h4>
                <table class="table table-nowrap table-hover">
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
                            <td><a href="{{route('customers.show',$customer->id)}}"><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</a></td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->company->name }}</td>
                            <td>{{$customer->customer_type}}</td>
                            <td style="display: flex">
                                <a class="btn btn-success" data-toggle="tooltip" title="View Detail" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                <a class="btn btn-success" data-toggle="tooltip" title="Edit" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger" data-toggle="tooltip" title="Delete" type="submit" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

@endsection
