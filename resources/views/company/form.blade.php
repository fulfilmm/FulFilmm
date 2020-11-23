

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
                    <h3 class="page-title">Company Create/Edit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Companies</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Company</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{$route}}" method="POST" >
                            @csrf
                            @if ($route!== route('companies.store'))
                            {{-- {{dd($route,route('employees.create'))}} --}}
                            @method('put')
                            @endif
                            @include('forms.dynamic-input',['name'=>'test', 'title'=>'test'])

                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">Button</button>
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
<!-- /Page Wrapper -->
@endsection




