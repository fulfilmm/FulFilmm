@extends("layout.mainlayout")
@section("title","Product Category")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Variant Setting</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Variant</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button href="#" type="button" data-toggle="modal" data-target="#add_variant" class="btn btn-white btn-sm text-primary" id="add_row">Add Variant</button>                </div>
            </div>
        </div>
        <!-- /Page Header -->

        {{--@include('product.catadd')--}}
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-list-alt mr-2"></i>Variant</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="category">
                    <thead>
                    <tr>
                        <th scope="col">Attribute</th>
                        <th>Value</th>
                        <th>Active</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($variants as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>@foreach($variants_value as $value) @if($item->id==$value->variant_key) <span class="badge badge-secondary">{{$value->value}} </span> @endif @endforeach
                                <a href="#" class="followers-add " data-toggle="modal" data-target="#add_value{{$item->id}}"><i class="la la-plus"></i></a>
                                <div class="modal fade" id="add_value{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Add New Value For {{$item->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="{{url('/variant/value')}}" method="POST">
                                                    @csrf
                                                <div class="form-group">
                                                    <input type="hidden" name="variant_key" value="{{$item->id}}">
                                                    <label for="">New Values</label>
                                                    <select name="value[]"  class="select2" multiple>
                                                        <option></option>
                                                    </select>
                                                </div>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active{{$item->id}}" name="enable" value="1"
                                           {{$item->active?'checked':''}}>
                                    <label class="custom-control-label" for="active{{$item->id}}"></label>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $('#active{{$item->id}}').on('click',function (event) {
                                            if($(this).prop("checked") == true){
                                                var enable=1;
                                            }
                                            else if($(this).prop("checked") == false){
                                                var enable=0;
                                            }
                                            $.ajax({
                                                data: {
                                                    "enable": enable
                                                },
                                                type: 'POST',
                                                url: "{{route('variant.active',$item->id)}}",
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                success: function (data) {
                                                    console.log(data);
                                                    swal({
                                                            title: "Variant",
                                                            text: 'This variant is '+data.Account,
                                                            type: "success"
                                                        }
                                                    ).then(function(){
                                                        location.reload();
                                                    });
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cat_update{{$item->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit"></i></a>
                                <a href="{{route('category.delete',$item->id)}}" class="btn btn-danger btn-sm" ><i class="fa fa-trash text-white"></i></a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="add_variant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add New Variant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="name" id="variant" class="form-control" placeholder="Type Variant">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" data-dismiss="modal" id="add" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $("#case").DataTable();
            $('.select2').select2({
                tags:true,
                allowClear: true,
                width:'100%'
            });
        });
        $(document).ready(function () {
            $(document).on('click', '#add', function () {
                var variant_name = $('#variant').val();
                $.ajax({
                    data: {
                        active:1,
                        name: variant_name,
                    },
                    type: 'POST',
                    url: "{{url('product/variant/add')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        window.location.reload();

                    }

                });

            });
        });
    </script>
@endsection
