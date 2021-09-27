@extends('layout.mainlayout')
@section('title', 'Employee Create')
@section('content')
<div class="content container-fluid">
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Employee Form'])
<!-- /Page Header -->


                @include('employee.partial.employeeform')
{{-- {{dd($errors->all())}} --}}
</div>
@endsection



