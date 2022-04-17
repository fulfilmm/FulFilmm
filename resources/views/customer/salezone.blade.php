@extends('layout.mainlayout')
@section('title','Sale Zone')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sale Zone</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sale Zone</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_zone"><i class="fa fa-plus"></i> Add Zone</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-nowrap table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($zones as $zone)
                    <tr>
                        <td>{{$zone->name}}</td>
                        <td>
                            <div class="row">
                                <button type="button" data-toggle="modal" data-target="#edit_zone{{$zone->id}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></button>
                                <div id="edit_zone{{$zone->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title">Edit Sale Zone</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('salezone.update',$zone->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{$zone->name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('salezone.destroy',$zone->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                </form>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
  @include('customer.addzone')
@endsection