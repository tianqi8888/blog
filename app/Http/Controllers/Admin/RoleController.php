<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    //授权页
    public function auth($id){
        //获取当前角色
        $role = Role::find($id);
        //获取所有的权限列表
        $perms = Permission::get();
        //获取当前角色拥有的权限
        $own_perms = $role->permission;
        //角色拥有的权限id
        $own_pers = [];
        foreach($own_perms as $v){
            $own_pers[] = $v->id;
        }
        return view('admin.role.auth',compact('role','perms','own_pers'));
    }

    //处理授权
    public function doauth(Request $request){
        $input = $request->except('_token');
        //删除当前角色已有的权限
        \DB::table('role_permission')->where('role_id',$input['role_id'])->delete();
        //添加新授予的权限
        if(!empty($input['permission_id'])){
            foreach($input['permission_id'] as $v){
                \DB::table('role_permission')->insert(['role_id'=>$input['role_id'],'permission_id'=>$v]);
            }
        }
        return redirect('admin/role');
    }

    //角色列表
    public function index(Request $request)
    {
        $role = Role::orderBy('id','desc')->where(function($query) use($request){
            $role_name = $request->input('role_name');
            if(!empty($role_name)){
                $query->where('role_name','like','%'.$role_name.'%');
            }
        })
        ->paginate($request->input('num') ? $request->input('num') : 3);
        return view('admin.role.list',compact('role','request'));
    }

    //添加角色
    public function create()
    {
        return view('admin.role.add');
    }

    //添加角色操作
    public function store(Request $request)
    {
        $input = $request->except('_token');
        //dd($input);
        $res = Role::create($input);
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

    }

    //用户修改页面
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin/role/edit',compact('role'));
    }

    //编辑操作
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $roleName = $request->input('role_name');
        $role->role_name = $roleName;
        $res = $role->save();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }

    //删除操作
    public function destroy($id)
    {
        $role = Role::find($id);
        $res = $role->delete();
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

    //批量删除
    public function delAll(Request $request){
        $input = $request->input('ids');
        $res = Role::destroy($input);
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
