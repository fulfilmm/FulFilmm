<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
 Dear,{{$name}},<br>
    Your invoice number {{$inv_id}} deliveried with {{$courier_name}}.<br>
    If you want to tracking,click the following button.<br>
 <a href="{{url("delivery/tracking/$uuid")}}"><button>Click For Tracking</button></a>
</body>
</html>