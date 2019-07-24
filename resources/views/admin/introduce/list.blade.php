@extends('common.common')

@section('title')


@stop

@section('content')
<div class="tpl-content-page-title">
    个人简介
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">个人简介</li>
</ol>

<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code">个人简介</span>
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
    	<form action="{{ url('/admin/user_manage/role') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/site_manage/about_me/1/edit')}}" class="am-btn am-btn-secondary ">编辑内容</a>
	                    </div>
	                </div>
	            </div>
	        </div>
        </form>
        <div class="am-g">
            	{!! $content->introduce !!}
        </div>
    </div>
    <div class="tpl-alert"></div>
</div>

@stop


