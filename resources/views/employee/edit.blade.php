@extends('layout.mainlayout')
@section('title', 'Employee Edit')
@section('content')
<div class="content container-fluid">
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Employee Edit'])
<!-- /Page Header -->


<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Edit  Employees</h4>
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



