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

                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>

@endsection
