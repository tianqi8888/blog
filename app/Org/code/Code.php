<?php
/**
 * Created by project
 * User : tianqi
 * Date : 2021/9/16
 * Time : 16:54
 */

namespace App\Org\code;
use Session;

class Code
{
    //资源
    private $img;
    //画布宽度
    private $width = 100;
    //画布高度
    private $height = 30;
    //背景颜色
    private $bgColor = '#ffffff';
    //验证码
    private $code;
    //验证码的随机种子
    private $codeStr = '23456789abcdefghjkmnpqrstuvwsyz';
    //验证码长度
    private $codeLen = 4;
    //验证码字体
    private $font;
    //验证码字体大小
    private $fontSize = 16;
    //验证码字体颜色
    private $fontColor = '';
    public function __construct(){

    }
    //创建验证码
    public function make(){
        if(empty($this->font)){
            $this->font = __DIR__.'consola.ttf';
        }
        $this->create();//生成验证码
        header("Content-type:image/png");
        imagepng($this->img);
        imagedestroy($this->img);
        //exit();
    }

    //设置字体文件
    public function font($font){
        $this->font = $font;
        return $this;
    }

    //设置文字尺寸
    public function fontSize($fontSize){
        $this->fontSize = $fontSize;
        return $this;
    }
    //设置字体颜色
    public function fontColor($fontColor){
        $this->fontColor = $fontColor;
        return $this;
    }
    //验证码数量
    public function num($num){
        $this->codeLen = $num;
        return $this;
    }
    //设置宽度
    public function width($width){
        $this->width = $width;
        return $width;
    }
    //设置高度
    public function height($height){
        $this->height = $height;
    }
    //设置背景颜色
    public function background($color){
        $this->bgColor = $color;
        return $this;
    }
    //返回验证码
    public function get(){
        return session('code');
    }
    //生成验证码
    private function createCode(){
        $code = '';
        for($i = 0;$i < $this->codeLen;$i++){
            $code .= $this->codeStr[mt_rand(0,strlen($this->codeStr) - 1)];
        }
        $this->code = strtoupper($code);
        Session::put('code',$this->code);
    }
    //建画布
    private function create()
    {
        if (!$this->checkGD())
            return false;
        $w = $this->width;
        $h = $this->height;
        $bgColor = imagecreatetruecolor($w, $h);
        $bgColor = imagecolorallocate($img, hexdec(substr($bgColor, 1, 2)), hexdec(substr($bgColor, 3, 2)), hexdec(substr($bgColor, 5, 2)));
        imagefill($img, 0, 0, $bgColor);
        $this->img = $img;
        $this->createLine();
        $this->createFont();
        $this->createPix();
        $this->createRec();
    }

    //画线
    private function createLine(){

    }
}