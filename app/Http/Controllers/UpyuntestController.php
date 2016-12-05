<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Upload\ImgController;//使用统一上传接口

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UpyuntestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        echo 123456;
//
//        echo ($imgController);

        return view('upyuntest');

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
    public function store(Request $request,ImgController $imgController)
    {
        //


        //判断请求中是否包含name=file的上传文件
        if($request->hasFile('myfile')){
            $file = $imgController->uploadImg('thumbnail','/testxiaoguan',$request->all());
            dd($file);
        }

//        $file = $request->file('file');
//        //判断文件上传过程中是否出错
//        if(!$file->isValid()){
//            exit('文件上传出错！');
//        }
//        $destPath = realpath(public_path('images'));
//        if(!file_exists($destPath))
//            mkdir($destPath,0755,true);
//        $filename = $file->getClientOriginalName();
//        if(!$file->move($destPath,$filename)){
//            exit('保存文件失败！');
//        }
//        exit('文件上传成功！');

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
