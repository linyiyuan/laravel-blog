@extends('common.common')

@section('title')
   修改个人简介
@stop

@section('style')

@stop


@section('content')
<div class="tpl-content-page-title">
               修改个人简介
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/site_manage/about_me') }}">个人简介</a></li>
    <li class="am-active">
        修改个人简介
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                修改个人简介
        </div>
        <div class="tpl-portlet-input tpl-fz-ml">
            <div class="portlet-input input-small input-inline">
                <div class="input-icon right">
                    <i class="am-icon-search"></i>
                    <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
            </div>
        </div>
    </div>
    <div class="tpl-block">
        <div class="am-g">
            <div class="tpl-form-body tpl-form-line">
                <form class="am-form tpl-form-line-form" method="post" action="{{ url('admin/site_manage/about_me').'/'.$data->id }}">
                        {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">网名<span class="tpl-form-line-small-title">Role</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="user-screen_names" placeholder="请输入角色名" name="screen_names" value="{{ $data->screen_names?    $data->screen_names:''}}" >
                                <small>请填写角色名文字8-10左右。</small>
                            </div>
                        </div>
                    
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">职业 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" placeholder="请输入角色展示名称" name="profession" value="{{ $data->profession?$data->profession:''}}" >
                                <small>请填写职业</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">微信 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" placeholder="请输入角色展示名称" name="weixi" value="{{ $data->weixi?$data->weixi:''}}" >
                                <small>请填写微信</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">邮箱 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" placeholder="请输入角色展示名称" name="email" value="{{ $data->email?$data->email:''}}" >
                                <small>请填写邮箱</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">QQ <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="text" placeholder="请输入角色展示名称" name="qq" value="{{ $data->qq?$data->qq:''}}" >
                                <small>请填写QQ</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">个人介绍<span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                 <textarea style="backgroud:black" class="" id="editor" name="introduce"></textarea>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/site_manage/about_me')}}">返回</a>
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('ueditor/ueditor.config.js') }}" /></script>
<script type="text/javascript" src="{{ asset('ueditor/_examples/editor_api.js') }}" /></script> 
<script>
var editor = UE.getEditor('editor',{    
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个    
            //focus时自动清空初始化时的内容    
            autoClearinitialContent:true,    
            //关闭字数统计    
            wordCount:true,    
            //关闭elementPath    
            elementPathEnabled:false,    
            //默认的编辑区域高度    
            initialFrameHeight:400,  
            //更多其他参数，请参考ueditor.config.js中的配置项    
            
        }); 

editor.ready(function() {
        //设置编辑器的内容
        editor.setContent('{!! $data->introduce !!}');
      
});


</script>
@stop