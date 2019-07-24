@extends('common.common')

@section('title')
    @if(isset($links->id))
        修改友情链接
    @else
        添加友情链接
    @endif
@stop

@section('content')
<div class="tpl-content-page-title">
               @if(isset($links->id))
                    修改友情链接
                @else
                    添加友情链接
                @endif
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/links_manage/links') }}">友情链接管理</a></li>
    <li class="am-active">
        @if(isset($links->id))
            修改友情链接
        @else
            添加友情链接
        @endif
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                @if(isset($links->id))
                    修改友情链接
                @else
                    添加友情链接
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
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($links->id)?url('admin/links_manage/links').'/'.$links->id:url('admin/links_manage/links') }}"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if(isset($links->id))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">友情链接标题<span class="tpl-form-line-small-title">Title</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="title" placeholder="请输入友情链接标题" name="title" value="{{ $links->title?    $links->title:''}}" >
                                <small>请填写友情链接标题</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">友情链接<span class="tpl-form-line-small-title">Url</span></label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="sub_title" placeholder="请输入友情链接" name="url">{{ $links->url? $links->url:''}}</textarea>
                            </div>
                        </div>
                        <div class="am-form-group url">
                            <label for="user-name" class="am-u-sm-3 am-form-label">申请人邮箱<span class="tpl-form-line-small-title">Email</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="url" placeholder="请输入申请人邮箱" name="email" value="{{ $links->email?$links->email:''}}" >
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/links_manage/links')}}">返回</a>
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
<script>

</script>


@stop