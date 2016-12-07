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

	/**
	 * simditor编辑器上传
	 */
	public function upload(Request $request)
	{
		$data = [
			'success' => false,
			'msg' => 'Failed!',
			'file_path' => ''
		];
		if ($file = $request->file('simditor_upload_img')) {
			$this->ratepic($_FILES['simditor_upload_img']['tmp_name']);
			$filename = Str::random(20) . '.jpg';
			$this->upyun->writeFile('/' . $filename, file_get_contents($_FILES['simditor_upload_img']['tmp_name']));

			$data = [
				'success'=>true,
				'msg'=>'上传成功',
				'file_path'=>'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com/' . $filename,
			];

		}
		return $data;
	}

	/**
	 * wangeditor编辑器上传
	 */
	public function upload2(Request $request)
	{
		$data = [
			'success' => false,
			'msg' => 'Failed!',
			'file_path' => ''
		];
		if ($file = $request->file('wangEditorH5File')) {
			$filename = Str::random(20) . '.jpg';
			$this->upyun->writeFile('/' . $filename, file_get_contents($_FILES['wangEditorH5File']['tmp_name']));

			$data = [
				'success'=>true,
				'msg'=>'上传成功',
				'file_path'=>'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com/' . $filename,
			];

		}
		return $data['file_path'];
	}
    /**
     * 上传处理 doup()
     */
    public function doup($input_name,$path,$request){
        $files=[];
        $path=$path?$path:'/';
        //检查是否有上传的文件
        //dd($request->hasFile($input_name));
        //获取文件类型
        function getSuffix($myfiles){
            $suffix=$myfiles->getMimeType();
            switch ($suffix)
            {
                case 'image/png':
                    $suffix = 'png';
                    break;
                case 'image/jpeg':
                    $suffix = 'jpg';
                    break;
                case 'image/gif':
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

    //单图上传和多图上传通用
	public function uploadImg($input_name,$path='',Request $request){
        $file = $this->doup($input_name,$path,$request);
		return $file;
	}
	public function unlinkfile($file){
		$file =  str_replace('http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com','',$file);
		if(file_exists($file)){
			@unlink($file);
		}
	}
	private function ratepic($tmp_name=''){
		$exif_info = exif_read_data($tmp_name);
		if(!empty($exif_info['Orientation'])) {
			$source = imagecreatefromjpeg($tmp_name);
			$image='';
			switch($exif_info['Orientation']) {
				case 8:
					$image = imagerotate($source,90,0);
					break;
				case 3:
					$image = imagerotate($source,180,0);
					break;
				case 6:
					$image = imagerotate($source,-90,0);
					break;
			}
			if($image) {
				imagejpeg($image, $tmp_name);
				imagedestroy($source);
			}
		}
	}
}
