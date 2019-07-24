@extends('common.common')

@section('title')
	游客列表
@stop

@section('content')
<div class="tpl-content-page-title">
    游客列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">游客列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 游客列表
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
    	<form action="{{ url('/admin/user_manage/user/') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-form-group">
                    </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-form-group">
	                    <select data-am-selected="{btnSize: 'sm'}" name="role">
			              <option value="-1">请选择角色</option>
						</select>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="username" placeholder="请输入你要查询的用户名" value="{{ Request::get('username')?Request::get('username'):''}}"> 
	                    <span class="am-input-group-btn">
				            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
				         </span>
	                </div>
	            </div>
	        </div>
        </form>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                            <tr>
                                <th class="table-id">ID</th>
                                <th class="table-id">头像</th>
                                <th class="table-title">用户名</th>
                                <th class="table-type">手机号</th>
                                <th class="table-author am-hide-sm-only">邮箱</th>
                                <th class="table-author am-hide-sm-only">上次登录ip</th>
                                <th class="table-author am-hide-sm-only">上次登录时间</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($list as $k => $v)
	                            <tr>
                                    <td>{{ $v['id'] }}</td>
	                                <td><img src="{{ $v['img'] }}" alt="" style="width:50px;height:50px"></td>
                                    <td>{{ $v['username']}}</td>
	                                <td>{{ $v['phone']}}</td>
                                    <td class="am-hide-sm-only">{{ $v['email'] }}</td>
                                    <td class="am-hide-sm-only">{{ $v['lastloginip'] }}</td>
	                                <td class="am-hide-sm-only">{{ date('Y-m-d',$v['lastlogintime']) }}</td>
	                                <td class="am-hide-sm-only">{{ $v['updated_at'] }}</td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
								{{ $list->appends($search)->links() }}
                        </div>
                    </div>
                    <hr>

                </form>
            </div>

        </div>
    </div>
    <div class="tpl-alert"></div>
</div>
@stop

@section('javascript')
<script>

</script>
@stop