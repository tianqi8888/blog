<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    public $table = 'category';
    public $primaryKey = 'cate_id';
    public $guarded = [];
    public $timestamps = false;
    //格式化分类数据
    public function tree(){
        //获取所有的分类数据
        $cates = $this->orderBy('cate_id','asc')->get();
        //格式化（排序、二级类缩进）
        return $this->getTree($cates);
    }

    public function getTree($category){
        $arr = [];
        foreach($category as $k=>$v){
            if($v->cate_pid == 0){
                //获取一级类
                $arr[] = $v;
                //获取一级类下的二级类
                foreach($category as $m=>$n){
                    if($v->cate_id == $n->cate_pid){
                        //添加缩进
                        $n->cate_name = '|--'.$n->cate_name;
                        $arr[] = $n;
                    }
                }
            }
        }
        return $arr;
    }
}
