@extends('common.common')


@section('title')
    相册管理
@stop

@section('style')
<style>

</style>
@stop


@section('content')
<div class="tpl-content-page-title">
    Amaze UI 文字列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">相册列表</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 列表
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
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{ url('admin/photo_manage/photo_album/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增相册</a>
                    </div>
                </div>
            </div>
            <form action="{{ url('/admin/photo_manage/photo_album/') }}" method="get">
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <select data-am-selected="{btnSize: 'sm',maxHeight: 170}" name="type_name">
    					   <option value="-1">请选择相册分类</option>
                           @foreach($photoAlbumType as $k => $v)
                                <option value="{{ $k }}" {{ Request::get('type_name')==$k?'selected':''}}>{{ $v }}</option>
                           @endforeach

    					</select>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" placeholder="请输入相册名" name="name" value="{{ Request::get('name')?Request::get('name'):''}}">
                        <span class="am-input-group-btn">
    						<button type="submit" class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-icon-search" type="button"></button>
    					</span>
                    </div>
                </div>
            </form>
        </div>
        <div class="am-g">
            <div class="tpl-table-images">
                @if($photoAlbum->isEmpty())
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12" style="height:200px">
                           暂无数据
                    </div>
                @else
                    @foreach($photoAlbum as $k)
                        <div class="am-u-sm-12 am-u-md-12 am-u-lg-4">
                            <div class="tpl-table-images-content">
                                <div class="tpl-table-images-content-i-time" style="font-size:14px"><span>作者 ：{{ $k->author}}</span> </div>
                                <div class="tpl-table-images-content-i-time" style="font-size:14px"><span>相册名 ：{{ $k->name}}</span> </div>
                                <div class="tpl-table-images-content-i-time" style="font-size:14px"><span>相册分类 ：{{ $photoAlbumType[$k->type] }}</span> </div>
                                <a href="javascript:;" class="tpl-table-images-content-i">
                                    <div class="tpl-table-images-content-i-info">
                                        <span class="ico">
                                        </span>
                                    </div>
                                    <figure data-am-widget="figure" class="am am-figure am-figure-default "   data-am-figure="{  pureview: 'true' }">
                                               <img src="{{ $k->cover }}" alt="" style="width:380px;height:220px" >
                                    </figure>
                                   
                                </a>
                                <div class="tpl-table-images-content-block">
                                    <div class="tpl-i-font">
                                        <div class="tpl-table-images-content-i-time"  style="font-size:14px"><span>相册描述 ：{{ $k->name}}</span> </div>
                                    </div>
                                    <div class="tpl-i-more">
                                        <ul>
                                            <li><span class="am-icon-eye am-text-warning"> {{ $k->click }}</span></li>
                                            <li><span class="am-icon-thumbs-o-up am-text-success"> {{ $k->praise }}</span></li>
                                            <li><span class="am-icon-files-o font-green"> {{ array_key_exists($k->id,$photoNum)?$photoNum[$k->id]:0}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs tpl-edit-content-btn">
                                            <a style="width:25%" href="{{ url('admin/photo_manage/picture/create?photo_album=').$k->id }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增照片</a>
                                            <a style="width:25%" href="{{ url('admin/photo_manage/photo_album/'.$k->id.'/edit') }}" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-edit"></span> 相册编辑</a>
                                            <a style="width:25%" href="javascript:;" class="am-btn am-btn-default am-btn-danger del" data-id="{{ $k->id }}"><span class="am-icon-trash-o"></span> 删除相册</a>
                                            <button style="width:25%"  class="am-btn am-btn-default am-btn-warning photo_permission" data-question="{{$k->question}}" data-answer="{{ $k->answer }}" data-photo_permission="{{ $k->photo_permission }}" data-id="{{ $k->id }}" ><span class="am-icon-eye"></span>相册查看</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="am-u-lg-12">
                    <div class="am-cf">
                        <div class="am-fr">
                                {{ $photoAlbum->appends($search)->links() }}
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="tpl-alert"></div>
</div>
<!-- 弹出框 -->
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">提示</div>
    <div class="am-modal-bd">
      正在跳转...
      <div>
        <span class="am-icon-spinner am-icon-spin"></span>
      </div>
    </div>
  </div>
</div>

<!-- 问题提示框 -->
<div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">相册问题回答</div>
    <div class="am-modal-bd">
      <span class="am-question"></span>
      <input type="text" class="am-modal-prompt-input am-answer">
      <span style="color:red" class="error_message"></span>
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>提交</span>
    </div>
  </div>
</div>

<!-- 密码输入正确时 -->
<div class="am-modal am-modal-alert" tabindex="-1" id="success-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">提示</div>
    <div class="am-modal-bd">
      密码输入正确，正在为你跳转....
      <div>
        <span class="am-icon-spinner am-icon-spin"></span>
      </div>
    </div>
  </div>
</div>
@stop

@section('javascript')
<script>
$('.tpl-table-images').on('click','.photo_permission',function(){
    var that = $(this);
    question = that.attr('data-question');
    answer = that.attr('data-answer');
    photo_permission = that.attr('data-photo_permission');
    photo_album_id = that.attr('data-id');
    if (photo_permission == 1) {
        $('.am-question').html(question);
        $('#my-prompt').modal({
          relatedTarget: this,
          onConfirm: function(e) {
            if (e.data == answer) {
                $('#success-alert').modal({
                  relatedTarget: this,
                });
                url = "{{ url('admin/photo_manage/picture/?photo_album_id=')}}"+photo_album_id;
                setTimeout("location.href='"+url+"'",1500);
            }else{
                $('.am-answer').val('');
                alert('密码错误!');
            }
          }
        });
    }else{
        $('#my-alert').modal({
                  relatedTarget: this,
        });
        url = "{{ url('admin/photo_manage/picture/?photo_album_id=')}}"+photo_album_id;
        setTimeout("location.href='"+url+"'",500);
    }
})
$('.del').on('click',function(){
    $.AMUI.progress.start();
    var that  = $(this);
    var id = that.attr('data-id');
    if (confirm('确定删除该相册（相册里面图片全都会清除）?')) {
         $.ajax({
            url:"{{ url('admin/photo_manage/photo_album') }}/"+id,
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