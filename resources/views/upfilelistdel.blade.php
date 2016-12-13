<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>又拍云-文件列表</title>
</head>
<body>

<h2>文件列表</h2>
<ul>
    @foreach ($filelist as $list)
        @if (strpos($list['name'],'.jpg') == false && strpos($list['name'],'.jpeg') == false && strpos($list['name'],'.png') == false && strpos($list['name'],'.gif') == false)
        @else
        <li>
            <a href="{!! $pathstr !!}{!! $path !!}{!!$list['name']!!}" target="_blank"><img src="{!! $pathstr !!}{!! $path !!}{!!$list['name']!!}" width="150" /></a>
            <a href="/upfiledelAction?delfile={!! $path !!}{!!$list['name']!!}">X</a>
        </li>
        @endif
    @endforeach
</ul>

</body>
</html>