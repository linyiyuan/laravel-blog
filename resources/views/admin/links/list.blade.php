@extends('common.common')

@section('title')
	友情链接
@stop

@section('content')
<div class="tpl-content-page-title">
    友情链接
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">友情链接</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 友情链接
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
        <form action="{{ url('/admin/links_manage/links') }}" method="get">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-6">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="{{ url('/admin/links_manage/links/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span>添加友情链接</a>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <div class="am-input-group am-input-group-sm">
                            <input type="text" class="am-form-field" name="title" value="{{ Request::get('title')?Request::get('title'):''}}" placeholder="请输入你要查询的友情链接"> 
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
                                <th class="table-title">链接名</th>
                                <th class="table-type">链接</th>
                                <th class="table-type">申请者邮箱</th>
                                 <th class="table-type">是否显示</th>
                                <th class="table-author am-hide-sm-only">日期</th>
                                <th class="table-author am-hide-sm-only">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $k)
                                <tr>
                                    <td>{{ $k->id }}</td>
                                    <td>{{ $k->title }}</td>
                                    <td>
                                       {{ $k->url}}
                                    </td>
                                    <td>
                                        {{ $k->email }}
                                    </td>
                                    <td>
                                        @if($k->is_show == 0)
                                            <a href="{{ url('/admin/links_manage/links/'.$k->id.'?is_show=0')}}" class="am-badge am-badge-danger am-text-sm">隐藏</a>
                                        @elseif($k->is_show == 1)
                                            <a href="{{ url('/admin/links_manage/links/'.$k->id.'?is_show=1')}}" class="am-badge am-badge-success am-text-sm">显示</a>
                                        @endif
                                    </td>
                                    <td class="am-hide-sm-only">{{ $k->created_at }}</td>
                                    <td class="am-text-middle">
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <button type="button" data-id="{{ $k->id}}" class="am-btn am-btn-default am-btn-xs am-text-secondary edit"><span class="am-icon-pencil-square-o"></span>编辑</button>
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
                            {{ $links->appends($search)->links()}}
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
$('.edit').on('click',function(){
        var id = $(this).attr('data-id');
        window.location.href = "{{ url('admin/links_manage/links/') }}"+'/'+id+'/edit';
});

$('.del').on('click',function(){
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该友情链接?')) {
        $.AMUI.progress.start();
         $.ajax({
            url:"{{ url('admin/links_manage/links') }}/"+id,
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