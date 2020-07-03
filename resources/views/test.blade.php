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
    <div class="container" style="display: flex;width: 70%;justify-content: space-between;flex-wrap: wrap">
        @foreach($manuf as $m)
            <div class="box" style="width: 25%;border: 1px solid black">
                <img style="width: 100%" src="/{{ $m->logo }}" alt="">
                <h4>{{ $m->name }}</h4>
            </div>
        @endforeach
    </div>
</body>
</html>