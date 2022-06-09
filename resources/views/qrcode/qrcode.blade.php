<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <img style="width: 3cm; height:3cm" src="data:image/png;base64, {!! $qrcode !!}"><br>
    <p style="font-size: 12px; margin-top:1px;text-align:center">Kode : {{$id}}</p>

</body>
</html>