@extends('layout.mainlayout')
@section('content')

    {{-- Modals --}}
    <x-partials.modal id="project-create" title="Create Projects">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>
{{--            <div class="form-group row">--}}
{{--                <label class="col-form-label col-md-2">Members</label>--}}
{{--                <div class="col-md-10 w-100" id="co_owners" name="co_owners">--}}
{{--                    @dd($employees)--}}

{{--                    <select class="form-control" id="employees_multiple_select" style="width: 100%" name="co_owners[]"--}}
{{--                            multiple="multiple" required>--}}
{{--                        @foreach ($employees as $key => $employee)--}}

{{--                            <option value={{$key}} @if($key === \Auth::id()) selected @endif>{{$employee}} </option>--}}
{{--                        @endforeach--}}

{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

            {{--            Date က လိုလောက်လား?--}}
            {{-- <x-forms.basic.date name="date" title="Date" required value=""></x-forms.basic.date>--}}
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </x-partials.modal>
    {{--End modals--}}

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col">
                    @include('layout.partials.breadcrumb',['header'=>'My Projects'])
                </div>
                <div class="col-auto float-right ml-auto">
                    {{-- @if(\Auth::guard('employee')->user()->role->name === 'Manager' ||  \Auth::guard('employee')->user()->role->name === 'CEO')--}}
                    <button data-toggle="modal" data-target="#project-create" class="btn add-btn"><i
                            class="fa fa-plus"></i> Create Projects
                    </button>
                    {{-- @endif--}}

                    <div class="view-icons">
                        {{-- <a href="{{route('companies.cards')}}" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>--}}
                        {{-- <a href="{{route('companies.index')}}" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>--}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <head>
                        @livewireStyles
                    </head>
                    <livewire:project-table/>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#employees_multiple_select').select2();

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
                        document.getElementById("del-project-" + id).submit();
                    })

                }
            })
        }
    </script>
@endpush
