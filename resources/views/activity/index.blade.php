@extends('layout.mainlayout')

@section('styles')
@livewireStyles
@endsection

@section('content')
    {{-- Modals --}}
    <x-partials.modal id="acitvity-create" title="Create Activity">
        <form action="{{ route('activities.store') }}" method="POST">
            @csrf
            <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>
            <x-forms.basic.select name="report_to_employee_id" title="Report To" value="{{$activity->report_to_employee_id ?? old('report_to_employee_id')}}" :options="$employees" required></x-forms.basic.select>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </x-partials.modal>

@endsection

@push('scripts')
@livewireScripts
@endpush
