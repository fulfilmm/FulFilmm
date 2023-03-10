@extends('employee.index')

@section('styles')
    @livewireStyles
@endsection

@section('data')
<div class="row">
    <div class="col-12">
        <livewire:employee-table />
    </div>
</div>
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

