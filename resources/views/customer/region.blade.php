@extends('layout.mainlayout')
@section('title','Sale Zone')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sale Region</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sale Region</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" class="btn add-btn shadow-sm" data-toggle="modal" data-target="#add_region"><i class="fa fa-plus"></i> Add Region</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-nowrap table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($regions as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->branch->name}}</td>
                        <td>
                            <div class="row">
                                <button type="button" data-toggle="modal" data-target="#edit_region{{$item->id}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></button>
                                <div id="edit_region{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title">Edit Sale Zone</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('region.update',$item->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{$item->name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="branch">Office Branch</label>
                                                        <select name="branch_id" id="branch" class="form-control select2" style="width: 100%">
                                                            @foreach($branch as $key=>$val)
                                                                <option value="{{$key}}" {{$item->branch_id==$key?'selected':''}}>{{$val}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{route('region.destroy',$item->id)}}" method="post">
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
    @include('customer.addregion')
@endsection