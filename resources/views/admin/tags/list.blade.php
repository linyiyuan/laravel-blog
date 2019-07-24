@extends('common.common')

@section('title')
	文章标签列表
@stop

@section('content')
<div class="tpl-content-page-title">
    文章标签列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">文章标签列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 文章标签列表
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
    	<form action="{{ url('/admin/article_manage/tags/') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/article_manage/tags/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 添加标签</a>
	                    </div>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="tag_name" placeholder="请输入你要查询的标签名" value="{{ Request::get('tag_name')}}"> 
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
                                <th class="table-title">标签名</th>
                                <th class="table-type">标签描述</th>
                                <th class="table-date am-hide-sm-only">添加日期</th>
                                <th class="table-date am-hide-sm-only">修改日期</th>
                                <th class="table-set">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@if($articleTags->isEmpty())
								<tr>
	                                <td colspan="7">暂无数据</td>
	                            </tr>
                        	@endif
                        	@foreach($articleTags as $k => $v)
	                            <tr>
	                                <td>{{ $v->id }}</td>
	                                <td>{{ $v->tag_name}}</td>
	                                <td class="am-hide-sm-only">{{ $v->tag_desc }}</td>
                                    <td class="am-hide-sm-only">{{ $v->created_at }}</td>
	                                <td class="am-hide-sm-only">{{ $v->updated_at }}</td>
	                                <td>
	                                    <div class="am-btn-toolbar">
	                                        <div class="am-btn-group am-btn-group-xs">
	                                            <button type="button" data-id="{{$v->id}}" class="am-btn am-btn-default am-btn-xs am-text-danger add_content del"><span class="am-icon-trash-o"></span> 删除</button>
	                                        </div>
	                                    </div>
	                                </td>
	                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
								{{ $articleTags->appends('search')->links() }}
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
$('.del').on('click',function(){
    $.AMUI.progress.start();
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该标签?')) {
         $.ajax({
            url:"{{ url('admin/article_manage/tags') }}/"+id,
                method:'delete',
                data:{id:id},
                dataType:'json',
                success:function(msg)
                {
                    console.log(msg);
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