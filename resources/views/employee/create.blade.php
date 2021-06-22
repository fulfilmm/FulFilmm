@extends('layout.mainlayout')
@section('title', 'Employee Create')
@section('content')
<div class="content container-fluid">
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Employee Form'])
<!-- /Page Header -->


<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Create New Employee</h4>
            </div>
            <div class="card-body">
                @include('employee.partial.employeeform')

            </div>
        </div>
    </div>
</div>

{{-- {{dd($errors->all())}} --}}
</div>
@endsection



