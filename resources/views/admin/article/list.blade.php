@extends('common.common')

@section('title')
文章管理列表页
@stop

@section('content')
<div class="tpl-content-page-title">
    文章管理列表页
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="">文章管理</li>
    <li class="am-active">文章管理列表页</li>
</ol>

<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code">文章管理列表页</span>
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
    	<form action="{{ url('/admin/article_manage/article/') }}" method="get">
	        <div class="am-g">
	            <div class="am-u-sm-12 am-u-md-6">
	                <div class="am-btn-toolbar">
	                    <div class="am-btn-group am-btn-group-xs">
	                        <a href="{{ url('/admin/article_manage/article/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                            <a href="{{ url('/admin/user_manage/user/create') }}" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</a>
	                        <a href="javascript:;" class="am-btn am-btn-default am-btn-warning liChildAll"><span class="am-icon-check-square"></span> 全选</a>
	                        <a href="javascript:;" class="am-btn am-btn-default am-btn-danger delAll"><span class="am-icon-trash-o"></span> 删除</a>
	                    </div>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-form-group">
	                    <select data-am-selected="{btnSize: 'sm',maxHeight: 120}" name="type">
                          <option value="-1">请选择文章分类</option>
                          @foreach($articleType as $k)
                            <option value="{{ $k->id }}" {{ Request::get('type') == $k->id?'selected':''}}>{{ $k->type_name}}</option>
                          @endforeach
						</select>
	                </div>
	            </div>
	            <div class="am-u-sm-12 am-u-md-3">
	                <div class="am-input-group am-input-group-sm">
	                    <input type="text" class="am-form-field" name="title" placeholder="请输入你要查询的文章标题" value="{{ Request::get('title')}}"> 
	                    <span class="am-input-group-btn">
				            <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
				         </span>
	                </div>
	            </div>
	        </div>
        </form>
        <ul class="tpl-task-list">
            @foreach($article as $k)
                <li>
                    <div class="task-checkbox">
                        <input type="hidden" value="{{ $k->id }}" name="id">
                        <input type="checkbox" class="liChild" value="{{ $k->id }}" name=""> </div>
                    <div class="task-title">
                        <span class="task-title-sp">{{ $k->title }}</span>
                        @if($k->is_show == 1)
                            <a href="{{ url('/admin/article_manage/article/'.$k->id.'?is_show=1')}}" class="label label-sm label-success">显示</a>
                            <span class="task-bell">
                                    <i class="am-icon-bell-o"></i>
                        </span>
                        @else
                            <a href="{{ url('/admin/article_manage/article/'.$k->id.'?is_show=0')}}" class="label label-sm label-default">隐藏</a>
                        @endif
                        
                        <span style="float:right;font-style:italic;color:#c1cbd0;">{{ date('Y-m-d H:i',$k->time)}}</span>
                    </div>
                    <div class="cosB">
                    </div>
                    <div class="task-config">
                        <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown="">
                            <a href="javascript:;" class="am-dropdown-toggle tpl-task-list-hover " data-am-dropdown-toggle="">
                                <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                            </a>
                            <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                <li>
                                    <a href="{{ url('admin/article_manage/detail/').'/'.$k->id }}">
                                        <i class="am-icon-eye"></i>  详情 </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/article_manage/article/').'/'.$k->id.'/edit' }}">
                                        <i class="am-icon-pencil"></i> 编辑 </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="del" data-id="{{ $k->id }}">
                                        <i class="am-icon-trash-o"></i> 删除 </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div style="height:100px"></div>
        <div class="am-u-lg-12">
                    <div class="am-cf">

                        <div class="am-fr">
                                {{ $article->appends('search')->links() }}
                        </div>
                    </div>
                    <hr>
        </div>
    </div>
    <div class="tpl-alert"></div>
</div>
@stop

@section('javascript')
<script>
 $(".liChildAll").on('click',function() {  
    $(".liChild").each(function(){  
         $(this).prop("checked",!$(this).prop('checked'));             
    }); 
});

$('.delAll').on('click',function(){
    var id = [];
    $.AMUI.progress.start();
    $(".liChild").each(function(i){ 
        if ($(this).is(':checked')) {
           id[i] = $(this).val();
        } 
    }); 
     if (confirm('确定删除选中文章?')) {
         $.ajax({
            url:"{{ url('admin/article_manage/detail/delmore') }}",
                method:'post',
                data:{id:id},
                dataType:'json',
                success:function(msg)
                {
                    if(msg['code'] == 200){
                        $(".liChild").each(function(){ 
                            if ($(this).is(':checked')) {
                               $(this).parent().parent().remove();
                            } 
                        });
                        $.AMUI.progress.done();
                    }else if(msg['code'] == 500){
                        alert(msg['data']);
                        $.AMUI.progress.done();
                    }

                }   
        })
    }
});

$('.del').on('click',function(){
    $.AMUI.progress.start();
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该文章?')) {
         $.ajax({
            url:"{{ url('admin/article_manage/article') }}/"+id,
                method:'delete',
                data:{id:id},
                dataType:'json',
                success:function(msg)
                {
                    if(msg['code'] == 200){
                        that.parent().parent().parent().parent().parent().remove();
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

