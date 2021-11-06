<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>文章添加-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
      @include('admin.public.style')
      @include('admin.public.script')
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form" id="art_form" enctype="multipart/form-data">
            <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">
                    <span class="x-red">*</span>分类
                </label>
                <div class="layui-input-inline">
                    <select name="cate_pid" lay-verify="required">
                        @foreach($cates as $v)
                            <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="art_title" class="layui-form-label">
                    <span class="x-red">*</span>文章标题
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="art_title" name="art_title" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
               <label for="art_editor" class="layui-form-label">
                   <span class="x-red">*</span>编辑
               </label>
               <div class="layui-input-inline">
                  <input type="text" id="art_editor" name="art_editor" class="layui-input">
               </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="layui-form-label">缩略图</label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="art_thumb" value="">
                    <button type="button" class="layui-btn" id="test1"><i class="layui-icon"></i>上传图片</button>
                    <input type="file" id="photo_upload" name="photo" class="layui-input" style="display:none;">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label for="" class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img src="" alt="" id="art_thumb_img" style="">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="art_tag" class="layui-form-label">
                    <span class="x-red">*</span>关键词
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="art_tag" name="art_description" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" name="art_description" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">
                </label>
                <button  class="layui-btn" lay-filter="add" lay-submit="">
                   增加
                </button>
            </div>
        </form>
    </div>
    <script>
        $("#test1").on('click',function(){
            $("#photo_upload").trigger('click');
            $("#photo_upload").on('change',function(){
                var obj = this;
                var formData = new FormData($('#art_form')[0]);
                $.ajax({
                    url:'/admin/article/upload',
                    type:'post',
                    data:formData,
                    //因为data值是FormData对象，不需要对数据做处理
                    processData:false,
                    contentType:false,
                    success:function(data){
                        if(data['ServerNo'] == '200'){
                            $("#art_thumb_img").attr('src','/uploads/'+data['ResultData']);
                            $("input[name='art_thumb']").val(data);
                            $(obj).off('change');
                        }else{
                            alert(data['ResultData']);
                        }
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                        var number = XMLHttpRequest.status;
                        var info = '错误号'+number+'文件上传失败！';
                        alert(info);
                    },
                    async:true
                });
            })
        })
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
        
          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,repass: function(value){
                if($('#L_pass').val()!=$('#L_repass').val()){
                    return '两次密码不一致';
                }
            }
          });

          //监听提交
          form.on('submit(add)', function(data){
            //发异步，把数据提交给php
            $.ajax({
                type:'POST',
                url:'/admin/user',
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                data:data.field,
                success:function(data){
                    if(data.status == 0){
                        layer.alert(data.message,{icon:6},function(){
                            parent.location.reload(true);
                        })
                    }else{
                        layer.alert(data.message,{icon:5});
                    }
                },
                error:function(){

                }
            })
            layer.alert("增加成功", {icon: 6},function () {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                //关闭当前frame
                parent.layer.close(index);
            });
            return false;
          });
          
          
        });

    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>