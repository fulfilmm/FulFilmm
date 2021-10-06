@extends('layout.mainlayout')
@section('title', 'Settings')
@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=>'Settings'])
                </div>
            </div>
            <div class="row">

            </div>
        </div>

    </div>


@endsection
@push('scripts')
@endpush
