<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Mail Noti</title>
</head>
<body>
Dear,<br>
{{$name}}<br>
{{$type}} {{$id}}.<br>
If you want to check,<a href="{{route('tickets.show',$ticket_id)}}"><button>Check Ticket</button></a>
<br>
By,<br>
{{$from_name}}
</body>
</html>