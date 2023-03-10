@extends('layout.mainlayout')
@section('title','Role Create')
@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Roles Form'])

    <!-- /Page Header -->


        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Roles</h4>
                    </div>
                    <div class="card-body">
                        @include('role.partial.role-form')

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {{dd($errors->all())}} --}}

@endsection



