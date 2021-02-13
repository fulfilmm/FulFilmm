
@extends('layout.mainlayout')
@section('content')
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Assign Permissions'])

<!-- /Page Header -->


<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0">Role - </h4>
                <h4>{{$role->name}}</h4>
            </div>
            <div class="card-body">
                @include('role.partial.assign-permissions-form')
                
            </div>
        </div>
    </div>
</div>

{{-- {{dd($errors->all())}} --}}

@endsection



