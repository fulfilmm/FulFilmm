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
                <div class="col-md-9 col-12">
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
            <div id="map" style="width: 100%; height: 600px;"> </div>
            <script type="text/javascript">
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (p) {
                        var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
                        var mapOptions = {
                            center: LatLng,
                            zoom: 13,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                        var marker = new google.maps.Marker({
                            position: LatLng,
                            map: map,
                            title: "<div style = 'height:60px;width:200px'><b>Your location:</b><br />Latitude: " + p.coords.latitude + "<br />Longitude: " + p.coords.longitude
                        });
                        google.maps.event.addListener(marker, "click", function (e) {
                            var infoWindow = new google.maps.InfoWindow();
                            infoWindow.setContent(marker.title);
                            infoWindow.open(map, marker);
                        });
                        $('#location').val(p.coords.latitude+","+p.coords.longitude);
                    });
                } else {
                    alert('Geo Location feature is not supported in this browser.');
                }
            </script>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection