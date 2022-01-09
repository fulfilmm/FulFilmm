@extends('layout.mainlayout')
@section('name', 'Group Detail')
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
                        <li class="breadcrumb-item active"><a href="{{route('groups.index')}}">Group</a></li>
                        <li class="breadcrumb-item active">{{$group->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                        <h3>{{ucfirst($group->name)}} Group Members</h3>
                </div>
                <div class="card-body">
                    <table class="table dataTable">
                        <thead>
                                <tr>
                                    <th>Member Name</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach($group->employees as $mem)
                                <tr>
                                    <td>
                                        {{--<input type="checkbox" name="member[]" value="{{$mem->id}}">--}}
                                        <img src="{{$mem->profile_img!=null? url(asset('img/profiles/'.$mem->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">
                                        <a href="{{route('employees.show',$mem->id)}}">{{$mem->name}}</a></td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection