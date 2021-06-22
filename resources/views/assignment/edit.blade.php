@extends('layout.mainlayout')
@section('title', 'Company Edit')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Assigment Edit Form'])
    <!-- /Page Header -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Company</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('assignments.update',$assignment->id)}}" method="POST">
                            @csrf
                            @method('put')
                            @include('assignment.partial.form')
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{route('assignments.index')}}" class="btn btn-secondary ml-3">Cancel</a>
                            </div>
                        </form>
                        {{-- {{dd($errors->all())}} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
