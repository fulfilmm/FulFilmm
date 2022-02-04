
@extends('layout.mainlayout')
@section('title', 'Employee')
@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    @include('layout.partials.page-header', ['route' => 'employees','name'=>'Employee', 'import' => true, 'export' => true, 'card' => true, 'list' => true])
    @yield('data')

</div>


@endsection
@push('scripts')
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
    $(document).ready(function () {
       $('select').select2();
    });
    $(document).on('click', '#change', function () {
        var emp_id =new Array();
        $("input:checked").each(function () {
            // console.log($(this).val()); //works fine
            emp_id.push($(this).val());
        });
        var action_type=$( "#brand option:selected" ).val();
        // alert(action_type);
        $.ajax({
            type:'POST',
            data : {action_Type:action_type,emp_id:emp_id},
            url:'/add/emp/branch',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                console.log(data);
                window.location.reload();
            }
        });
    });
</script>
@endpush
