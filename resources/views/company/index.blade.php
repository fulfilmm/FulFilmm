@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('content')
@include('company.export', ['modal_id' => 'company-export', 'modal_title' => 'Company Export'])
@include('company.import', ['modal_id' => 'company-import', 'modal_title' => 'Company import'])


<!-- Page Header -->

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                @include('layout.partials.breadcrumb',['header'=>'Company Table'])
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="{{route('customers.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Company</a>


                <div class="view-icons">
                    <a href="employees" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                    <a href="employees-list" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-auto float-right ml-auto">
                <a href="#" data-toggle="modal" data-target="#company-import" class="btn btn-primary rounded mr-3">Import</a>
                <a href="#" data-toggle="modal" data-target="#company-export" class="btn btn-primary rounded mr-3">Export</a>
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

