@extends('layout.mainlayout')
@section('title', 'Department Create')
@section('content')
    <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    <div class="content container-fluid">
    @include('layout.partials.breadcrumb',['header'=>'Department Create Form'])
    <!-- /Page Header -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Department</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('departments.store')}}" method="POST">
                            @csrf
                            @include('department.form')
                            <div class="col-8 offset-2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary col-5" type="submit">Submit</button>
                                    <a href="{{route('departments.index')}}" class="btn btn-secondary col-5 ml-5">Cancel</a>
                                </div>
                            </div>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
