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
        <div class="card mb-0">
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
                                            <h5 class="company-role m-t-0 mb-0">{{$record->ceo_name}}</h5>
                                            <small class="text-muted">CEO</small>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="personal-info">

                                            <li>
                                                <span class="title">Phone:</span>
                                                <span class="text"><a href="">{{$record->phone}}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="">{{$record->email}}</a></span>
                                            </li>
                                            <li>
                                                <span class="title">Address:</span>
                                                <span class="text">{{$record->address}}</span>
                                            </li>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <a class="btn btn-block btn-primary" href="{{route('companies.edit',$record->id)}}">Edit</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

@endsection
