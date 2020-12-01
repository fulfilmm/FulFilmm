
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        @include('layout.partials.breadcrumb',['header'=>'Employee Table'])

        <!-- /Page Header -->

@include('employee.partial.employeeform')


</div>
<!-- /Page Content -->

</div>

{{-- {{dd($errors->all())}} --}}

@endsection



