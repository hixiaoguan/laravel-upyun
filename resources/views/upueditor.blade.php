<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>又拍云-UEditor</title>
    <script type='text/javascript' src='/UEditor/ueditor.config.js'></script>
    <script type='text/javascript' src='/UEditor/ueditor.all.js'></script>
</head>
<body>
<form>
    {!! csrf_field() !!}
    <h2>又拍云UEditor上传</h2>
    <textarea name="upfile" id="myEditor">
    </textarea>
    <script type='text/javascript'>
        var editor = new UE.ui.Editor();
        editor.render('myEditor');
        editor.ready(function() {
            //这个地方很关键，CSRF不加的话会出现 500 报错
            editor.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
    <input type="submit"/>
</form>
</body>
</html>