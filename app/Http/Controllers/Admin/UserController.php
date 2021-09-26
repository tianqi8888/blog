<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    //给用户分配角色页
    public function role($id){
        //当前用户信息
        $user = User::find($id);
        //所有角色
        $roles = Role::get();
        //当前用户所属角色
        $own_roles = $user->roles;
        $ownRole = [];
        foreach($own_roles as $v){
            $ownRole[] = $v->id;
        }
        //dd($own_roles);
        return view('admin.user.roles',compact('user','roles','ownRole'));
    }

    //处理用户角色
    public function dorole(Request $request){
        $input = $request->except('_token');
        //删除当前用户已有的角色
        \DB::table('user_role')->where('user_id',$input['user_id'])->delete();
        //添加新授予的角色
        if(!empty($input['role_id'])){
            foreach($input['role_id'] as $v){
                \DB::table('user_role')->insert(['user_id'=>$input['user_id'],'role_id'=>$v]);
            }
        }
        return redirect('admin/user');
    }
    //获取用户列表
    public function index(Request $request)
    {
        //$input = $request->all();
        //dd($input);
        //$user = User::paginate(1);
        $user = User::orderBy('user_id','desc')->where(function($query) use($request){
            $username = $request->input('username');
            $email    = $request->input('email');
            if(!empty($username)){
                $query->where('user_name','like','%'.$username.'%');
            }
            if(!empty($email)){
                $query->where('email','like','%'.$email.'%');
            }
        })
        ->paginate($request->input('num') ? $request->input('num') : 3);
        return view('admin.user.list',compact('user','request'));
        //return view('admin.user.list',['user'=>$user]);
        //return view('admin.user.list')->with('user',$user);
    }

    //添加用户页面
    public function create()
    {
        return view('admin.user.add');
    }

    //添加用户操作
    public function store(Request $request)
    {
        $input = $request->all();
        //表单验证
        $username = $input['username'];
        $pass = Crypt::encrypt($input['pass']);
        $res = User::create(['user_name'=>$username,'user_pass'=>$pass,'email'=>$input['email']]);
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
        $user = User::find($id);
        return view('admin/user/edit',compact('user'));
    }

    //修改操作
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $username = $request->input('user_name');
        $user->user_name = $username;
        $res = $user->save();
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

    //删除操作
    public function destroy($id)
    {
        $user = User::find($id);
        $res = $user->delete();
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
        $res = User::destroy($input);
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
