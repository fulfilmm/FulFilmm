
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
        @include('layout.partials.breadcrumb',['header'=>'Employee Table'])
        <!-- /Page Header -->

<head>
    @livewireStyles
</head>

    @if(session()->has('success'))
    <div class="">
        {{ session()->get('success') }}
    </div>
@endif
    <livewire:employee-table />

   
</div>
<!-- /Page Content -->

</div>

{{-- {{dd($errors->all())}} --}}

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