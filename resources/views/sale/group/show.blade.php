@extends('layout.mainlayout')
@section('name', 'Sale Group Detail')
@section('content')
    <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$group->name}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('salegroup.index')}}">Sale Group</a></li>
                        <li class="breadcrumb-item active">{{$group->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3>{{ucfirst($group->name)}} Members</h3>
                </div>
                <div class="card-body">
                     <span><button class="btn btn-outline-success btn-sm rounded-circle" data-toggle="modal" data-target="#add_shop" title="Add Member"><i class="la la-plus"></i></button>
                       <button class="btn btn-outline-danger btn-sm rounded-circle" data-toggle="modal" data-target="#remove_shop" title="Remove Member"><i class="la la-trash-o"></i></button></span>
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>Member Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $mem)
                            <tr>
                                <td>
                                    {{--<input type="checkbox" name="member[]" value="{{$mem->id}}">--}}
                                    <img src="{{$mem->profile_img!=null? url(asset('img/profiles/'.$mem->emp->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
                                    <a href="{{route('employees.show',$mem->emp->id)}}">{{$mem->emp->name}}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="add_shop" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Add Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('add.member')}}" method="POST">
                        @csrf
                        <input type="hidden" name="group_id" value="{{$group->id}}">
                        <div class="form-group">
                            <label for="shop">Shop</label>
                            <select name="emp_id[]" id="shop" class="form-control" multiple style="width: 100%;">
                                @foreach($employee as $item)
                                    @if($item->department->name=='Sale Department')
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="new_company" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="remove_shop" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Remove Shop</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('remove.member')}}" method="POST">
                        @csrf
                        <input type="hidden" name="group_id" value="{{$group->id}}">
                        <div class="form-group">
                            <label for="rev_shop">Shop</label>
                            <select name="member_id[]" id="rev_shop" class="form-control" multiple style="width: 100%;">
                                @foreach($members as $item)
                                    <option value="{{$item->id}}">{{$item->emp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button id="new_company" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('select').select2();
        });
    </script>
@endsection