

@extends('layout.mainlayout')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Company Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Companies</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Company</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('companies.update')}}" method="PUT">
                            @csrf
                            @include('company.form')
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@endsection
