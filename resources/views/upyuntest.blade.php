<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>upyun uploadimg</title>
</head>
<body>
<form action="/upyunimgupload" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="text" name="title"/>
    <input type="file" name="myfile"/>
    <input type="submit"/>
</form>

</body>
</html>