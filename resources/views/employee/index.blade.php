
@extends('layout.mainlayout')
@section('title', 'Employee')
@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    @include('layout.partials.page-header', ['route' => 'employees','name'=>'Employee', 'import' => true, 'export' => true, 'card' => true, 'list' => true])
    @yield('data')

</div>

<div id="export" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div>
                        {{--@dd($route)--}}
                        <form action="{{route('employees.export')}}" method="GET">
                            @csrf
                            <div class="form-group">
                                <label for="start">Start Date</label>
                                <input type="text" class="form-control" id="start" name="start_date"  value="" title="Start Date" required>
                            </div>
                            <div class="form-group">
                                <label for="end">End Date</label>
                                <input type="text" class="form-control" id="end" name="end_date"  value="" title="End Date" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Export</button>
                                <button type="button" data-dismiss="modal" class="btn btn-primary ml-3">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="import" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div>
                        {{--@dd($route)--}}
                        <form action="{{url('customers/import/data')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="start">File</label>
                                <input type="file" class="form-control" id="file" name="import"  value="" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    jQuery(document).ready(function () {
        'use strict';

        jQuery('#start').datetimepicker();
        jQuery('#end').datetimepicker();
    });
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
