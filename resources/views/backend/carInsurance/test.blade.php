<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
{!! Form::open() !!}

{!! Form::label('name','用户名') !!}
{!! Form::text('name','',['class'=>'input-text']) !!}
{!! Form::close() !!}

</body>
</html>