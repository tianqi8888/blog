<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*//获取当前请求的路由 对应的控制器方法名
        $route = \Route::current()->getActionName();
        //获取当前用户权限组 用户找角色 角色找权限
        $user = User::find(session()->get('user')->user_id);
        //当前用户角色组
        $user_own_roles = $user->roles;
        //存放权限对应的per_url
        $arr = [];
        foreach($user_own_roles as $v){
            $perms = $v->permission;
            foreach($perms as $perm){
                $arr[] = $perm->per_url;
            }
        }
        //去重
        $arr = array_unique($arr);
        dd($route,$arr);
        //判断当前请求的路由是否在权限数组中  优化：权限组应该在用户登录时放入session中此处直接从session中取
        if(in_array($route,$arr)){
            return $next($request);
        }else{
            return redirect('noaccess');
        }*/
        return $next($request);
    }
}
