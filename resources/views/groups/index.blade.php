@extends('layout.mainlayout')
@section('name', 'Group')
@section('content')

{{-- Modals --}}
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col">
                @include('layout.partials.breadcrumb',['header'=>'My Groups'])
            </div>
            <div class="col-auto float-right ml-auto">
                @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')
                <a href="{{route('groups.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>Create Groups</a>
                @endif


                <div class="view-icons">
{{--                    <a href="{{route('companies.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>--}}
                    <a href="{{route('groups.index')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <head>
                    @livewireStyles
                </head>
                <livewire:group-table />
            </div>
        </div>
    </div>

</div>


@endsection
@push('scripts')
@endpush
