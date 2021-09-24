<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
Dear,{{$clientname}}<br>
    <div style="border: solid;margin: auto;text-align: center;padding-bottom: 20px;border-radius:10px;background-color: #e9e9e9">
        You are allowed to login. Login using the following email address and password, then <strong style="color: red">do not forget to change your password</strong>.<br><br>
        Email: <strong>{{$email}}</strong><br><br>
        Password: <strong id="pass">{{$password}}</strong><br><br>
        <a href="{{url('login')}}">Go to login page <i class="fa fa-arrow"></i> </a>
    </div>

</body>
</html>