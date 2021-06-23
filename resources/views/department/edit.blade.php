@extends('layout.mainlayout')
@section('title', 'Department Edit')
@section('content')

<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
<div class="content container-fluid">
    @include('layout.partials.breadcrumb',['header'=>'Department Edit Form'])
    <!-- /Page Header -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Update Department</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('departments.update',$record->id)}}" method="POST" >
                        @csrf
                        @method('put')
                        @include('department.form')
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{route('departments.index')}}" class="btn btn-secondary ml-3">Cancel</a>
                        </div>
                    </button>
                </form>
                {{-- {{dd($errors->all())}} --}}
            </div>
        </div>
    </div>
</div>
</div>

@endsection
