@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('content')
{{-- Modals --}}
<x-partials.modal id="department-import" title="Import">
    <x-forms.import route="departments.import" />
</x-partials.modal>

<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center mb-3">
        <div class="col">
            @include('layout.partials.breadcrumb',['header'=>'Department Table'])
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route('departments.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Department</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-auto float-right ml-auto">
            <a href="#" data-toggle="modal" data-target="#department-import" class="btn btn-primary rounded mr-3">Import</a>
            <a href="{{route('departments.export')}}" class="btn btn-primary rounded mr-3">Export</a>
        </div>
    </div>
</div>


{{-- <!-- Page Header -->
    @include('layout.partials.breadcrumb',['header'=>'Department Table'])
    <!-- /Page Header -->
    <div class="row justify-content-end">
        <div class="col-xl-6 col-lg-8 col-md-10 col-12 text-right mb-3">
            <a href="{{route('departments.export')}}" class="btn btn-primary">Export</a>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-xl-6 col-lg-8 col-md-10 col-12 text-right mb-3">
            @include('forms.excel-import', ['route' => route('departments.import')])
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <livewire:department-table />
        </div>
    </div>


    @endsection

    @push('scripts')
    @livewireScripts
    <script>
        function deleteDept(id) {
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
                        document.getElementById("del-dept"+id).submit();
                    })

                }
            })
        }
    </script>
    @endpush

