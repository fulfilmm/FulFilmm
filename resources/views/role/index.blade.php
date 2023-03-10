
@extends('layout.mainlayout')
@section('title','Roles')
@section('content')

{{-- Modals --}}


<div class="content container-fluid">

    <!-- Page Header -->
    @include('layout.partials.page-header', ['route' => 'roles','name'=>'roles', 'import' => false, 'export' => false, 'card' => false, 'list' => true])
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
