<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload\ImgController;

class UpyunController extends Controller
{

    /**
     * upimg 又拍云 单图&多图上传 表单
     */
    public function upimg()
    {
        return view('upimg');
    }
    /**
     * upimg 又拍云 单图&多图上传 处理
     */
    public function upimgAction(Request $request,ImgController $imgController)
    {
        //判断请求中是否包含name=file的上传文件
        if($request->hasFile('myfile')){
            $month = Carbon::now()->format('Ym');
            $file = $imgController->uploadImg('myfile','/weixin/qdzufang/'.$month.'/',$request);
            dd($file);
        }

    }
    /**
     * upueditor UEditor图片&文件上传 表单
     */
    public function upueditor()
    {
        return view('upueditor');
    }
    /**
     * upueditor UEditor 又拍云 单图&多图上传 处理
     */
    public function upueditorAction(Request $request,ImgController $imgController)
    {
        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;
            /* 上传图片 */
            case 'uploadimage':
                //$myfiles = $request->file('upfile');
                //获取到提交过来的字段
                    if($request->hasFile('upfile')){
                        //$result=$myfiles->getClientOriginalName();
                        $month = Carbon::now()->format('Ym');
                        $file = $imgController->uploadUEditor('upfile','/weixin/qdzufang/'.$month.'/',$request);
                        //return $file;
                    }
                    $result = $file;
                break;
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                if($request->hasFile('upfile')){
                    //$result=$myfiles->getClientOriginalName();
                    $month = Carbon::now()->format('Ym');
                    $file = $imgController->uploadUEditor('upfile','/weixin/qdzufang/'.$month.'/',$request);
                    //return $file;
                }
                $result = $file;
                break;
            /* 列出图片 */
            case 'listimage':
                //$result = 'listimage';
                $result = include("action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include("action_list.php");
                break;
            /* 抓取远程文件 */
            case 'catchimage':
                $result = include("action_crawler.php");
                break;
            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            if(is_array($result)){
                dump($result);
            }else{
                echo $result;
            }
        }
    }

    //又拍云文件列表
    public function upfilelist(ImgController $imgController){
        $month = Carbon::now()->format('Ym');
        $path = '/weixin/qdzufang/'.$month.'/';
        $filelist = $imgController->getUpFileList($path);
        $pathstr = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path;
        //return $upfilelist;
        //dd($filelist);
        return view('upfilelist',compact('filelist','pathstr'));
    }

    //又拍云文件删除
    public function upfiledel(ImgController $imgController){
        $month = Carbon::now()->format('Ym');
        $path = '/weixin/qdzufang/'.$month.'/';
        $filelist = $imgController->getUpFileList($path);
        $pathstr = 'http://'.env('UPYUN_BUCKETNAME').'.b0.upaiyun.com'.$path;
        return view('upfilelistdel',compact('filelist','pathstr'));
    }
    //又拍云文件删除Action
    public function upfiledelAction(ImgController $imgController){
        //dd('del',$request->get('delfile'));
        $delres = $imgController->delFile('/weixin/');
        dd($delres);
    }
    public function test()
    {
        return view('test');
    }
    public function testAction(Request $request)
    {
        //dd($request->file('myfile'));
        dd($request->file('myfile')->getClientOriginalExtension());
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
