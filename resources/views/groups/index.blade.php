
@extends('layout.mainlayout')
@section('content')

{{-- Modals --}}
<x-partials.modal id="employee-import" title="Import">
    <x-forms.import route="employees.import" />
</x-partials.modal>

<div class="content container-fluid">
    <!-- Page Header -->
</div>


@endsection
@push('scripts')
@endpush
