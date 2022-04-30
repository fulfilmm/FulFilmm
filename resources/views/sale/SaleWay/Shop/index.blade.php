@extends('layout.mainlayout')
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Shop List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shop List</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="col-12">
            <table class="table table-nowrap table-hover">
                <thead>
                <th>Shop Name</th>
                <th>Contact Person</th>
                <th>Phone</th>
                <th>Location (Lat,Lng)</th>
                <th>Action</th>
                </thead>
                <tbody>
                @foreach($shops as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->contact}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->location}}</td>
                        <td>
                            <a href="{{route('shop.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                            <a href="{{route('shop.show',$item->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->
@endsection