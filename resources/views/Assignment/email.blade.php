<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Assigned</title>
</head>
<body>
<b>Dear</b> {{$responsible_emp}},<br>
{{$assignee_name}} Assigned to you a new task the title is "{{$title}}".You need to look that task.<br>
<a href="{{route('assignments.show',$id)}}"><button type="button">Click</button></a>
</body>
</html>