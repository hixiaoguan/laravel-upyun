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
    //单图上传
	public function uploadImg($input_name,$path='',Request $request){
		$file='注意:图片仅支持jpg,png,gif格式';
		$path=$path?$path:'/';
        $suffix=$request->file($input_name)->getMimeType();
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
		if( $request->hasFile($input_name) && $request->file($input_name)->isValid() && $suffix != 'nopass' ){
			//$this->ratepic($_FILES[$input_name]['tmp_name']);
			$filename = Str::random(20).'.'.$suffix;
			$this->upyun->writeFile($path . $filename, file_get_contents($_FILES[$input_name]['tmp_name']));
			$file = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path . $filename;
		}
		return $file;
	}
    //多图上传
    public function uploadImgs($input_name,$path='',Request $request){
        $file='注意:图片仅支持jpg,png,gif格式';
        $path=$path?$path:'/';
        $suffix=$request->file($input_name)->getMimeType();
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
        if( $request->hasFile($input_name) && $request->file($input_name)->isValid() && $suffix != 'nopass' ){
            //$this->ratepic($_FILES[$input_name]['tmp_name']);
            $filename = Str::random(20).'.'.$suffix;
            $this->upyun->writeFile($path . $filename, file_get_contents($_FILES[$input_name]['tmp_name']));
            $file = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path . $filename;
        }
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
