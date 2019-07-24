@extends('common.common')

@section('title')
	文章分类列表
@stop

@section('content')
<div class="tpl-content-page-title">
    文章分类列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">文章分类列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 文章分类列表
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
    	<form action="{{ url('/admin/type_manage/type/') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/type_manage/type/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 添加分类</a>
	                    </div>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="type_name" placeholder="请输入你要查询的分类名" value="{{ Request::get('type_name')}} "> 
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
                                <th class="table-id">顺序</th>
                                <th class="table-title">分类名</th>
                                <th class="table-type">分类描述</th>
                                <th class="table-author am-hide-sm-only">状态</th>
                                <th class="table-author am-hide-sm-only">父分类</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                                <th class="table-set">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@if($articleType->isEmpty())
								<tr>
	                                <td colspan="7">暂无数据</td>
	                            </tr>
                        	@endif
                        	@foreach($articleType as $k => $v)
	                            <tr>
	                                <td>{{ $v->id }}</td>
	                                <td>{{ $v->sort}}</td>
	                                <td>{{ $v->type_name}}</td>
	                                <td class="am-hide-sm-only">{{ $v->desc }}</td>
	                                <td class="am-hide-sm-only">
										@if($v->is_show == 0)
                                        	<a href="{{ url('/admin/type_manage/type/'.$v->id.'?is_show=0')}}" class="am-badge am-badge-danger am-text-sm">隐藏</a>
	                                    @elseif($v->is_show == 1)
	                                        <a href="{{ url('/admin/type_manage/type/'.$v->id.'?is_show=1')}}" class="am-badge am-badge-success am-text-sm">显示</a>
	                                    @endif
	                                </td>
                                    <td class="am-hide-sm-only">{{ $v->parent_id===0?'顶级':$parentType[$v->parent_id] }}</td>
	                                <td class="am-hide-sm-only">{{ $v->updated_at }}</td>
	                                <td>
	                                    <div class="am-btn-toolbar">
	                                        <div class="am-btn-group am-btn-group-xs">
	                                            <button type="button" data-id="{{$v['id']}}" class="am-btn am-btn-default am-btn-xs am-text-secondary add_content"><span class="am-icon-pencil-square-o"></span> 编辑</button>
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
								{{ $articleType->appends('search')->links() }}
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
		window.location.href = "{{ url('admin/type_manage/type/') }}"+'/'+id+'/edit';
	})
</script>
@stop