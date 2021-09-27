@extends('layout.mainlayout')
@section('title', 'Company Edit')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Company Edit Form'])
    <!-- /Page Header -->

                        <form action="{{route('companies.update',$record->id)}}" method="POST">
                            @csrf
                            @method('put')
                            @include('company.form')
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{route('companies.index')}}" class="btn btn-secondary ml-3">Cancel</a>
                            </div>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>

@endsection
