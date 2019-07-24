@extends('common.common')


@section('title')
	操作日志
@stop

@section('content')
<div class="tpl-content-page-title">
                操作日志
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">操作日志</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 操作日志
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
        <div class="am-g" style="margin-bottom: 20px;">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{ url('/admin/system_config/operation_log') }}"><span class="label label-sm label-default">全部记录</span></a>
                    	<a href="{{ url('/admin/system_config/operation_log?operate=2') }}"><span class="label label-sm label-success">增加操作</span></a>
                    	<a href="{{ url('/admin/system_config/operation_log?operate=3') }}"><span class="label label-sm label-warning">修改操作</span></a>
                    	<a href="{{ url('/admin/system_config/operation_log?operate=4') }}"><span class="label label-sm label-danger">删除操作</span></a>
                    	<a href="{{ url('/admin/system_config/operation_log?operate=1') }}"><span class="label label-sm label-info">登录操作</span></a>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <form action="">
                <div class="am-input-group am-input-group-sm">
                    <input type="text" class="am-form-field" placeholder="请输入你要查询的操作记录" data-am-datepicker readonly required>
                    <span class="am-input-group-btn">
                        <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
                    </span>
                </div>
                </form>
            </div>
        </div>

        <ul class="tpl-task-list tpl-task-remind">
        	@foreach($list as $k => $v)
	            <li>
	                <div class="cosB" style="width:120px">
	                    {{ date('Y-m-d',strtotime($v->created_at)) 	}}
	                </div>
	                <div class="cosA">
	                	@if($v->operate == 1)
	                    	<span class="cosIco label-info">
           						 <i class="am-icon-bolt"></i>
           					</span>
	                    @elseif($v->operate == 4)
                   			<span class="cosIco label-danger">
                   				<i class="am-icon-minus"></i>
         		    		</span>
	                    @elseif($v->operate == 3)
								<span class="cosIco label-warning">
		           				    <i class="am-icon-edit"></i>
		         		       </span>
	                    @elseif($v->operate == 2)
							<span class="cosIco label-success">
	           				  <i class="am-icon-plus"></i>
	         		   		</span>
	                    @endif
	                    <span>{{ $v->detail }}</span>
	                    @if($v->operate == 1)
	                    	<span class="label label-sm label-info">登录操作</span>
	                    @elseif($v->operate == 4)
                   			<span class="label label-sm label-danger">删除操作</span>
	                    @elseif($v->operate == 3)
							<span class="label label-sm label-warning">修改操作</span>
	                    @elseif($v->operate == 2)
							<span class="label label-sm label-success">增加操作</span>
	                    @endif
	                </div>
	            </li>
	        @endforeach
        </ul>
    </div>
    <div class="am-cf">
                        <div class="am-fr">
                                {{ $list->appends($search)->links() }}
                        </div>
    </div>

</div>

@stop