<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approval Request Notification</title>
</head>
<body>
    Dear,<br>
    {{$to_name}}<br>
    <p>Requestation ID <a href="{{route('approvals.show',$id)}}">{{$app_id}}</a> requested by {{$request_name}}.</p>
    <br>
    If You want to view,
    <a href="{{route('approvals.show',$id)}}"><button>Click Here</button></a>
    <br>
    Thank You!
</body>
</html>
