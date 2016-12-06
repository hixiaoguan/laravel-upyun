<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>又拍云-单图上传</title>
</head>
<body>
<form action="/upimgAction" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <h2>又拍云单图上传</h2>
    <input type="text" name="title"/><br/><br/>
    <input type="file" name="myfile"/><br/><br/>
    <input type="submit"/>
</form>

</body>
</html>