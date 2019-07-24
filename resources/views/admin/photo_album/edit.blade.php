@extends('common.common')

@section('title')
    @if(isset($photoAlbum->id))
        修改相册
    @else
        添加相册
    @endif
@stop

@section('style')
<style>
.img_style{
        width: 500px;
        height: 300px;
    }

</style>
@stop

@section('content')
<div class="tpl-content-page-title">
               @if(isset($photoAlbum->id))
                    修改相册
                @else
                    添加相册
                @endif
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/photo_manage/photo_album') }}">相册管理</a></li>
    <li class="am-active">
        @if(isset($photoAlbum->id))
            修改相册
        @else
            添加相册
        @endif
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                @if(isset($photoAlbum->id))
                    修改相册
                @else
                    添加相册
                @endif
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
            <div class="tpl-form-body tpl-form-line">
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($photoAlbum->id)?url('admin/photo_manage/photo_album').'/'.$photoAlbum->id:url('admin/photo_manage/photo_album') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if(isset($photoAlbum->id))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">相册名(唯一性)<span class="tpl-form-line-small-title">Type</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="user-name" placeholder="请输入相册名" name="name" value="{{ $photoAlbum->name?$photoAlbum->name:''}}" >
                                <small>请填写相册名文字8-10左右。</small>
                            </div>
                        </div>
                        <div class="am-form-group">
	                        <label for="user-phone" class="am-u-sm-3 am-form-label">相册分类<span class="tpl-form-line-small-title">Photo_Permission</span></label>
	                        <div class="am-u-sm-9">
	                            <select  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="type" required>
	                                  <option></option>
	                              @foreach($photoAlbumType as $k)
	                                  <option value="{{ $k->id }}" {{ $photoAlbum->type==$k->id?'selected':''}}>-{{ $k->type_name}}</option>
	                              @endforeach
	                            </select>
		                    </div>
	                    </div>
	                    <div class="am-form-group">
	                        <label for="user-phone" class="am-u-sm-3 am-form-label">相册权限<span class="tpl-form-line-small-title">Permission</span></label>
	                        <div class="am-u-sm-9">
	                            <select  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="photo_permission" required class="photo_permission">
	                                  <option></option>
	                             	<option value="0" {{ $photoAlbum->photo_permission===0?'selected':''}}>所有人可以见</option>
	                             	<option value="1" {{ $photoAlbum->photo_permission===1?'selected':''}}>回答问题可以看</option>
	                             	<option value="2" {{ $photoAlbum->photo_permission===2?'selected':''}}>仅自己可以看</option>
	                            </select>
		                    </div>
	                    </div>
	                    <div class="am-form-group" id="question" style="{{$photoAlbum->photo_permission===1?'':'display:none'}}">
                            <label for="user-name" class="am-u-sm-3 am-form-label">问题<span class="tpl-form-line-small-title">Question</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" placeholder="请输入问题" name="question" value="{{ $photoAlbum->question? $photoAlbum->question:''}}" >
                                <small>请填写问题8-10左右。</small>
                            </div>
                        </div>
                        <div class="am-form-group" id="answer" style="{{$photoAlbum->photo_permission===1?'':'display:none'}}"">
                            <label for="user-name" class="am-u-sm-3 am-form-label">答案<span class="tpl-form-line-small-title">Answer</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input"  placeholder="请输入答案" name="answer" value="{{ $photoAlbum->answer?    $photoAlbum->answer:''}}" >
                                <small>请填写答案8-10左右。</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">相册描述</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="user-intro" placeholder="请输入相册描述" name="desc">{{ $photoAlbum->desc? $photoAlbum->desc:''}}</textarea>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">文章封面图 <span class="tpl-form-line-small-title">Cover</span></label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-file">
                                    <div class="tpl-form-file-img">
                                    </div>
                                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                      <input class="doc-form-file" type="file" multiple name="cover">
                                </div>
                                <div class="file-list">
                                    @if($photoAlbum->cover)<img src="{{ $photoAlbum->cover }}" alt="" class="title_pic img_style" style="" >@endif
                                </div>
                        </div>
                    </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/photo_manage/photo_album')}}">返回</a>
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>
@stop


@section('javascript')
<script>
$('.photo_permission').on('change',function(){
	var that = $(this);
	if (that.val() == 1) {
		$('#question').css('display','block');
		$('#answer').css('display','block');
	}else{
		$('#question').css('display','none');
		$('#answer').css('display','none');
	}
})
</script>
@stop