@extends('common.common')

@section('title')
个人简历
@stop

@section('content')
<div class="tpl-content-page-title">
    个人简历
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="">站点管理</li>
    <li class="am-active">个人简历</li>
</ol>

<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code">个人简历</span>
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
	                        <a href="{{ url('/admin/site_manage/resume/create')}}" class="am-btn am-btn-secondary ">编辑内容</a>
	                    </div>
	                </div>
	            </div>
	        </div>
        </form>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <img src="http://paan0ksle.bkt.clouddn.com/resume.jpg" alt="" width=700 height=1200>
                    <img src="http://paan0ksle.bkt.clouddn.com/resume1.jpg" alt="" width=700 height=1200>
                    <div class="am-cf">
                    </div>
                    <hr>

                </form>
            </div>
        </div>
    </div>
    <div class="tpl-alert"></div>
</div>

@stop


