@extends('layout.mainlayout')
@section('name', 'Group Edit')
@section('content')
    <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    <div class="content container-fluid">
    @include('layout.partials.breadcrumb',['header'=>'Group Create Form'])
    <!-- /Page Header -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit group</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('groups.update',$group->id)}}" method="POST" >
                            @csrf
                            @method('PUT')
                            @include('groups.form')
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

