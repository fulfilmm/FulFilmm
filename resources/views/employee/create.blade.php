@extends('layout.mainlayout')
@section('title', 'Employee Create')
@section('content')
<div class="content container-fluid">
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Employee Form'])
<!-- /Page Header -->

    <form action="{{route('employees.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('employee.partial.employeeform')
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Submit</button>
            <a href="{{route('employees.index')}}" class="btn btn-secondary ml-3">Cancel</a>
        </div>
    </form>

{{-- {{dd($errors->all())}} --}}
</div>
@endsection



