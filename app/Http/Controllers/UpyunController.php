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
     * upimg 又拍云 单图上传 表单
     */
    public function upimg()
    {
        return view('upimg');
    }
    /**
     * upimg 又拍云 单图上传 处理
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
     * upimgs 又拍云 多图上传 表单
     */
    public function upimgs()
    {
        return view('upimgs');
    }
    /**
     * upimgs 又拍云 多图上传 处理
     */
    public function upimgsAction(Request $request,ImgController $imgController)
    {

        dd($request->myfiles);
        //判断请求中是否包含name=file的上传文件
        if($request->hasFile('myfiles')){
            $month = Carbon::now()->format('Ym');
            $file = $imgController->uploadImgs('myfiles','/weixin/qdzufang/'.$month.'/',$request);
            dd($file);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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