@extends('common.common')

@section('title')
   更新/上传个人简历
@stop

@section('style')

@stop

@section('content')
<div class="tpl-content-page-title">
               更新/上传个人简历
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/site_manage/resume') }}">个人简介</a></li>
    <li class="am-active">
        更新/上传个人简历
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                更新/上传个人简历
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
               <form class="am-form tpl-form-line-form" method="post" action="{{ url('/admin/site_manage/resume') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                       <div class="am-form-group">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">个人简历 <span class="tpl-form-line-small-title">请上传Word类型文件</span></label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-file">
                                    <div class="tpl-form-file-img">
                                    </div>
                                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                      <input class="doc-form-file" type="file" multiple name="word">
                                </div>
                                <div class="file-list">
                                 
                                </div>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/site_manage/resume')}}">返回</a>
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@stop