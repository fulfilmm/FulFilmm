@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Shop Details</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shop Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="col-12 my-3">
            <div class="row">
                <div class="col-9">
                    <div id="map" style="width: 750px; height: 550px;"></div>
                </div>
                <div class="col-3">
                        <div class="form-group">
                            <label for="">Shop Name :</label>
                           {{$shop->name}}
                        </div>
                        <div class="form-group">
                            <label for="">Contact Person :</label>
                           {{$shop->contact}}
                        </div>
                        <div class="form-group">
                            <label for="">Phone :</label>
                            {{$shop->phone}}
                        </div>
                        <div class="form-group">
                            <label for="">Location :</label>
                            {{$shop->location}}
                        </div>
                        <div class="form-group">
                            <label for="">Picture</label>
                            <input type="file" name="picture">
                        </div>
                </div>

            </div>
            <script type="text/javascript">
                $(function() {
                    $("#map").googleMap();
                    $("#map").addMarker({
                        coords: [{{$shop->location}}], // GPS coords
                        // icon: 'http://www.tiloweb.com/wp-content/uploads/2012/04/logo-e1335400790554.png',
                        title: '<span>{{$shop->name}}<span>', // Title
                        // icon:'<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.vectorstock.com%2Froyalty-free-vector%2Fcar-simple-icon1-resize-vector-12351742&psig=AOvVaw1RdcLxM4T0h9f6qgGh1TnA&ust=1651284252064000&source=images&cd=vfe&ved=0CAwQjRxqFwoTCMjKnq2XuPcCFQAAAAAdAAAAABAD">',
                        text:  '<span>Contact Person:{{$shop->contact}}</span><br><span>Phone:{{$shop->phone}}</span>' // HTML content
                    });
                });

            </script>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection