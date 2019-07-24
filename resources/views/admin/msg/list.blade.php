@extends('common.common')


@section('title')
    消息列表
@stop

@section('content')
    <div class="tpl-content-page-title">
        消息列表
    </div>
    <ol class="am-breadcrumb">
        <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
        <li class="am-active">消息列表</li>
    </ol>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                <span class="am-icon-code"></span> 消息列表
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
                            <input type="checkbox" class="liChildAll" value="" name="">
                            <a href="javascript:;" class="checkUnReaded"><span class="label label-sm label-success">标记未读</span></a>
                            <a href="javascript:;" class="checkReaded"><span class="label label-sm label-default">标记已读</span></a>
                            <a href="javascript:;" class="delAll"><span class="label label-sm label-danger">删除</span></a>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">

                </div>
            </div>

            <ul class="tpl-task-list tpl-task-remind content">
                    @foreach($msg as $key)
                        <li>
                            <div class="cosB" style="width:200px">
                                {{ $key->created_at }}
                            </div>
                            <div class="cosA">
                                <input type="checkbox" class="liChild" value="{{ $key->id }}" name="">
                                @if($key->status === 0)
                                    <span class="label label-sm label-success">未读</span>
                                @else
                                    <span class="label label-sm label-default">已读</span>
                                @endif

                                    <span style="cursor: pointer"> {{ $key->message }} </span>
                            </div>
                        </li>
                    @endforeach
            </ul>
        </div>
        <div class="am-cf">
            <div class="am-fr">
                {{ $msg->links() }}
            </div>
        </div>

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
         id = [];
         $.AMUI.progress.start();
         $(".liChild").each(function(i){
             if ($(this).is(':checked')) {
                 id[i] = $(this).val();
             }
         });
         id = JSON.stringify(id);
         if (confirm('确定删除选中文章?')) {
             $.ajax({
                 url:"{{ url('admin/message_mange/msg')}}/" + id,
                 method:'delete',
                 data:{id:id},
                 dataType:'json',
                 success:function(msg)
                 {
                     console.log(msg)
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
     $('.checkUnReaded').on('click',function(){
         id = [];
         $.AMUI.progress.start();
         $(".liChild").each(function(i){
             if ($(this).is(':checked')) {
                 id[i] = $(this).val();
             }
         });
         id = JSON.stringify(id);
             $.ajax({
                 url:"{{ url('admin/message_mange/msg')}}/" + id,
                 method:'get',
                 data:{id:id,status:0},
                 dataType:'json',
                 success:function(msg)
                 {
                     if(msg['code'] == 200){
                         $(".liChild").each(function(){
                             if ($(this).is(':checked')) {
                                 $(this).next('span').attr('class','label label-sm label-success').text('未读')
                             }
                         });
                         $.AMUI.progress.done();
                     }else if(msg['code'] == 500){
                         alert(msg['data']);
                         $.AMUI.progress.done();
                     }
                 }
             })
     });
     $('.checkReaded').on('click',function(){
         id = [];
         $.AMUI.progress.start();
         $(".liChild").each(function(i){
             if ($(this).is(':checked')) {
                 id[i] = $(this).val();
             }
         });
         id = JSON.stringify(id);
         $.ajax({
             url:"{{ url('admin/message_mange/msg')}}/" + id,
             method:'get',
             data:{id:id,status:1},
             dataType:'json',
             success:function(msg)
             {
                 if(msg['code'] == 200){
                     $(".liChild").each(function(){
                         if ($(this).is(':checked')) {
                             $(this).next('span').attr('class','label label-sm label-default').text('已读')
                         }
                     });
                     $.AMUI.progress.done();
                 }else if(msg['code'] == 500){
                     alert(msg['data']);
                     $.AMUI.progress.done();
                 }
             }
         })
     });
</script>
@stop
