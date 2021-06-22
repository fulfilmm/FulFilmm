@extends('layout.mainlayout')
@section('title', 'Assignment')
@section('styles')
    @livewireStyles
@endsection

@section('content')
    {{-- Modals --}}
    <x-partials.modal id="assignment-create" title="Create Assignment">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf
            <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>

            <div class="form-group row">
                <label class="col-form-label col-md-2">Assign Group</label>
                <div class="col-md-10 w-100" id="co_owners">
                    <select class="form-control" id="groups_multiple_select" style="width: 100%" name="assigned_group[]"
                            multiple="multiple">
                        @foreach ($groups as $key => $group_name)

                            <option value={{$key}} @if($key === \Auth::id()) selected @endif>{{$group_name}} </option>
                        @endforeach

                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-form-label col-md-2">Assign to</label>
                <div class="col-md-10 w-100" id="co_owners">
                    <select class="form-control" id="employees_multiple_select" style="width: 100%" name="assigned_employee[]"
                            multiple="multiple">
                        @foreach ($employees as $key => $employee)

                            <option value={{$key}} @if($key === \Auth::id()) selected @endif>{{$employee}} </option>
                        @endforeach

                    </select>
                </div>
            </div>
            <x-forms.basic.date name="due_date" title="Due Date" required="true" value=""></x-forms.basic.date>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary">Create</button>
                <a href="{{route('departments.index')}}" class="btn btn-secondary ml-3">Cancel</a>
            </div>
        </form>
    </x-partials.modal>

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=>'Assignments'])
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

                    $('#groups_multiple_select').select2();

                });
            </script>
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
                                document.getElementById("del-assignment" + id).submit();
                            })

                        }
                    })
                }
            </script>
    @endpush
