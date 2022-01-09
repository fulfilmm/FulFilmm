@extends('layout.mainlayout')
@section('title', 'Employee Edit')
@section('content')
<div class="content container-fluid">
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Employee Edit'])
<!-- /Page Header -->
    <form action="{{route('employees.update',$employee->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('employee.partial.employeeform')
        <div class="text-center my-3">
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{route('employees.index')}}" class="btn btn-secondary ml-3">Cancel</a>
        </div>
    </form>

{{-- {{dd($errors->all())}} --}}
</div>
@endsection



