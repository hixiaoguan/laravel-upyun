<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>又拍云-UEditor</title>
    <script type='text/javascript' src='/UEditor/ueditor.config.js'></script>
    <script type='text/javascript' src='/UEditor/ueditor.all.js'></script>
</head>
<body>
<form action="/upueditorAction" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <h2>又拍云UEditor上传</h2>
    <input type="text" name="title"/><br/><br/>
    <input type="file" name="myfile[]" multiple/><br/><br/>
    <textarea name="后台取值的key" id="myEditor">这里写你的初始化内容</textarea>
    <script type='text/javascript'>
        var editor = new UE.ui.Editor();
        editor.render('myEditor');
    </script>
    <input type="submit"/>
</form>

</body>
</html>