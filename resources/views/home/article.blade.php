@extends('home.common.common')


@section('style')
<link rel="stylesheet" href="{{ asset('simplemde/debug/simplemde.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/css/ueditor.css')}}">
<link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
<link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
<style>
.news_con a{
  color:#095f8a;
}
.comment:before, .comment:after {
    position: absolute;
    top: 10px;
    left: -8px;
    right: 100%;
    width: 0;
    height: 0;
    display: block;
    content: " ";
    pointer-events: none;
}

</style>
@stop

@section('content')
<!-- 博客内容开始 -->
    <h1 class="t_nav"></h1>
  <div class="about_me" style="margin-top:20px" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
      <div class="infosbox">
        <main>
        <div class="newsview">
          <h3 class="news_title">{{ $article->title}}</h3>
          <div class="news_author">
            <span class="au01">
              <a href="mailto:dancesmiling@qq.com">{{ $article->author}}</a>
            </span>
            <span class="au02">{{ date('Y-m-d',$article->time)}}</span><span class="au03">共<b>{{ $articheWatch }}</b>人围观
            </span>
          </div>
          <div class="tags">
            @foreach($article->tags as $k => $v)
            <a href="{{ url('tags').'/'.$v['id']}}" target="_blank">{{ $v['tag_name'] }}</a> &nbsp;
            @endforeach
          </div>
          <div class="news_about"><strong>简介</strong>{{ $article->desc}}</div>
          <div class="news_con">{!! $article->content !!}</div>
        </div>
          <div class="share">
            <p class="diggit"><a href="javascript:;" class="praise" data-id="{{ $article->id }}"> 很赞哦！ </a>(<b id="diggnum">{{ $articlePraise ?? '0' }}</b>)</p>
          </div>
          <div class="nextinfo">
            <p>上一篇：
                @if(is_null($articleList['preArticle']))
                    <a href="javascript:;">无</a>
                @else
                    <a href="{{ url('/article').'/'.$articleList['preArticle']->id}}">{{ $articleList['preArticle']->title}}</a>
                @endif
              
            </p>
            <p>下一篇：
                @if(is_null($articleList['nextArticle']))
                    <a href="/blog">返回首页</a>
                @else
                    <a href="{{ url('/article').'/'.$articleList['nextArticle']->id}}">{{ $articleList['nextArticle']->title}}</a>
                @endif
            </p>
          </div>
          <div class="otherlink">
              <h2>相关文章</h2>
              <ul>
                @foreach($articleList['articleRelevant'] as $k)
                <li><a href="{{ url('/article').'/'.$k->id}}" title="{{ $k->title}}">{{ $k->title}}</a></li>
                @endforeach
              </ul>
          </div>
          <div class="news_pl">
            <h2>文章评论</h2>
            <ul>
              <div class="gbko"> 
                <ul class="am-comments-list am-comments-list-flip comment_list">
                  @foreach($articleComment as $k)
                    <li class="am-comment {{ $k->type==2?'am-comment-flip':''}}">
                      <a href="#link-to-user-home">
                        <img src="{{ $k->avatar}}" alt="" class="am-comment-avatar" width="48" height="48"/>
                      </a>

                      <div class="am-comment-main">
                        <header class="am-comment-hd">
                          <!--<h3 class="am-comment-title">评论标题</h3>-->
                          <div class="am-comment-meta">
                            <a href="#link-to-user" class="am-comment-author">{{ $k->nickname }}</a>
                            评论于 <time>{{ $k->created_at}}</time>
                          </div>
                          @if(userInfo())
                            @if(userInfo()['id'] == $k->user_id)
                              <div class="am-comment-actions">
                                <a href="javascript:;" comment-id="{{ $k->id }}" class="del"><i class="am-icon-trash"></i></a> 
                              </div>
                            @endif
                          @endif
                        </header>

                        <div class="am-comment-bd">
                          {!! $k->comment !!}
                        </div>
                        <div class="am-comment-footer">
                          <div class="am-comment-actions">
                            <a href="javascript:;"><i class="am-icon-thumbs-up"></i></a> 
                            <a href="javascript:;"><i class="am-icon-thumbs-down"></i></a> 
                            @if(userInfo() && userInfo()['id'] != $k->user_id )
                              <a href="#comment_pos" class="reply" date-name="{{$k->nickname}}" data-user-id="{{ $k->user_id }}" data-id="{{ $k->id }}"><i class="am-icon-reply"></i></a>
                            @endif
                          </div>
                        </div>
                      </div>
                  </li>
                  @endforeach
                </ul>
                <ul class="am-comments-list am-comments-list-flip" id="comment_pos">
                  <li class="am-comment">
                      <a href="#link-to-user-home">
                       @if(userInfo())
                          <img src="{{ userInfo()['avatar']}}" alt="" class="am-comment-avatar" width="48" height="48"/>
                       @else
                          <img src="http://paan0ksle.bkt.clouddn.com//admin/user/2018-06-14-07-04-15-5b22136fc5d0c.jpeg" alt="" class="am-comment-avatar" width="48" height="48"/>
                       @endif
                      </a>
                      <div class="am-comment-main comment" style="margin-right:0;border:0">
                       <textarea name="content" id="code" cols="30" rows="10"></textarea>
                      </div>
                      <div class="share" style="float:right">
                        <button type="button" class="am-btn am-btn-secondary sub_comment">评论</button>
                      </div>
                  </li> 
                </ul>
              </div>
            </ul>
          </div>
        </main>
    </div>
  </div>
	@include('home.common.right_nav')

