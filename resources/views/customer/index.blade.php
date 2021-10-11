@extends('layout.mainlayout')

@section('name', 'Contact')

@section('content')

    <!-- Page Header -->
    <div class="content container-fluid">
        @include('layout.partials.page-header', ['route' => 'customers','name'=>'Contact', 'import' => true, 'export' => false, 'card' => true, 'list' => true])
        @yield('data')
    </div>

@endsection


