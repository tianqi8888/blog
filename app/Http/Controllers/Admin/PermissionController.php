<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    //权限列表
    public function index(Request $request)
    {
        $permission = Permission::orderBy('id','desc')->where(function($query) use($request){
            $per_name = $request->input('per_name');
            if(!empty($per_name)){
                $query->where('per_name','like','%'.$per_name.'%');
            }
        })
            ->paginate($request->input('num') ? $request->input('num') : 3);
        return view('admin.permission.list',compact('permission','request'));
    }

    //权限添加页
    public function create()
    {
        return view('admin.permission.add');
    }

    //权限添加操作
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $res = Permission::create($input);
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

    //详情
    public function show($id)
    {
        //
    }

    //编辑页
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('admin/permission/edit',compact('permission'));
    }

    //编辑操作
    public function update(Request $request, $id)
    {
        $perm = Permission::find($id);
        $perm->per_name = $request->input('per_name');
        $perm->per_url = $request->input('per_url');
        $res = $perm->save();
        if($res){
            $data = [
                'message'=>'修改成功',
                'status'=>0
            ];
        }else{
            $data = [
                'message'=>'修改失败',
                'status'=>1
            ];
        }
        return $data;
    }

    //删除权限
    public function destroy($id)
    {
        $perm = Permission::find($id);
        $res = $perm->delete();
        if($res){
            $data = [
                'message'=>'删除成功',
                'status'=>0
            ];
        }else{
            $data = [
                'message'=>'删除失败',
                'status'=>1
            ];
        }
        return $data;
    }

    //批量删除权限
    public function delAll(Request $request){
        $input = $request->input('ids');
        $res = Permission::destroy($input);
        if($res){
            $data = [
                'message'=>'删除成功',
                'status'=>0
            ];
        }else{
            $data = [
                'message'=>'删除失败',
                'status'=>1
            ];
        }
        return $data;
    }
}