@stop

@section('javascript')
<script src="{{ asset('admin/js/prism.js') }}"></script>
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('simplemde/debug/simplemde.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/ueditor.js') }}" /></script> 
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
<script>
$(function(){
  user_id = '';//声明被回复者的user_id
  comment_id = '';//声明评论id
  doPrism();//加载prism样式
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
    placeholder: "请使用 Markdown 格式书写 ;-)",
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
//提交评论
$('.sub_comment').on('click',function(){
  var userinfo = $.cookie('userinfo');
  var content = simplemde.value();
  var article_id = "{{ $article->id }}";
  if (userinfo == undefined || userinfo == null) {
    location.href = "/blog/login"; 
  }else{
    userinfo = JSON.parse(userinfo);
    $.ajax({
            url: '/api/comment',
            type: 'post',
            dataType: 'json',
            data: {access_token:userinfo['access_token'],content:content,article_id:article_id,user_id:user_id,comment_id:comment_id},
            success:function(data){
               if (data.code == 200) {
                  var type = '';
                  if (data.data.type == 2) { type = 'am-comment-flip'}
                  var str = '<li class="am-comment '+type+'"><a href="#link-to-user-home"><img src="'+data.data.user_img+'" alt="" class="am-comment-avatar" width="48" height="48"/></a><div class="am-comment-main"><header class="am-comment-hd"><div class="am-comment-meta"><a href="#link-to-user" class="am-comment-author">'+data.data.username+'</a>评论于 <time>'+data.data.created_at+'</time></div><div class="am-comment-actions"><a href="javascript:;" comment-id="'+data.data.id+'" class="del"><i class="am-icon-trash"></i></a></div></header><div class="am-comment-bd">'+data.data.comment+'</div><div class="am-comment-footer"><div class="am-comment-actions"><a href="javascript:;"><i class="am-icon-thumbs-up"></i></a> <a href="javascript:;"><i class="am-icon-thumbs-down"></i></a><a href="javascript:;" class="reply" date-name="'+data.data.username+'" data-user-id="'+data.data.user_id+'" data-id="'+data.data.id+'"><i class="am-icon-reply"></i></a></div></div></div></li>';
                   $('.comment_list').append(str);
                   doPrism();3
                   simplemde.value('');
               }else if(data.code == 500){
                   alert(data.data);
                }
            },
            error:function(){
            }
    });
  }
})

//回复信息
$('.news_pl').on('click','.reply',function(){
  var self = $(this);
  var reply_name = self.attr('date-name');
  user_id = self.attr('data-user-id');//被回复者的id
  comment_id = self.attr('data-id');
  simplemde.value('@'+reply_name+' ');
})

//删除评论
$('.news_pl').on('click','.del',function(){
  var self = $(this);
  var comment_id = self.attr('comment-id');
  var userinfo = $.cookie('userinfo');
  userinfo = JSON.parse(userinfo);
  if (userinfo == undefined || userinfo == null) {
    return;
  }
  if (confirm('确定删除该评论？')) {
    $.ajax({
        url: '/api/comment/del/'+comment_id,
        type: 'delete',
        dataType: 'json',
        data: {access_token:userinfo.access_token,comment_id:comment_id},
        success:function(data){
          if (data.code == 200) {
            self.parent().parent().parent().parent().remove();
          }else{
            alert('data.data');
          }
        },
        error:function(){
          alert('网络错误');
        }
    });
  }
});
$('.praise').on('click',function(){
    var userinfo = $.cookie('userinfo');
    userinfo = JSON.parse(userinfo);
    if (userinfo == undefined || userinfo == null) {
        alert('请先登录');
    }
    user_id = userinfo['id'];
    article_id = $(this).attr('data-id');
    $.ajax({
        url: '/api/article/praise/',
        type: 'post',
        dataType: 'json',
        data: {user_id:user_id,article_id:article_id},
        success:function(data){
            if (data.code == 200) {
                $('#diggnum').text(data.data)
            }else{
                alert(data.data);
            }
        },
        error:function(){
            alert('网络错误');
        }
    });
});
</script>

@stop