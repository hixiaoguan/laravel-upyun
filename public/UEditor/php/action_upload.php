<?php
/**
 * 上传附件和上传视频
 * User: Jinqn
 * Date: 14-04-09
 * Time: 上午10:17
 */
include "Uploader.class.php";

/* 上传配置 */
$base64 = "upload";
switch (htmlspecialchars($_GET['action'])) {
    case 'uploadimage':
        include "upyun.class.php";
        //文章专用upyun空间
        $bucket='qdzufang';//upyun空间名
        $upyun_user='qdzufang';//操作员
        $upyun_psw='521my1!@#';//密码
        $upyun_path='/weixin/qdzufang/'.date("Ymd").'/';//上传路径
        if($bucket&&$upyun_user&&$upyun_psw){
//            $lns = count($_FILES['upfile']);
//            $ff = implode('|',$_FILES['upfile']);
//            echo "<script>console.log('".$ff."')</script>";
            $oldname=$_FILES[ "upfile" ]["name"];
            $filesize=$_FILES['upfile']['size'] ;
            $filepath = $_FILES[ "upfile" ][ 'tmp_name' ];
            $filetype = pathinfo($oldname, PATHINFO_EXTENSION);
            $newname='UE'.date("YmdHis").'.'.$filetype;
            $upyun = new UpYun($bucket, $upyun_user, $upyun_psw);
            //echo "<script>console.log('".$newname."')</script>";
            try {
                $fh = fopen($_FILES[ "upfile" ][ 'tmp_name' ], 'rb');
                $rsp = $upyun->writeFile($upyun_path.$newname, $fh, True);   // 上传图片，自动创建目录
                fclose($fh);
                $file = 'http://'.$bucket.'.b0.upaiyun.com'.$upyun_path.$newname;
                //echo "<script>console.log('".$file."')</script>";
                $info=array(
                    "state" => 'SUCCESS',
                    "url" => $file,
                    "title" => $newname,
                    "original" => str_replace(".".$filetype,"",$oldname),
                    "type" => $filetype,
                    "size" => $filesize
                );
                /* 返回数据 */
                return json_encode($info);
            }
            catch(Exception $e) {
                /* 返回数据 */
                return json_encode(array("state" => 'FALSE'));
            }
        }else {
            $config = array(
                "pathFormat" => $CONFIG['imagePathFormat'],
                "maxSize" => $CONFIG['imageMaxSize'],
                "allowFiles" => $CONFIG['imageAllowFiles']
            );
            $fieldName = $CONFIG['imageFieldName'];
        }
        break;
    case 'uploadscrawl':
        $config = array(
            "pathFormat" => $CONFIG['scrawlPathFormat'],
            "maxSize" => $CONFIG['scrawlMaxSize'],
            "allowFiles" => $CONFIG['scrawlAllowFiles'],
            "oriName" => "scrawl.png"
        );
        $fieldName = $CONFIG['scrawlFieldName'];
        $base64 = "base64";
        break;
    case 'uploadvideo':
        $config = array(
            "pathFormat" => $CONFIG['videoPathFormat'],
            "maxSize" => $CONFIG['videoMaxSize'],
            "allowFiles" => $CONFIG['videoAllowFiles']
        );
        $fieldName = $CONFIG['videoFieldName'];
        break;
    case 'uploadfile':
    default:
        $config = array(
            "pathFormat" => $CONFIG['filePathFormat'],
            "maxSize" => $CONFIG['fileMaxSize'],
            "allowFiles" => $CONFIG['fileAllowFiles']
        );
        $fieldName = $CONFIG['fileFieldName'];
        break;
}

/* 生成上传实例对象并完成上传 */
$up = new Uploader($fieldName, $config, $base64);

/**
 * 得到上传文件所对应的各个参数,数组结构
 * array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => ""            //文件类型
 *     "size" => "",           //文件大小
 * )
 */

/* 返回数据 */
return json_encode($up->getFileInfo());
