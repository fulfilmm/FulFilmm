<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery -->
    <script src="{{url(asset("js/jquery-3.2.1.min.js"))}}"></script>

    <!--JCrop plugin -->
    <link rel="stylesheet" href="{{url(asset('css/imagecrop/jquery.Jcrop.min.css'))}}" />
    <script src="{{url(asset('js/imagecrop/jquery.Jcrop.min.js'))}}"></script>
    <link rel="stylesheet" href="{{url(asset('css/imagecrop/style.css'))}}" />
    <script src="{{url(asset('js/imagecrop/jquery.SimpleCropper.js'))}}"></script>
</head>
<body>
<div class="cropme" style="width: 10px;height: 10px">asdfas</div>
<script>
    $('.cropme').simpleCropper();

</script>
</body>
</html>