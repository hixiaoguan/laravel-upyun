<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>单元测试</title>
</head>
<body>
<form action="/testAction" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <h2>单元测试</h2>
    <input type="file" name="myfile" multiple/><br/><br/>
    <input type="submit"/>
</form>

</body>
</html>