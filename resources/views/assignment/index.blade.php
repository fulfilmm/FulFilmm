@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    {{-- Modals --}}
    <x-partials.modal id="assignment-create" title="Create Assignment">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf
            <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>
            <x-forms.basic.date name="date" title="Date" required value=""></x-forms.basic.date>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </x-partials.modal>

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=>'Activities'])
                </div>
                <div class="col-auto float-right ml-auto">

                    {{-- his will result to modal--}}
                    <button data-toggle="modal" data-target="#assignment-create" class="btn add-btn"><i
                            class="fa fa-plus"></i> Create Assignments
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <livewire:assignment-table/>
            </div>
        </div>

        @endsection

        @push('scripts')
            @livewireScripts
            <script>
                $(document).ready(function () {
                    $('#employees_multiple_select').select2();

                });
            </script>
            <script>
                // function deleteRecord(id) {
                //     Swal.fire({
                //         title: 'Are you sure?',
                //         text: "You cannot retrieve data back!",
                //         icon: 'warning',
                //         showCancelButton: true,
                //         confirmButtonColor: '#ff9b44',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Yes, delete it!'
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             Swal.fire(
                //                 'Deleted!',
                //                 'Record has been deleted.',
                //                 'success'
                //             ).then(() => {
                //                 document.getElementById("del-activity" + id).submit();
                //             })
                //
                //         }
                //     })
                // }
            </script>
    @endpush
