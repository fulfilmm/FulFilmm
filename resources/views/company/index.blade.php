@extends('layout.mainlayout')

@section('styles')
    @livewireStyles
@endsection

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        @include('layout.partials.page-header', ['route' => 'companies', 'import' => true, 'export' => false, 'card' => true, 'list' => true])
        @yield('data')
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
                        document.getElementById("del-company" + id).submit();
                    })

                }
            })
        }
    </script>
@endpush


