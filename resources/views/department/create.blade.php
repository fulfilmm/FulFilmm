@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Department Create Form</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Departments</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Department</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('departments.store')}}" method="POST" >
                            @csrf
                            @include('department.form')
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </button>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>

@endsection
