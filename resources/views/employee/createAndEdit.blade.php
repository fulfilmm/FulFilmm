
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        @include('layout.partials.breadcrumb',['header'=>'Employee Table'])

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
</div>
<!-- /Page Content -->

</div>

{{-- {{dd($errors->all())}} --}}

@endsection



