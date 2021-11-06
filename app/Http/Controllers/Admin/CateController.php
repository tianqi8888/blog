<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    //修改排序
    public function changeOrder(Request $request){
        $input = $request->except('_token');
        $cate = Cate::find($input['cate_id']);
        $res = $cate->update(['cate_order'=>$input['order_id']]);
        if($res){
            $data = [
                'status'=>0,
                'message'=>'排序成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'排序失败'
            ];
        }
        return $data;
    }

    //分类列表
    public function index(Request $request)
    {
        $cates = (new Cate())->tree($request);
        //dd($cates);
        return view('admin/cate/list',compact('cates','request'));
    }

    //分类添加页面
    public function create()
    {
        //获取一级类
        $cate = Cate::where('cate_pid',0)->get();
        return view('admin.cate.add',compact('cate'));
    }

    //分类添加操作
    public function store(Request $request)
    {
        $input = $request->except("_token");
        $res = Cate::create($input);
        if($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        return $data;
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
