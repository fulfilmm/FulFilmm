@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('title', 'Activity')

@section('content')
{{-- Modals --}}
<x-partials.modal id="acitvity-create" title="Create Activity">
    <form action="{{ route('activities.store') }}" method="POST">
        @csrf
        <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>
        <x-forms.basic.select name="report_to_employee_id" title="Report To"
        value="{{$activity->report_to_employee_id ?? old('report_to_employee_id')}}"
        :options="$employees" required></x-forms.basic.select>
        <div class="form-group row">
            <label class="col-form-label col-md-2">Co Owners</label>
            <div class="col-md-10 w-100" id="co_owners" name="co_owners">
                {{--                    @dd($employees)--}}
                
                <select class="form-control" id="co_owner_multiple_select" style="width: 100%" name="co_owners[]"
                multiple="multiple" required>
                @foreach ($employees as $key => $employee)
                
                <option value={{$key}} @if($key === \Auth::id()) selected @endif>{{$employee}} </option>
                @endforeach
                
            </select>
        </div>
    </div>
    <x-forms.basic.date name="date" title="Date" required value=""></x-forms.basic.date>
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
                @include('layout.partials.breadcrumb',['header'=>'Activities'])
            </div>
            <div class="col-auto float-right ml-auto">
                
                {{-- his will result to modal--}}
                <button data-toggle="modal" data-target="#acitvity-create" class="btn add-btn"><i
                    class="fa fa-plus"></i> Create Activities
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <livewire:activity-table/>
        </div>
    </div>
    
    @endsection
    
    @push('scripts')
    @livewireScripts
    <script>
        $(document).ready(function () {
            $('#co_owner_multiple_select').select2();
            
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
                        document.getElementById("del-activity" + id).submit();
                    })
                    
                }
            })
        }
    </script>
    @endpush
    