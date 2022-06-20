@extends('layout.mainlayout')
@section('name', 'Customer Create')
@section('content')
    <style>
        .ck-editor__editable {
            min-height: 200px !important;
        }
    </style>
    <!-- Page Header -->
    <div class="content container-fluid">
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Customer Create Form'])
    <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <form action="{{route('customers.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('customer.form')
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
                @include('company.quickcompany')
                @include('customer.addzone')
            </div>
        </div>
        <script>
            ClassicEditor.create($('#bio')[0], {
                toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
            });
            $(document).ready(function () {
                $('#title').hide();
                $('#priority').hide();
                $('#tag_industry').hide();
                $('#status').hide();
                $('#case').hide();
                $('#customer_type').on('change', function () {
                    var customer_type = $('#customer_type option:selected').val();
                    if (customer_type == "Lead") {
                        $('#title').show('');
                        $('#priority').show('');
                        $('#tag_industry').show('');
                        $('#status').show('');
                        $('#case').hide('');
                    } else if(customer_type=='In Query') {
                        $('#title').hide('');
                        $('#priority').hide('');
                        $('#tag_industry').hide('');
                        $('#status').hide('');
                        $('#case').show('');
                    }else {
                        $('#title').hide('');
                        $('#priority').hide('');
                        $('#tag_industry').hide('');
                        $('#status').hide('');
                        $('#case').hide('');
                    }
                })
            });
        </script>
@endsection