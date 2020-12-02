@extends('layout.mainlayout')
@section('content')
<!-- Page Header -->
{{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
@include('layout.partials.breadcrumb',['header'=>'Company Create Form'])
<!-- /Page Header -->

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Company</h4>
            </div>
            <div class="card-body">
                <form action="{{route('companies.store')}}" method="POST" >
                    @csrf
                    @include('company.form')
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
                {{-- {{dd($errors->all())}} --}}
            </div>
        </div>
    </div>
</div>
@endsection
