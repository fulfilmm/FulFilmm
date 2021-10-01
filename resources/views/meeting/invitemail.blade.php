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
{!! $meeting_data->letter !!}
<table style="border: 0;padding-top: 20px">
    <tr>
        <th style="text-align: left">Agenda</th>
        <th style="text-align: left">Meeting Members</th>
        <th ></th>
    </tr>
    <tr>
        <td style="min-width: 400px;text-align: left;">
            <ol type="1">
            @foreach($agenda as $key=>$val)

                   <li>{{$val}}</li>

            @endforeach
            </ol>
        </td>
        <td style="min-width: 400px;text-align: left">
            <ol type="1">
                @foreach($our_emps as $key=>$val)
                    <li>{{$val}}</li>
                @endforeach

            </ol>
        </td>
    </tr>
</table>
<div style="position: absolute;left: 200px;padding-top: 10px;border: black">
    <ul>
        <li>Date :{{\Carbon\Carbon::parse($meeting_data->due_date)->toFormattedDateString()}}</li>
        <li>Time :{{date('h:i a', strtotime(\Carbon\Carbon::parse($meeting_data->due_date)))}}
        @if($meeting_data->meeting_type=="Real")
            <li>Address :{{$meeting_data->meeting_room->address}}</li>
            <li>Room No :{{$meeting_data->meeting_room->room_no}}</li>
        @else
            <li>Link :{{$meeting_data->link_id}}</li>
            <li>Password :{{$meeting_data->password}}</li>
        @endif
    </ul>
</div>
<div style="margin-left: 20px;">
    Invited By,<br>
    <strong>{{$meeting_data->emp->name}}</strong>
</div>
</body>
</html>
