<!DOCTYPE html>
<html>
<head>
    <title>Laravel Mail</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <h4>{{ $data['sayHello'] }}</h4>
    <p>{{ $data['body'] }}</p>
    <p>
        <a href="{{route('filament.admin.auth.login')}}">
                Login Here
        </a>
    </p>
    <p>Thank you</p>
</body>
</html>
