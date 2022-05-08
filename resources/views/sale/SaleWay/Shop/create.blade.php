@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Shop Register</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Shop Add</li>
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
                        <form action="{{route('shop.store')}}" method="POST">
                            @csrf
                        <input type="hidden" name="emp_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                        <input type="hidden" name="branch_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->office_branch_id}}">
                        <div class="form-group">
                            <label for="">Shop Name</label>
                            <input type="text" class="form-control" name="name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Contact Person</label>
                            <input type="text" class="form-control" name="contact">
                            @error('contact')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" class="form-control" name="phone">
                            @error('phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control" id="location" name="location">
                            @error('location')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Picture</label>
                            <input type="file" name="picture">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

            </div>
            <script type="text/javascript">
                // $(function() {
                //     $("#map").googleMap();
                //     $("#map").addMarker({
                //         coords: [16.8350397982278,96.11916573126366], // GPS coords
                //         // icon: 'http://www.tiloweb.com/wp-content/uploads/2012/04/logo-e1335400790554.png',
                //         title: '<i class="fa fa-user"></i> Marker n°1', // Title
                //         // icon:'<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.vectorstock.com%2Froyalty-free-vector%2Fcar-simple-icon1-resize-vector-12351742&psig=AOvVaw1RdcLxM4T0h9f6qgGh1TnA&ust=1651284252064000&source=images&cd=vfe&ved=0CAwQjRxqFwoTCMjKnq2XuPcCFQAAAAAdAAAAABAD">',
                //         text:  '<b>Lorem ipsum</b> dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' // HTML content
                //     });
                // });
                var map = document.getElementById('map');
                // Initialize LocationPicker plugin
                var lp = new locationPicker(map, {
                    setCurrentPosition: true, // You can omit this, defaults to true
                }, {
                    zoom: 12 // You can set any google map options here, zoom defaults to 15
                });
                google.maps.event.addListener(lp.map, 'idle', function (event) {
                    // Get current location and show it in HTML
                    var location = lp.getMarkerPosition();
                    document.getElementById("location").value=location.lat+','+location.lng;
                });
            </script>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection