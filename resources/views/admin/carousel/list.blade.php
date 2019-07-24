@extends('common.common')

@section('title')
	轮播图列表
@stop

@section('style')
<style>

</style>
   
@stop
@section('content')
<div class="tpl-content-page-title">
    轮播图列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">轮播图列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 轮播图列表
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
    	<form action="{{ url('/admin/carousel_manage/carousel/') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/carousel_manage/carousel/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 添加轮播图</a>
	                    </div>
	                </div>
	            </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="type">
                            <option value="-1">请选择轮播图类型</option>
                            <option value="1" {{ Request::get('type') == 1?'selected':''}}>默认</option>
                            <option value="2" {{ Request::get('type') == 2?'selected':''}}>广告</option>
                            <option value="3" {{ Request::get('type') == 3?'selected':''}}>文章</option>
                            <option value="4" {{ Request::get('type') == 4?'selected':''}}>链接</option>
                        </select>
                    </div>
                </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="title" value="{{ Request::get('title')?Request::get('title'):''}}" placeholder="请输入你要查询的分类名"> 
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
                    <table class="am-table am-table-striped am-table-hover table-main am-table-centered am-table-compact am-table-striped">
                        <thead>
                            <tr>
                                <th class="table-id">顺序</th>
                                <th class="table-title">封面图</th>
                                <th class="table-type">标题</th>
                                <th class="table-type">副标题</th>
                                <th class="table-type">类型</th>
                                <th class="table-author am-hide-sm-only">状态</th>
                                <th class="table-date am-hide-sm-only">添加日期</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                                <th class="table-set">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@if($carousel->isEmpty())
								<tr>
	                                <td colspan="9">暂无数据</td>
	                            </tr>
                        	@endif
                        	@foreach($carousel as $k => $v)
	                            <tr>
	                                <td class="am-text-middle">{{ $v->sort}}</td>
	                                <td class="am-text-middle"><img src="{{ $v->cover }}" alt="" height="70" width="100"></td>
                                    <td class="am-hide-sm-only am-text-middle">{{ $v->title }}</td>
                                    <td class="am-hide-sm-only am-text-middle">{{ $v->sub_title }}</td>
                                    <td class="am-hide-sm-only am-text-middle">
                                        @if($v->type == 1)
                                            <span class="am-badge am-radius am-badge-secondary">默认</span>
                                        @elseif($v->type == 2)
                                            <span class="am-badge am-radius am-badge-secondary">广告</span>
                                        @elseif($v->type == 3)
                                            <span class="am-badge am-radius am-badge-secondary">文章</span>
                                        @elseif($v->type == 4)
                                            <span class="am-badge am-radius am-badge-secondary">链接</span>
                                        @endif
                                    </td>
	                                <td class="am-hide-sm-only am-text-middle">
										@if($v->is_show == 0)
                                        	<a href="{{ url('/admin/carousel_manage/carousel/'.$v->id.'?is_show=0')}}" class="am-badge am-badge-danger am-text-sm">隐藏</a>
	                                    @elseif($v->is_show == 1)
	                                        <a href="{{ url('/admin/carousel_manage/carousel/'.$v->id.'?is_show=1')}}" class="am-badge am-badge-success am-text-sm">显示</a>
	                                    @endif
	                                </td>
                                    <td class="am-hide-sm-only am-text-middle">{{ $v->created_at }}</td>
	                                <td class="am-hide-sm-only am-text-middle">{{ $v->updated_at }}</td>
	                                <td class="am-text-middle">
	                                    <div class="am-btn-toolbar">
	                                        <div class="am-btn-group am-btn-group-xs">
	                                            <button type="button" data-id="{{$v['id']}}" class="am-btn am-btn-default am-btn-xs am-text-secondary add_content"><span class="am-icon-pencil-square-o"></span>编辑</button>
                                                <button type="button" data-id="{{$v['id']}}" class="am-btn am-btn-default am-btn-xs am-text-danger del"><span class="am-icon-pencil-square-o"></span>删除</button>
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
								{{ $carousel->appends('search')->links() }}
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
	$('.add_content').on('click',function(){
		var id = $(this).attr('data-id');
		window.location.href = "{{ url('admin/carousel_manage/carousel/') }}"+'/'+id+'/edit';
	})

    $('.del').on('click',function(){
    $.AMUI.progress.start();
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该轮播图?')) {
         $.ajax({
            url:"{{ url('admin/carousel_manage/carousel') }}/"+id,
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