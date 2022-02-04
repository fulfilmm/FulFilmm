@extends('layout.mainlayout')
@section('title', 'Company Edit')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Company Edit Form'])
    <!-- /Page Header -->

                        <form action="{{route('companies.update',$record->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            @include('company.form')
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>

@endsection
