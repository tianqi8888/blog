<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Org\code\Code;
use Gregwar\captcha\CaptchaBuilder;
use Gregwar\captcha\phraseBuilder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页
    public function login(){
        return view('admin.login');
    }

    //验证码(自定义验证码类库)
    public function code(){
        $code = new Code();
        return $code->make();
    }

    //验证码生成(第三方组件)
    public function captcha($tmp){
        $phrase = new PhraseBuilder();
        //设置验证码位数
        $code = $phrase->build(4);
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code,$phrase);
        //设置背景色
        $builder->setBackgroundColor(220,210,230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        //可以设置图片宽高及字体
        $builder->build($width=100,$height=50,$font=null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        \Session::flash('code',$phrase);
        //生成图片
        header('Cache-Control:no-cache,must-revalidate');
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    //处理用户登录
    public function doLogin($request){
        $input = $request->except('_token');
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];
        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是字母、数字、破折号（ - ）以及下划线（ _ ）'
        ];
        $validator = Validator::make($input, $rule,$msg);
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors','验证码错误');
        }
        $user = User::where('user_name',$input['username'])->first();
        if(!$user){
            return redirect('admin/login')->with('errors','用户名为空');
        }
        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码不正确');
        }
        session()->put('user',$user);
        return redirect('admin/index');
    }

    public function jiami(){
        //1.md5+盐 32位
        /*$str = 'salt'.'123456';
        return md5($str);*/
        //2.哈希加密 65位
        /*$str = '123456';
        //return Hash::make($str);
        //校验
        $hash = Hash::make($str);
        if(Hash::check($str,$hash)){
            return "密码正确";
        }else{
            return "密码错误";
        }*/
        //3.crypt加密 255位
        $str = "123456";
        $cryptStr = Crypt::encrypt($str);
        //eyJpdiI6ImJrNWRMa3hEa2I2XC9KcEZoMFV3RGtBPT0iLCJ2YWx1ZSI6InVIcWdwRjVrTlBLelRadUNja0RGUEE9PSIsIm1hYyI6IjQwOGI3YjUzN2JiM2Q1MGJjMmNiODg1OTJiZDZkZmE1ZWY4OGJjNzc2MTAyZTVhODcxM2VkYTQ3NWMzYmI0NGUifQ==
        //return $cryptStr;
        if(Crypt::decrypt($cryptStr) == $str){
            return "密码正确";
        }else{
            return "密码错误";
        }
    }

    //后台首页
    public function index(){
        return view('admin.index');
    }

    //欢迎页
    public function welcome(){
        return view('admin.welcome');
    }
}
