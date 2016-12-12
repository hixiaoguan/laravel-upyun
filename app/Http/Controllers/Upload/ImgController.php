<?php

namespace App\Http\Controllers\Upload;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Libs\UpYun;


class ImgController extends Controller {
	public $upyun;
	public function __construct()
	{
		$this->upyun = new UpYun(env('UPYUN_BUCKETNAME'), env('UPYUN_USERNAME'), env('UPYUN_PASSWORD'));
	}
    //UEditor-上传处理 doupUEditor()--->02
    public function doupUEditor($input_name,$path,$request){

        $files=[];
        $path=$path?$path:'/';
        //获取文件类型
        function getSuffix($myfiles){
            $suffix=$myfiles->getClientOriginalExtension();
            switch ($suffix)
            {
                case 'png':
                    $suffix = 'png';
                    break;
                case 'jpg':
                    $suffix = 'jpg';
                    break;
                case 'jpeg':
                    $suffix = 'jpeg';
                    break;
                case 'gif':
                $suffix = 'gif';
                break;
                case 'pdf':
                    $suffix = 'pdf';
                    break;
                case 'doc':
                    $suffix = 'doc';
                    break;
                case 'docx':
                    $suffix = 'docx';
                    break;
                case 'xls':
                    $suffix = 'xls';
                    break;
                case 'xlsx':
                    $suffix = 'xlsx';
                    break;
                case 'ppt':
                    $suffix = 'ppt';
                    break;
                case 'pptx':
                $suffix = 'pptx';
                break;
                case 'mp4':
                    $suffix = 'mp4';
                    break;
                case 'zip':
                    $suffix = 'zip';
                    break;
                default:
                    $suffix = 'nopass';
            }
            return $suffix;
        }
        //获取上传文件数
        $myfiles = $request->file($input_name);

        if( $request->hasFile($input_name) && count($myfiles)>0 ){
            if(count($myfiles)>1){//多文件
                foreach($myfiles as $k=>$f){
                    $files[$k] = filesEach($myfiles,$k,$path);
                };
            }else{//单文件
                if(getSuffix($myfiles) == 'nopass'){
                    return '注意:图片仅支持jpg,png,gif格式';
                }
                $filename = Str::random(20).'.'.getSuffix($myfiles);
                $upy = new UpYun(env('UPYUN_BUCKETNAME'), env('UPYUN_USERNAME'), env('UPYUN_PASSWORD'));
                $upy->writeFile($path . $filename, file_get_contents($myfiles->getRealPath()));
                $files = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path . $filename;
                $info=array(
                    "state" => 'SUCCESS',
                    "url" => $files,
                    "title" => str_replace(".".getSuffix($myfiles),"",$myfiles->getClientOriginalName()),
                    "original" => str_replace(".".getSuffix($myfiles),"",$myfiles->getClientOriginalName()),
                    "type" => getSuffix($myfiles),
                    "size" => $myfiles->getClientSize()
                );
            }
        }
        return json_encode($info);
    }
    //UEditor-单图上传和多图上传通用--->01
    public function uploadUEditor($input_name,$path='',Request $request){
        $file = $this->doupUEditor($input_name,$path,$request);
        return $file;
    }
    //上传处理 doup()--->02
    public function doup($input_name,$path,$request){
        $files=[];
        $path=$path?$path:'/';
        //获取文件类型
        function getSuffix($myfiles){
            $suffix=$myfiles->getClientOriginalExtension();
            switch ($suffix)
            {
                case 'png':
                    $suffix = 'png';
                    break;
                case 'jpg':
                    $suffix = 'jpg';
                    break;
                case 'jpeg':
                    $suffix = 'jpeg';
                    break;
                case 'gif':
                    $suffix = 'gif';
                    break;
                default:
                    $suffix = 'nopass';
            }
            return $suffix;
        }
        //遍历上传文件
        function filesEach($myfiles,$k,$path){
            if(getSuffix($myfiles[$k]) == 'nopass'){
                return '注意:图片仅支持jpg,png,gif格式';
            }
            $filename = Str::random(20).'.'.getSuffix($myfiles[$k]);
            $upy = new UpYun(env('UPYUN_BUCKETNAME'), env('UPYUN_USERNAME'), env('UPYUN_PASSWORD'));
            $upy->writeFile($path . $filename, file_get_contents($myfiles[$k]->getRealPath()));
            $file = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path . $filename;
            return $file;
        }
        //获取上传文件数
        $myfiles = $request->file($input_name);
        if( $request->hasFile($input_name) && count($myfiles)>0 ){
            if(count($myfiles)>1){//多文件
                foreach($myfiles as $k=>$f){
                    $files[$k] = filesEach($myfiles,$k,$path);
                };
            }else{//单文件
                foreach($myfiles as $k=>$f){
                    $files[$k] = filesEach($myfiles,$k,$path);
                };
            }
        }
        return $files;
    }

    //单图上传和多图上传通用--->01
	public function uploadImg($input_name,$path='',Request $request){
        $file = $this->doup($input_name,$path,$request);
		return $file;
	}

    //又拍云 文件列表
    public function getUpFileList($path){
        $upy = new UpYun(env('UPYUN_BUCKETNAME'), env('UPYUN_USERNAME'), env('UPYUN_PASSWORD'));
        $upfilelist = $upy -> getList($path);
        return $upfilelist;
    }

    //又拍云 文件删除
    public function delFile($path){
        //return $path;
        $upy = new UpYun(env('UPYUN_BUCKETNAME'), env('UPYUN_USERNAME'), env('UPYUN_PASSWORD'));
        $delfile = $upy -> delete($path);
        //dd($delfile);
        return $delfile;
    }

}
