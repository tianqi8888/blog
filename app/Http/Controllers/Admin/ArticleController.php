<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //缩略图上传
    public function upload(Request $request){
        $file = $request->file('photo');
        if(!$file->isValid()){
            return \response()->json(['ServerNo'=>'400','ResultData'=>'无效的文件上传']);
        }
        //获取源文件的扩展名
        $ext = $file->getClientOriginalExtension();
        //新文件名
        $newfile = md5(time().rand(1000,9999).'.'.$ext);
        //文件上传的到指定路径
        $path = public_path('uploads');
        //把文件从临时目录移动到制定目录
        $path = $file->move($path,$newfile);
        if(!$file->move($path,$newfile)){
            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
        }
        return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
    }
    //文章列表
    public function index()
    {
        return view('admin.article.list');
    }

    //文章添加页
    public function create()
    {
        $cates = (new Cate)->tree();
        return view('admin.article.add',compact('cates'));
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
