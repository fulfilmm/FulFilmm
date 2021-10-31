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
<b>Dear</b> {{$emp_name}},<br>
    {{$addby}} reports you a new activity the title is "{{$title}}".You need to look that activity.<br>
<a href="{{route('activity.show',$activity_id)}}"><button type="button">Click</button></a>
</body>
</html>