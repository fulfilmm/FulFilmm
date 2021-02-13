
@extends('layout.mainlayout')
@section('content')

{{-- Modals --}}


<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center mb-3">
            <div class="col">
                @include('layout.partials.breadcrumb',['header'=>'Roles Table'])
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="{{route('roles.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Role</a>


                <div class="view-icons">
                    <a href="employees" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                    <a href="employees-list" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </div>
       
    </div>
    <div class="row">
        <div class="col-12">
            <head>
                @livewireStyles
            </head>
            <livewire:roles-table />
        </div>
    </div>

</div>


@endsection
@push('scripts')
@livewireScripts
<script>
    function deleteRecord(id) {
        event.preventDefault()
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
                    document.getElementById("employee-del-"+id).submit();
                })

            }
        })
    }
</script>
@endpush
