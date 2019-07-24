@extends('common.common')

@section('title')
	评论列表
@stop

@section('content')
<div class="tpl-content-page-title">
    评论列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">评论列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 评论列表
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
        <form action="{{ url('/admin/comment_manage/comment') }}" method="get">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <div class="am-input-group am-input-group-sm">
                            <input type="text" class="am-form-field" name="comment" value="{{ Request::get('comment')?Request::get('comment'):''}}" placeholder="请输入你要查询的评论"> 
                            <span class="am-input-group-btn">
                                <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="submit"></button>
                             </span>
                        </div>
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
                                <th class="table-title">ID</th>
                                <th class="table-title">评论者/回复者</th>
                                <th class="table-type">评论内容</th>
                                <th class="table-type">类型</th>
                                <th class="table-type">文章id</th>
                                <th class="table-author am-hide-sm-only">日期</th>
                                <th class="table-author am-hide-sm-only">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comment as $k)
                                <tr>
                                    <td>{{ $k->id }}</td>
                                    <td>{{ $visitor[$k->user_id]}}</td>
                                    <td>
                                       {{ $k->comment}}
                                    </td>
                                    <td>
                                        @if($k->type == 1)
                                            评论
                                        @else
                                            回复
                                        @endif
                                    </td>
                                    <td>
                                        {{ $k->article_id }}
                                    </td>
                                    <td class="am-hide-sm-only">{{ $k->created_at }}</td>
                                    <td class="am-text-middle">
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                @if($k->deleted == 0)
                                                    <a style="background: #fff;" href="{{ url('/admin/comment_manage/comment/'.$k->id)}}"  class="am-btn am-btn-default am-btn-xs am-text-warning dustbin"><span class="am-icon-pencil-square-o"></span> 移入垃圾箱</a>    
                                                @else
                                                    <a style="background: #fff;" href="{{ url('/admin/comment_manage/comment/'.$k->id)}}"  class="am-btn am-btn-default am-btn-xs am-text-warning dustbin"><span class="am-icon-pencil-square-o"></span> 移出垃圾箱</a>  
                                                @endif
                                                <button type="button" data-id="{{ $k->id }}" class="am-btn am-btn-default am-btn-xs am-text-danger del"><span class="am-icon-trash-o"></span> 删除</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                            {{ $comment->appends($search)->links()}}
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
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该轮播图?')) {
        $.AMUI.progress.start();
         $.ajax({
            url:"{{ url('admin/comment_manage/comment') }}/"+id,
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