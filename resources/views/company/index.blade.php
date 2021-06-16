@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        @include('layout.partials.page-header', ['route' => 'companies', 'import' => true, 'export' => false, 'card' => true, 'list' => true])
        @yield('data')
    </div>
@endsection


