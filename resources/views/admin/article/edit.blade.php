@extends('common.common')

@section('title')
	{{ $article->id?'文章修改页面':'文章添加页面'}}
@stop

@section('style')
<link rel="stylesheet" href="{{ asset('admin/css/amazeui.chosen.css')}}">
<link rel="stylesheet" href="{{ asset('admin/css/amazeui.datetimepicker.css')}}">
<link rel="stylesheet" href="{{ asset('simplemde/debug/simplemde.css') }}" />
<link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/css/ueditor.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
<style>
	.am-switch{
		top:10px;
		left:-20px;
	}

    .img_style{
        width: 500px;
        height: 300px;
    }
    .content img{
        width:800px;
        height:450px;
    }
    pre {
        display: block;
        padding: 1rem;
        margin: 1rem 0;
        font-size: 1.3rem;
        line-height: 1.6;
        word-break: break-all;
        word-wrap: break-word;
        color: #858080;
        background-color: #f8f8f8;
        border: 1px solid #dedede;
        border-radius: 0;
    }
</style>
@stop
@section('content')
<div class="tpl-content-page-title">
    {{ $article->name?'文章修改页面':'文章添加页面'}}
</div>
<ol class="am-breadcrumb">
    <li><a href="{{url('/admin/index')}}" class="am-icon-home">首页</a></li>
    <li><a href="{{url('/admin/article_manage/article')}}">文章列表</a></li>
    <li class="am-active">{{ $article->id?'文章修改页面':'文章添加页面'}}</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> {{ $article->id?'文章修改页面':'文章添加页面'}}
        </div>
    </div>
    <div class="tpl-block">
         <div class="am-g  tpl-form-line tpl-form-body">
            <div class="am-u-sm-12 am-u-md-9">
                <form class="am-form tpl-form-line-form" method="post" action="{{ isset($article->id)?url('/admin/article_manage/article').'/'.$article->id:url('/admin/article_manage/article') }}" enctype="multipart/form-data">
                	{{ csrf_field() }}
                	@if(isset($article->id))
						{{ method_field('PUT') }}
                	@endif
                    <input type="hidden" name="author" value="{{ $article->author?$article->author:Auth::user()->name}}">
                    <input type="hidden" name="user_id" value="{{ $article->user_id?$article->user_id:Auth::id()}}">
                   	<div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">文章标题<span class="tpl-form-line-small-title">title</span></label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="title" placeholder="请输入文章标题" name="title" value="{{ $article->title?$article->title:''}}" required>
                                <small>请填写文章标题</small>
                            </div>
                    </div>
					<div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">文章分类<span class="tpl-form-line-small-title">Type</span></label>
                        <div class="am-u-sm-9">
                            <select  data-am-selected="{searchBox: 1,maxHeight: 120}" style="display: none;" name="type" required>
                                  <option></option>
                              @foreach($articleType as $k)
                                  <option value="{{ $k->id }}" {{ $article->type==$k->id?'selected':''}}>-{{ $k->type_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                    	<label for="user-phone" class="am-u-sm-3 am-form-label">文章标签<span class="tpl-form-line-small-title">Tags</span></label>
                    	 <div class="am-u-sm-9">
                            <select data-placeholder="请选择文章标签" multiple class="chosen-select-width 	my-select" style="height:50px" name="tags[]">
							  @foreach($articleTags as $k)
                                  <option value="{{ $k->id }}" {{ $article->hasTags($k->id)?'selected':''}}>-{{ $k->tag_name}}</option>
                              @endforeach
							</select>
                        </div>
					</div>
					<div class="am-form-group">
                    	<label for="user-phone" class="am-u-sm-3 am-form-label">发布时间<span class="tpl-form-line-small-title">Time</span></label>
                    	 <div class="am-u-sm-9">
                            <input size="16" type="text" name="time" value="{{ date('Y-m-d H:i')}}" readonly class="tpl-form-input form-datetime am-form-field">
                        </div>
					</div>
					<div class="am-form-group">
                    	<label for="user-phone" class="am-u-sm-3 am-form-label">是否展示<span class="tpl-form-line-small-title">Is_Show</span></label>
                    	 <div class="am-u-sm-9">
                    	 	<div class="tpl-switch">
                                <input type="checkbox" class="am-switch" name="is_show" value="1" {{$article->is_show==1?'checked':''}}/>
                                <div class="tpl-switch-btn-view">
                                    <div>
                                    </div>
                                </div>
               				</div>
                        </div>
					</div>
					<div class="am-form-group">
                    	<label for="user-phone" class="am-u-sm-3 am-form-label">是否置顶<span class="tpl-form-line-small-title">Is_Up</span></label>
                    	 <div class="am-u-sm-9">
                    	 	<div class="tpl-switch">
                                <input type="checkbox" class="am-switch" name="is_up" value="1" {{$article->is_up==1?'checked':''}}/>
                                <div class="tpl-switch-btn-view">
                                    <div>
                                    </div>
                                </div>
               				</div>
                        </div>
					</div>
					<div class="am-form-group">
                    	<label for="user-phone" class="am-u-sm-3 am-form-label">是否为博主推荐<span class="tpl-form-line-small-title">Is_Recommend</span></label>
                    	 <div class="am-u-sm-9">
                    	 	<div class="tpl-switch">
                                <input type="checkbox" class="am-switch" name="is_recommend" value="1" {{$article->is_recommend==1?'checked':''}}/>
                                <div class="tpl-switch-btn-view">
                                    <div>
                                    </div>
                                </div>
               				</div>
                        </div>
					</div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">公开(off)/私有(on)<span class="tpl-form-line-small-title">Article_Type</span></label>
                         <div class="am-u-sm-9">
                            <div class="tpl-switch">
                                <input type="checkbox" class="am-switch" name="article_type" value="1" {{$article->article_type==1?'checked':''}} / >
                                <div class="tpl-switch-btn-view">
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">是否为图片文章<span class="tpl-form-line-small-title">Show_type</span></label>
                         <div class="am-u-sm-9">
                            <div class="tpl-switch show_type">
                                <input type="checkbox" class="am-switch" name="show_type" value="2" {{$article->show_type==2?'checked':''}} / >
                                <div class="tpl-switch-btn-view">
                                    <div class="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-form-group more_img" style="display:none">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">文章图片集<span class="tpl-form-line-small-title">Img</span></label>
                            @if(isset($articleImg))
                                @if($articleImg->isEmpty())
                                    <div class="am-u-sm-9 manga-img" count="1">
                                            <div class="am-form-group am-form-file">
                                                <div class="tpl-form-file-img">
                                                </div>
                                                <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                                    <i class="am-icon-cloud-upload"></i> 选择要上传的漫画图片</button>
                                                  <input class="doc-form-file" type="file" multiple name="img[]">
                                            </div>
                                            <div class="file-list">
                                            </div>
                                    </div>
                                @else
                                    <div class="am-u-sm-9 manga-img" count="{{ count($articleImg )}}">
                                        @foreach($articleImg as $k)
                                            <div class="am-form-group am-form-file">
                                                <div class="tpl-form-file-img">
                                                </div>
                                                <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                                    <i class="am-icon-cloud-upload"></i> 选择要上传的漫画图片</button>
                                                  <input class="doc-form-file" type="file" multiple name="{{ 'img_'.$k->id}}">
                                                  <input type="hidden" name="img_id[]" value="{{ $k->id }}">
                                            </div>
                                            <div class="file-list" style="margin-bottom:30px">
                                                @if($k->img)<img src="{{ $k->img }}" alt="" class="title_pic" style="width:500px;height:300px">@endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                            <div class="am-u-sm-9 manga-img" count="1">
                                        <div class="am-form-group am-form-file">
                                            <div class="tpl-form-file-img">
                                            </div>
                                            <button type="button" class="am-btn am-btn-danger am-btn-sm file-list">
                                                <i class="am-icon-cloud-upload"></i> 选择要上传的漫画图片</button>
                                              <input class="doc-form-file" type="file" multiple name="img[]">
                                        </div>
                                        <div class="file-list">
                                        </div>
                            </div>
                            @endif
                            <div class="am-u-sm-9">
                                    <div class="am-form-group am-form-file">
                                        <div class="tpl-form-file-img">
                                        </div>
                                        <button type="button" class="am-btn am-btn-success am-btn-sm add-img">
                                            <i class="am-icon-plus"></i>添加更多</button>
                                    </div>
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
                                    @if($article->cover)<img src="{{ $article->cover }}" alt="" class="title_pic img_style" style="">@endif
                                </div>
                            </div>
                    </div>
                    <div class="am-form-group">
                            <label for="user-intro" class="am-u-sm-3 am-form-label">文章描述</label>
                            <div class="am-u-sm-9">
                                <textarea class="" rows="10" id="user-intro" placeholder="请输入文章描述" name="desc">{{ $article->desc? $article->desc:''}}</textarea>
                            </div>
                    </div>
                    <div class="am-form-group content">
                            <label class="am-u-sm-3 am-form-label">文章内容<span class="tpl-form-line-small-title"></span>
                            </label>
                          <!--   <div class="am-u-sm-9">
                                <select data-am-selected style="width:200px" class="ueditor">
                                    <option value="1">Ueditor编辑器</option>
                                    <option value="2">MarkDown编辑器</option>
                                </select>
                            </div> -->
                           <!--  <div class="am-u-sm-9">
                                <br>
                            </div> -->
                            <div class="am-u-sm-9">
                                <div class="form-group" style="width:800px;">
                                <!--     <textarea style="backgroud:black" class="" id="editor" name="content" style="display:none" ></textarea> -->
                                    <textarea name="content" id="code" cols="30" rows="10">{{$article->content?$article->content:''}}</textarea>
                                </div>
                            </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <a href="{{ url('/admin/article_manage/article') }}" class="am-btn am-btn-warning">返回</a>
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>
                    </div>
                    <div style="height:100px"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="{{ asset('admin/js/amazeui.chosen.js')}}"></script>
<script src="{{ asset('admin/js/amazeui.switch.js') }}"></script>
<script type="text/javascript" src="{{ asset('ueditor/ueditor.config.js') }}" /></script>
<script type="text/javascript" src="{{ asset('ueditor/_examples/editor_api.js') }}" /></script> 
<script type="text/javascript" src="{{ asset('admin/js/amazeui.datetimepicker.min.js') }}" /></script> 
<script type="text/javascript" src="{{ asset('admin/js/ueditor.js') }}" /></script> 
<script type="text/javascript" src="{{ asset('simplemde/debug/simplemde.js') }}"></script>
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
<script>


$(function() {
//tags插件
$('.my-select').chosen({
  	max_selected_options:10

});

//时间插件
var $dpInput = $('.form-datetime').datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoclose: true,
    minuteStep: 10,
    startDate: new Date(),
  });
})
//MarkDown编辑器
 simplemde = new SimpleMDE({
    autofocus: false,//是否自动对焦
    //自定义样式文本块的某些按钮的行为方式
    blockStyles: {
        bold: "__",
        italic: "_"
    },
    element: document.getElementById("code"),//选择器
    indentWithTabs: true,//如果设置为false，则使用空格而不是制表符缩进。默认为true。
    insertTexts: {
        horizontalRule: ["", "\n\n-----\n\n"],
        image: ["![](http://", ")"],
        link: ["[", "](http://)"],
        table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
    },
    lineWrapping: false,//如果设置为false，则禁用换行。默认为true。
    parsingConfig: {
        allowAtxHeaderWithoutSpace: true,
        strikethrough: true,
        underscoresBreakWords: true,
    },
    placeholder: "请使用 Markdown 格式书写 ;-)，代码块请标语言,示例如下，否则无高亮\n```php\n//代码开始\n```\nOK！开始你的创作吧！",
    promptURLs: false,
    //快捷键
    shortcuts: {
        drawTable: "Cmd-Alt-T"
    },
    showIcons: ["code", "table"],
    spellChecker: false,//检查拼音
    status: true,
    status: ["autosave", "lines", "words", "cursor"], // Optional usage
    status: ["autosave", "lines", "words", "cursor", {
        className: "keystrokes",
        defaultValue: function(el) {
            this.keystrokes = 0;
            el.innerHTML = "0 Keystrokes";
        },
        onUpdate: function(el) {
            el.innerHTML = ++this.keystrokes + " Keystrokes";
        }
    }], // Another optional usage, with a custom status bar item that counts keystrokes
    styleSelectedText: false,
    tabSize: 8,
    toolbarTips:true,
});

//初始化判断，如果选中文章图片类型就显示该div
if ($("input[name='show_type']").is(':checked')) {
    $('.more_img').css('display','');
}

$(".show_type").on('click',function(){
    var check = $("input[name='show_type']").is(':checked');
    if (!check) {
        $('.more_img').css('display','');
    }else{
        $('.more_img').css('display','none');
    }
})
$('.add-img').on('click',function(){
    var count = $('.manga-img').attr('count');

    if (count >= 20) {
        alert('超过最大上传量');
        return;
    }
    var that = $(this);
    var img = '<div class="am-form-group am-form-file"><div class="tpl-form-file-img"></div><button type="button" class="am-btn am-btn-danger am-btn-sm"><i class="am-icon-cloud-upload"></i> 选择要上传的漫画图片</button><input class="doc-form-file" type="file" multiple name="img[]"></div><div class="file-list"></div>';

    that.parent().parent().prev('.manga-img').append(img);

    count ++;
    $('.manga-img').attr('count',count);
    
})

</script>
@stop