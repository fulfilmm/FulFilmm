@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        @include('layout.partials.page-header', ['route' => 'departments', 'import' => true, 'export' => false, 'card' => true, 'list' => true])

        <div class="row">
            <div class="col-12">
                <livewire:department-table/>
            </div>
        </div>
    </div>

@endsection
