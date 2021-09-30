@extends('layout.mainlayout')
@section('title', 'Company Create')
@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Company Create Form'])
    <!-- /Page Header -->

                        <form action="{{route('companies.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('company.form')
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <a href="{{route('companies.index')}}" class="btn btn-secondary ml-3">Cancel</a>
                            </div>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>

@endsection
