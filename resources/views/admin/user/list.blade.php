@extends('common.common')

@section('title')
	管理员列表
@stop

@section('content')
<div class="tpl-content-page-title">
    管理员列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">管理员列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 管理员列表
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
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/user_manage/user/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增一个管理员</a>
	                    </div>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-form-group">
	                    <select data-am-selected="{btnSize: 'sm'}" name="role">
			              <option value="-1">请选择角色</option>
                           @foreach($role as $k)
                                <option value="{{ $k->id }}" {{ Request::get('role') == $k->id?'selected':''}}>{{ $k->display_name}}</option>
                           @endforeach
						</select>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="name" placeholder="请输入你要查询的用户名" value="{{ Request::get('name')}} "> 
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
                                <th class="table-title">用户名</th>
                                <th class="table-type">角色</th>
                                <th class="table-author am-hide-sm-only">邮箱</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                                <th class="table-set">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($list as $k => $v)
	                            <tr>
	                                <td>{{ $v['id'] }}</td>
	                                <td>{{ $v['name']}}</td>
	                                <td>
                                        @foreach($v->roles as $role)
                                                <span class="am-badge am-badge-success am-radius">
                                                    {{ $role->display_name }}
                                                </span>
                                         @endforeach
                                    </td>
	                                <td class="am-hide-sm-only">{{ $v['email'] }}</td>
	                                <td class="am-hide-sm-only">{{ $v['updated_at'] }}</td>
	                                <td>
	                                    <div class="am-btn-toolbar">
	                                        <div class="am-btn-group am-btn-group-xs">
	                                            <button type="button" data-id="{{$v['id']}}" class="am-btn am-btn-default am-btn-xs am-text-secondary add_content"><span class="am-icon-pencil-square-o"></span> 编辑</button>
	                                            @if(Auth::id() !== $v['id'])
	                                            	<button type="button" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only del" data-id="{{$v['id']}}"><span class="am-icon-trash-o"></span> 删除</button>
	                                            @endif
	                                        </div>
	                                    </div>
	                                </td>
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
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	$('.add_content').on('click',function(){
		var id = $(this).attr('data-id');
		window.location.href = "{{ url('admin/user_manage/user/') }}"+'/'+id+'/edit';
	})

	$('.del').on('click',function(){
		$.AMUI.progress.start();
        var that  = $(this);
        var id = that.attr('data-id');
        if (confirm('确定删除该管理员?')) {
             $.ajax({
                url:"{{ url('admin/user_manage/user') }}/"+id,
                    method:'delete',
                    data:{id:id},
                    dataType:'json',
                    success:function(msg)
                    {
                        if(msg['code'] == 200){
                            that.parent().parent().parent().parent().remove();
                            $.AMUI.progress.done();
                        }else if(msg['code'] == 500){
                            alert(msg['data']);
                            $.AMUI.progress.done();
                        }

                    }   
            })
        }
    })
</script>
@stop