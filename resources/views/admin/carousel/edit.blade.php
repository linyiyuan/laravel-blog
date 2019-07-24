@extends('common.common')

@section('title')
    @if(isset($carousel->id))
        修改轮播图
    @else
        添加轮播图
    @endif
@stop

@section('content')
<div class="tpl-content-page-title">
               @if(isset($carousel->id))
                    修改轮播图
                @else
                    添加轮播图
                @endif
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/carousel_manage/carousel') }}">轮播图管理</a></li>
    <li class="am-active">
        @if(isset($carousel->id))
            修改轮播图
        @else
            添加轮播图
        @endif
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                @if(isset($carousel->id))
                    修改轮播图
                @else
                    添加轮播图
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
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($carousel->id)?url('admin/carousel_manage/carousel').'/'.$carousel->id:url('admin/carousel_manage/carousel') }}"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if(isset($carousel->id))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">轮播图标题<span class="tpl-form-line-small-title">Title</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="title" placeholder="请输入轮播图标题" name="title" value="{{ $carousel->title?    $carousel->title:''}}" >
                                <small>请填写轮播图标题</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">轮播图副标题</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="sub_title" placeholder="请输入轮播图副标题" name="sub_title">{{ $carousel->sub_title? $carousel->sub_title:''}}</textarea>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">轮播图类型<span class="tpl-form-line-small-title">Type</span></label>
                            <div class="am-u-sm-9">
                                <select class="carousel_type"  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="type" required>
                                        <option value="1" {{ $carousel->type==1?'selected':''}}>默认</option>
                                        <option value="2" {{ $carousel->type==2?'selected':''}}>广告</option>
                                        <option value="3" {{ $carousel->type==3?'selected':''}}>文章</option>
                                        <option value="4" {{ $carousel->type==4?'selected':''}}>链接</option>
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group url">
                            <label for="user-name" class="am-u-sm-3 am-form-label">跳转链接<span class="tpl-form-line-small-title">Url</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="url" placeholder="请输入轮播图跳转地址" name="url" value="{{ $carousel->url?$carousel->url:''}}" >
                            </div>
                        </div>
                        <div class="am-form-group article" style="display:none">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">文章<span class="tpl-form-line-small-title">Article</span></label>
                            <div class="am-u-sm-9">
                                <select  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="third_id" required>
                                    @foreach($article as $k)
                                        <option value="{{ $k->id }}" {{ $carousel->third_id==$k->id?'selected':''}}>{{ $k->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">顺序<span class="tpl-form-line-small-title">Sort</span></label>
                            <div class="am-u-sm-9">
                                <input type="number" class="tpl-form-input" id="sort" placeholder="请输入轮播图顺序" name="sort" value="{{ $carousel->sort?    $carousel->sort:''}}" >
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">轮播图封面图 <span class="tpl-form-line-small-title">Cover</span></label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-file">
                                    <div class="tpl-form-file-img">
                                    </div>
                                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                      <input class="doc-form-file" type="file" multiple name="cover">
                                </div>
                                <div class="file-list">
                                    @if($carousel->cover)<img src="{{ $carousel->cover }}" alt="" class="title_pic img_style" style="" width="600" height="400">@endif
                                </div>
                            </div>
                        </div>        
                       
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/carousel_manage/carousel')}}">返回</a>
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
$(function(){
    if ($('.carousel_type').val() == 3) {
        $('.url').css('display','none');
        $('.article').css('display','');
    }
})

$('.carousel_type').on('change',function(){
    var self = $(this);
    var val = self.val();
    if (val == 3) {
        $('.url').css('display','none');
        $('.article').css('display','');
    }else{
        $('.url').css('display','');
        $('.article').css('display','none');
    }

})
</script>


@stop