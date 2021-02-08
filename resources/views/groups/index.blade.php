
@extends('layout.mainlayout')
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
            <a href="{{route('companies.create')}}" class="btn add-btn"><i class="fa fa-plus"></i>Create Groups</a>


            <div class="view-icons">
                <a href="{{route('companies.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="{{route('companies.index')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
</div>

</div>


@endsection
@push('scripts')
@endpush
