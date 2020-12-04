@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
<!-- Page Header -->
@include('layout.partials.breadcrumb',['header'=>'Customer Table'])
<!-- /Page Header -->
<div class="row justify-content-end">
    <div class="col-xl-6 col-lg-8 col-md-10 col-12 text-right mb-3">
        {{-- <div class="row">
            <div class="col-lg-6 col-12">
                @include('forms.dynamic-input',['name'=>'start_date', 'title'=>'Start Date', 'value' => $record->start_date ?? '' , 'type' => 'date','required' =>true])
            </div>
            <div class="col-lg-6 col-12">
                @include('forms.dynamic-input',['name'=>'end_date', 'title'=>'End Date', 'value' => $record->end_date ?? '' , 'type' => 'date','required' =>true])
            </div>
        </div> --}}
        <a href="{{route('customers.export')}}" class="btn btn-primary">Export</a>
    </div>
</div>
<div class="row justify-content-end">
    <div class="col-xl-6 col-lg-8 col-md-10 col-12 text-right mb-3">
        @include('forms.excel-import', ['route' => route('customers.import')])
    </div>
</div>
<div class="row">
    <div class="col-12">
        <livewire:customer-table />
    </div>
</div>


@endsection

@push('scripts')
@livewireScripts
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
                    document.getElementById("del-customer"+id).submit();
                })

            }
        })
    }
</script>
@endpush

