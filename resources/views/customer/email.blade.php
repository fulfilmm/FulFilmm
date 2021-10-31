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
    Hi {{$follower_name}}<br>
    <p>{{$desc}}</p><br>
    Lead Name : {{ucfirst($lead_name)}}<br>
    Date : {{\Carbon\Carbon::parse($date)->toFormattedDateString()}}.<br>
    <a href="{{route('customers.show',$lead_id)}}"><button type="button">Go to lead</button></a>
</body>
</html>