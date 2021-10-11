@extends('layout.mainlayout')
@section('title', 'Company')
@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        @include('layout.partials.page-header', ['route' => 'companies','name'=>'Company', 'import' => true, 'export' => false, 'card' => true, 'list' => true])
        @yield('data')
    </div>
@endsection


