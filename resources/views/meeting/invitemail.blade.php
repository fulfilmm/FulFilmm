<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Invite Mail</title>
</head>
<body>
Dear,{{$member_name}}<br>
<p>I hope this email finds you well. I’m writing to invite you to a meeting on {{\Carbon\Carbon::parse($meeting_data->due_date)->toFormattedDateString()}} at {{date('h:i:s a', strtotime(\Carbon\Carbon::parse($meeting_data->due_date)))}} to discuss {{$meeting_data->title}}.</p>
<p> The meeting will take place @if($meeting_data->meeting_type=="Real")at {{$meeting_data->meeting_room->address}},{{$meeting_data->meeting_room->room_no}} @else on {{$meeting_data->link_id}} and password is {{$meeting_data->password}} @endif. </p>
<p>An agenda for the meeting is attached. The most important topics for discussion include:</p>
<ol type="1">
    @foreach($agenda as $key=>$val)
        <li>{{$val}}</li>
    @endforeach
</ol>
<h4>Meeting Members</h4>
            <ol type="1">
                @foreach($our_emps as $key=>$val)
                    <li>{{$val}}</li>
                @endforeach

        </ol>
<div style="margin-left: 20px;">
Invited By,<br>
<strong >{{$meeting_data->emp->name}}</strong>
</div>
</body>
</html>
