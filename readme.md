## Laravel5.1.* LTS-upyun PHP Framework

upyun for laravel5 GIT: https://github.com/hixiaoguan/upyun_laravel.git

一、修改composer.json文件 在autoload-dev的classmap中添加app/Libs/Upyun.php，如下：

"autoload-dev": {
    "classmap": [
        "tests/TestCase.php",
        "app/Libs/Upyun.php"
    ]
},
二、在app目录下添加Libs文件夹，下载Upyun.php文件放到该文件夹下

三、执行php composer.phar install , 或者composer install

四、下载ImgController.php并放到app/Http/Controllers/Upload/目录下，参考ImgController.php写上传文件接口

五、在.env文件增加又拍云文件配置

UPYUN_BUCKETNAME=又拍云空间名，在又拍云后台管理中添加

UPYUN_USERNAME=空间的授权用户名

UPYUN_PASSWORD=授权用户密码
六、上传示例

use Illuminate\Http\Request;
use App\Http\Controllers\Upload\ImgController;//使用统一上传接口
/*
*保存数据，需要验证提交数据是否正确，有图片上传则调用统一上传接口上传文件
*thumbnail是input file控件名称，假设也是数据库字段名称
*/
public function store(Request $request,ImgController $imgController){
    $data = array(
        /*
        需要保存的数据
        */
    );
    $file = $imgController->uploadImg('thumbnail','',$request);
    if($file){
        $data['thumbnail'] = $file;
    }
    /*

    业务逻辑代码，如保存$data到表

    */
}
public function update(Request $request,ImgController $imgController)
{
    $id = intval($InfoRequest->input('id'));
    $info = Info::find($id);//从表中取出原数据
    $data = array(
        /*
        需要更新的数据
        */
    );
    $file = $imgController->uploadImg('thumbnail','',$request);
    if($file){//如果上传新图片成功，保存新数据
        $data['thumbnail'] = $file;
        if($info->thumbnail){//原数据中存在图片，则删除原数据图片
            $imgController->unlinkfile($info->thumbnail);
        }
    }
    /*

    业务逻辑代码，如更新$data到表

    */
}