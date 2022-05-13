<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url(asset("css/bootstrap.min.css"))}}">
    <script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.googlemap/1.5.1/jquery.googlemap.min.js" integrity="sha512-mTxKPggCYbMylBEGHSZqkUvemhyjRIshmudjw6fiAxjVbKMZUqqVH/ugpvnQgOU4c4C2UhrWpOXkBeXFQfr9kA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDv10DmQtcdycwGXl-PTxCQDrfrf13uRds"></script>
    <link rel="stylesheet" href="{{url(asset("/css/font-awesome.min.css"))}}">
    <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>
</head>
<body>



<div class="row">
    <div class="col-9">
        <div id="map" style="width: 1000px; height: 550px;"></div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="">Shop Name</label>
            <input type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Lat</label>
            <input type="text" class="form-control" id="location">
        </div>
        <div class="form-group">
            <label for="">Picture</label>
            <input type="file">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(function() {
        $("#map").googleMap();
        $("#map").addMarker({
            coords: [21.9611136,96.0987136], // GPS coords
            // icon: 'http://www.tiloweb.com/wp-content/uploads/2012/04/logo-e1335400790554.png',
            title: '<i class="fa fa-user"></i> Marker n°1', // Title
            // icon:'<img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.vectorstock.com%2Froyalty-free-vector%2Fcar-simple-icon1-resize-vector-12351742&psig=AOvVaw1RdcLxM4T0h9f6qgGh1TnA&ust=1651284252064000&source=images&cd=vfe&ved=0CAwQjRxqFwoTCMjKnq2XuPcCFQAAAAAdAAAAABAD">',
            text:  '<b>Lorem ipsum</b> dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' // HTML content
        });
    });
    // var map = document.getElementById('map');
    // // Initialize LocationPicker plugin
    // $( document ).ready(function() {
    //     navigator.geolocation.getCurrentPosition(showPosition);
    //     function showPosition(position) {
    //         var lat = position.coords.latitude;
    //         var lng = position.coords.longitude;
    //         document.getElementById("location").value=lat+','+lng
    //         buildMap(lat, lng);
    //     }
    // });
</script>
</body>
</html>