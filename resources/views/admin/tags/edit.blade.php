@extends('common.common')

@section('title')
    @if(isset($articleTags->id))
        修改文章标签
    @else
        添加文章标签
    @endif
@stop

@section('content')
<div class="tpl-content-page-title">
               @if(isset($articleTags->id))
                    修改文章标签
                @else
                    添加文章标签
                @endif
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/article_manage/tags') }}">文章标签管理</a></li>
    <li class="am-active">
        @if(isset($articleTags->id))
            修改文章标签
        @else
            添加文章标签
        @endif
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                @if(isset($articleTags->id))
                    修改文章标签
                @else
                    添加文章标签
                @endif
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
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($articleTags->id)?url('admin/article_manage/tags').'/'.$articleTags->id:url('admin/article_manage/tags') }}">
                        {{ csrf_field() }}
                        @if(isset($articleTags->id))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">文章标签名(唯一性)<span class="tpl-form-line-small-title">Type</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="user-name" placeholder="请输入文章标签名" name="tag_name" value="{{ $articleTags->tag_name?    $articleTags->tag_name:''}}" >
                                <small>请填写文章标签名文字8-10左右。</small>
                            </div>
                        </div>
                   
                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">文章标签描述</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="user-intro" placeholder="请输入文章标签描述" name="tag_desc">{{ $articleTags->tag_desc? $articleTags->tag_desc:''}}</textarea>
                            </div>
                        </div>
                       
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/article_manage/tags')}}">返回</a>
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@stop