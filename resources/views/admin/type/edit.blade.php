@extends('common.common')

@section('title')
    @if(isset($articleType->id))
        修改文章分类
    @else
        添加文章分类
    @endif
@stop

@section('content')
<div class="tpl-content-page-title">
               @if(isset($articleType->id))
                    修改文章分类
                @else
                    添加文章分类
                @endif
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li><a href="{{ url('/admin/type_manage/type') }}">文章分类管理</a></li>
    <li class="am-active">
        @if(isset($articleType->id))
            修改文章分类
        @else
            添加文章分类
        @endif
    </li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 
                @if(isset($articleType->id))
                    修改文章分类
                @else
                    添加文章分类
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
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($articleType->id)?url('admin/type_manage/type').'/'.$articleType->id:url('admin/type_manage/type') }}">
                        {{ csrf_field() }}
                        @if(isset($articleType->id))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">文章分类名(唯一性)<span class="tpl-form-line-small-title">Type</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="user-name" placeholder="请输入文章分类名" name="type_name" value="{{ $articleType->type_name?    $articleType->type_name:''}}" >
                                <small>请填写文章分类名文字8-10左右。</small>
                            </div>
                        </div>
                    
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">文章顺序 <span class="tpl-form-line-small-title"></span></label>
                            <div class="am-u-sm-9">
                                <input type="number" placeholder="请输入文章顺序" name="sort" value="{{ $articleType->sort?$articleType->sort:''}}" >
                                <small>请填写文章分类描述。</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">父分类<span class="tpl-form-line-small-title">Parent_id</span></label>
                            <div class="am-u-sm-9">
                                <select  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="parent_id" required>
                                      <option value="0">顶级分类</option>
                                  @foreach($parentType as $k => $v)
                                      <option value="{{ $k }}" {{ $articleType->parent_id==$k?'selected':''}}>-{{ $v}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">文章分类描述</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="user-intro" placeholder="请输入文章分类描述" name="desc">{{ $articleType->desc? $articleType->desc:''}}</textarea>
                            </div>
                        </div>
                       
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <a class="am-btn am-btn-warning" href="{{ url('admin/type_manage/type')}}">返回</a>
                                <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>

@stop