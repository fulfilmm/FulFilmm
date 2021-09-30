@extends('layout.mainlayout')
@section('name', 'Customer Create')
@section('content')
    <!-- Page Header -->
    <div class="content container-fluid">
    {{-- ဒီ breadcrumb နဲ့ header ကထည့်လည်းရတယ်မထည့်လည်းရတယ်။ --}}
    @include('layout.partials.breadcrumb',['header'=>'Customer Create Form'])
    <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="{{route('customers.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                           @include('customer.form')
                            <div class="d-flex justify-content-end mt-3 border-top">
                                <button type="submit" class="btn btn-primary mt-3">
                                    Add Customer
                                </button>
                            </div>
                        </div>
                    </form>
                @include('company.quickcompany')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#customer_type').on('change', function () {
                var customer_type = $('#customer_type option:selected').val();
                if (customer_type == "Lead") {
                    $('#priority').append('<label for="Text6" class="form-label font-weight-bold text-muted text-uppercase pro_label" >Priority</label>\n' +
                        '                                 <div class="input-group" id="priority_field"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-arrow-circle-down"></i></span></div><select name="priority" id="priority_type" class="form-control"><option value="High">High</option><option value="Medium">Medium</option><option value="Low">Low</option></select></div>');
                    $('#tag_industry').append('<label for="Text6" class="form-label font-weight-bold text-muted text-uppercase pro_label" >Industry</label>\n' +
                        '                                <div class="input-group" id="tag"><div class="input-group">\n' +
                        '                                            <div class="input-group-prepend">\n' +
                        '                                                <span class="input-group-text"><i class="fa fa-tag"></i></span>\n' +
                        '                                            </div> <select name="tag_industry" id="industry" class="form-control"> @foreach($tags as $tag) @if($tag->id==$last_tag->id)<option value="{{$tag->id}}" selected>{{$tag->tag_industry}}</option> @else <option value="{{$tag->id}}">{{$tag->tag_industry}}</option> @endif @endforeach <select><div class="input-group-prepend">\n' +
                        '                                                <a href="" class="input-group-text" data-toggle=\'modal\' data-target=\'#industry_add\'><i class="fa fa-plus"></i></a>\n' +
                        '                                            </div></div></div>');
                } else {
                    $('.pro_label').remove();
                    $('#priority_field').remove();
                    $('#tag').remove();

                }
            })
        });
    </script>
@endsection
