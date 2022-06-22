@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">View Sales Ways</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Sales Ways</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="col-12">
                        <div id="map" class="shadow" style="width: 780px; height: 550px;"></div>
                    </div>
                </div>
                <div class="col-md-3">
                   <div class="col-12">
                       <span><strong>Way Id </strong>:{{$way->way_id}}</span><br>
                       <span><strong>Way Id </strong>:{{$way->way_id}}</span><br>
                       <span><strong>Shop List</strong> <button class="btn btn-outline-success btn-sm rounded-circle" data-toggle="modal" data-target="#add_shop"><i class="la la-plus"></i></button>
                       <button class="btn btn-outline-danger btn-sm rounded-circle" data-toggle="modal" data-target="#remove_shop"><i class="la la-trash-o"></i></button></span>
                       <ul style="list-style-type:number">
                           @foreach($assgin_shop as $item)
                               <li>{{$item->shop->name}}</li>
                               @endforeach
                       </ul>
                   </div>
                </div>
            </div>
        </div>
        <div id="add_shop" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title">Add Shop</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('add.shop')}}" method="POST">
                            @csrf
                            <input type="hidden" name="way_id" value="{{$way->id}}">
                            <div class="form-group">
                                <label for="branch">Branch</label>
                                <select name="branch_id" id="" class="form-control">
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shop">Shop</label>
                                <select name="shop_id[]" id="shop" class="form-control" multiple style="width: 100%;">
                                    @foreach($shops as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                </select>
                            </div>
                        <div class="form-group text-center">
                            <button type="submit" id="new_company" class="btn btn-primary">Add</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="remove_shop" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title">Remove Shop</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('remove.shop')}}" method="POST">
                            @csrf
                            <input type="hidden" name="way_id" value="{{$way->id}}">
                            <div class="form-group">
                                <label for="rev_shop">Shop</label>
                                <select name="shop_id[]" id="rev_shop" class="form-control" multiple style="width: 100%;">
                                    @foreach($assgin_shop as $item)
                                        <option value="{{$item->id}}">{{$item->shop->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        <div class="form-group text-center">
                            <button id="new_company" class="btn btn-primary">Add</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
    <script>
        $(document).ready(function () {
           $('select').select2();
        });
        $(function() {
            $("#map").googleMap();

            // Marker 1
            @foreach($assgin_shop as $item)
            $("#map").addMarker({
                title: '{{$item->shop->name}}', // Title
                text:  '<span>Contact Person: {{$item->shop->contact}}</span><br><span>Phone :{{$item->shop->phone}}</span>',
                coords: [{{$item->shop->location}}]
            });
            @endforeach
        });
    </script>
    <!-- /Page Wrapper -->

@endsection