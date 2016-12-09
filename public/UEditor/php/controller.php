<?php

//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;
    case 'uploadimage':
        use Illuminate\Http\Request;
        use App\Http\Requests;
        $result = json_encode(array(
            'file'=> $req->upfile
        ));
        break;
   default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

echo $result;
/* 输出结果 */
//if (isset($_GET["callback"])) {
//    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
//        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
//    } else {
//        echo json_encode(array(
//            'state'=> 'callback参数不合法'
//        ));
//    }
//} else {
//    echo $result;
//}