@extends('common.common')

@section('title')
    文章详情页
@stop

@section('style')

@stop

@section('content')
<div class="tpl-content-page-title">
    文章详情页
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
     <li><a href="{{url('/admin/article_manage/article')}}">文章列表</a></li>
    <li class="am-active">文章详情页</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 文章详情页
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
        </div>
        <div class="am-g">
            <div class="tpl-table-images">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                    <div class="tpl-table-images-content">
                        <div class="tpl-table-images-content-i-time"><span class="bold caption green" style="font-size:16px">发布时间 <i class="am-icon-clock-o"></i> ：</span>{{ date('Y-m-d H:i',$article->time)}}</div>
                        <div class="tpl-i-title tpl-table-images-content-i-time">
                            <span class="bold caption green" style="font-size:16px">标题 <i class="am-icon-header"></i> ： </span>
                            {{ $article->title }}
                        </div>
                        <a href="javascript:;" class="tpl-table-images-content-i" >
                            <div class="tpl-table-images-content-i-info">
                                <span class="ico">
                                </span>
                            </div>
                            <figure data-am-widget="figure" class="am am-figure am-figure-default "   data-am-figure="{  pureview: 'true' }">
                                      <img src="{{ $article->cover}}" data-rel="{{ $article->cover}}" alt="查看图片" style="width:1000px;height:415px"/>
                            </figure>
                        </a>
                        <div class="tpl-i-title tpl-table-images-content-i-time">
                        </div>
                        <div class="tpl-table-images-content-block">
                            <div class="tpl-i-font">
                                <span class="bold caption green" style="font-size:16px">文章描述 <i class="am-icon-pencil"></i> ：</span>
                                {{ $article->desc }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                    <div class="tpl-table-images-content">
                        <div class="tpl-table-images-content-i-time"><span class="bold caption green" style="font-size:16px">文章作者 <i class="am-icon-user"></i> ：</span><span class="tpl-header-list-user-nick" style="font-size:14px">{{ $article->author}}</span>
                        </div>
                        <div class="tpl-table-images-content-i-time"> <span class="bold caption green" style="font-size:16px">是否展示 <i class="am-icon-eye"></i> ：</span>
                            @if($article->is_show == 1)
                                <span class="label label-sm label-success">是</span>
                            @else
                                <span class="label label-sm label-danger">否</span>
                            @endif
                        </div>
                        <div class="tpl-table-images-content-i-time"> <span class="bold caption green" style="font-size:16px">是否置顶 <i class="am-icon-arrow-up"></i> ：</span>
                            @if($article->is_up == 1)
                                <span class="label label-sm label-success">是</span>
                            @else
                                <span class="label label-sm label-danger">否</span>
                            @endif
                        </div>
                        <div class="tpl-table-images-content-i-time"> <span class="bold caption green" style="font-size:16px">是否博主推荐 <i class="am-icon-smile-o"></i> ：</span>
                            @if($article->is_recommend == 1)
                                <span class="label label-sm label-success">是</span>
                            @else
                                <span class="label label-sm label-danger">否</span>
                            @endif
                        </div>
                        <div class="tpl-table-images-content-i-time"> <span class="bold caption green" style="font-size:16px">文章模式 <i class="am-icon-smile-o"></i> ：</span>
                            @if($article->article_type == 1)
                                <span class="label label-sm label-success">公开</span>
                            @else
                                <span class="label label-sm label-danger">私有</span>
                            @endif
                        </div>
                        <div class="tpl-table-images-content-i-time">
                            <div class="tpl-i-font">
                                <span class="bold caption green" style="font-size:16px">文章所属分类 <i class="am-icon-list"></i> ：</span>
                                <span class="label label-sm label-default"> {{ $articleType[$article->type] }}
                                </span>
                                
                            </div>
                        </div>
                        <div class="tpl-table-images-content-i-time">
                            <div class="tpl-i-font">
                                <span class="bold caption green" style="font-size:16px">文章所属标签 <i class="am-icon-tags"></i> ：</span>
                                    @if($article->tags->isEmpty())
                                        <span class="tpl-label-info">无</span>
                                    @else
                                        @foreach($article->tags as $k)
                                                     <span class="tpl-label-info"> {{ $k->tag_name }}</span>&nbsp;
                                        @endforeach
                                    @endif
                                </span>
                                
                            </div>
                        </div>
                        <div class="tpl-table-images-content-i-time"><span class="bold caption green" style="font-size:16px">创建时间 <i class="am-icon-clock-o"></i> ：</span>{{ $article->created_at}}
                        </div>
                        <div class="tpl-table-images-content-i-time"><span class="bold caption green" style="font-size:16px">修改时间 <i class="am-icon-clock-o"></i> ：</span>{{ $article->updated_at}}
                        </div>
                        <div class="tpl-table-images-content-block">
                            <div class="tpl-i-font">
                               <span class="bold caption green" style="font-size:16px">文章内容 <i class="am-icon-leanpub"></i> ：</span><button type="button" class="am-btn am-btn-default am-btn-primary" data-am-modal="{target: '#my-popup'}"><i class="am-icon-eye"></i>点击查看</button>
                            </div>
                            <div class="tpl-i-more">
                                <ul>
                                    <li><span class="am-icon-eye am-text-warning"> {{ $article->click }}</span></li>
                                    <li><span class="am-icon-thumbs-o-up am-text-success"> {{ $article->praise}}</span></li>
                                    <li><span class="am-icon-share-alt font-green"> {{ $article->share}}</span></li>
                                </ul>
                            </div>
                            <div class="am-btn-toolbar" style="margin-top:19.5px">
                                <div class="am-btn-group am-btn-group-xs tpl-edit-content-btn">
                                    <a style="width:50%;font-size:16px"  href="{{ url('admin/article_manage/article/create') }}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                                    <a style="width:50%;font-size:16px"  href="{{ url('admin/article_manage/article/'.$article->id.'/edit') }}" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-edit"></span> 编辑</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                                                        
                <div style="height:200px">
                </div>

            </div>

        </div>
    </div>
    <div class="tpl-alert"></div>
</div>

<!-- 文章模态窗口 -->
<div class="am-popup" id="my-popup" style="border-radius:2%;z-index: 1800;">
  <div class="am-popup-inner">
    <div class="am-popup-hd">
      <h4 class="am-popup-title">{{ $article->title}}</h4>
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
      {!! $article->content !!}
    </div>
  </div>
</div>
<!-- <div class="am-modal am-modal-no-btn" tabindex="-1" id="my-popup">
  <div class="am-modal-dialog" style="overflow: auto;line-height:20px">
    <div class="am-modal-hd">{{ $article->title}}
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
      {!! $article->content !!}
    </div>
  </div>
</div> -->
@stop

@section('javascript')

<script>
// $('#demo-full-img').on('click', function () {
//   if (fullscreen.enabled) {
//     fullscreen.request(this);
//   }
// })
</script>
@stop


