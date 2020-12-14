@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('content')

{{-- Modals --}}
<x-partials.modal id="company-import" title="Import">
    <x-forms.import route="customers.import" />
</x-partials.modal>

<x-partials.modal id="company-export" title="Export" >
    <x-forms.export route="companies.export"/>
</x-partials.modal>

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col">
            @include('layout.partials.breadcrumb',['header'=>'Companies Table'])
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route('companies.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Customer</a>


            <div class="view-icons">
                <a href="{{route('companies.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="{{route('companies.index')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-auto float-right ml-auto">
            <a href="#" data-toggle="modal" data-target="#customer-import" class="btn btn-primary rounded mr-3">Import</a>
            <a href="{{route('companies.export')}}"  class="btn btn-primary rounded mr-3">Export</a>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-12">
            <livewire:company-table />
        </div>
    </div>

    @endsection

    @push('scripts')
    @livewireScripts
    <script>
        function deleteRecord(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You cannot retrieve data back!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff9b44',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Record has been deleted.',
                    'success'
                    ).then(() => {
                        document.getElementById("del-company"+id).submit();
                    })

                }
            })
        }
    </script>
    @endpush

