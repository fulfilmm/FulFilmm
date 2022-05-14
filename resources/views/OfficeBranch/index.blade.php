@extends("layout.mainlayout")
@section('title','Office Branch')
@section("content")
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Office</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Office Branch</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 card shadow" style="overflow: auto">
           <table class="table table-nowrap table-hover">
               <thead>
               <tr>
                   <th>Branch Name</th>
                   <th>Address</th>
                   <th>Head Office</th>
                   <th>Action</th>
               </tr>
               </thead>
               <tbody>
                @foreach($office_branch as $branch)
                    <tr>
                        <td>{{$branch->name}}</td>
                        <td>{{$branch->address}}</td>
                        <td>{{$branch->head->name??'N/A'}}</td>
                        <td>
                            <div class="row">
                                <a href="{{route('officebranch.show',$branch->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                                <button type="button" data-toggle="modal" data-target="#edit_{{$branch->id}}" class="btn btn-white btn-sm"><i class="la la-edit"></i></button>
                                @if($branch->status==0)
                                    <button type="button" data-toggle="modal" data-target="#delete_{{$branch->id}}" class="btn btn-white btn-sm"><i class="la la-trash"></i></button>
                                    @endif
                                <a href="{{url('branch/report/'.$branch->id)}}" class="btn btn-white btn-sm">Report</a>
                            </div>
                            <div id="edit_{{$branch->id}}" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title">Edit Office Branch</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('officebranch.update',$branch->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="head">Head Office</label>
                                                            <select name="head_office" id="head" class="form-control">
                                                                @foreach($head as $item)
                                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" name="name" value="{{$branch->name}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <input type="text" name="address" class="form-control" value="{{$branch->address}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="delete_{{$branch->id}}" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title">Edit Office Branch</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('officebranch.destroy',$branch->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <span class="text-warning">Are you sure {{$branch->name}} delete?</span>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
               </tbody>
           </table>
        </div>
    </div>

@endsection