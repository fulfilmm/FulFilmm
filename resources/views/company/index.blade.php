@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Companies Table</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Company</a></li>
                        <li class="breadcrumb-item active">All Companies</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-12">
                <livewire:company-table />
            </div>
        </div>
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

