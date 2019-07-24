@extends('home.common.common')


@section('style')
<link rel="stylesheet" href="{{ asset('simplemde/debug/simplemde.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/css/ueditor.css')}}">
<link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
<link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
<style>
  .picbox li img{
   height: 250px;
  }
</style>
@stop

@section('content')
<!-- 博客内容开始 -->
  <h1 class="t_nav"></h1>
  <div class="blogs">
   <div class="news_pl">
            <ul>
              <div class="gbko">
                <div class="comment_header"> </div>
                <ul class="am-comments-list am-comments-list-flip comment_list">

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
                       <textarea  id="code" cols="30" rows="10"></textarea>
                      </div>
                      <div class="share" style="float:right">
                        <button type="button" class="am-btn am-btn-secondary sub_comment" onclick="sendMsg()">发送</button>
                          <button type="button" class="am-btn am-btn-warning" onclick="cls()">一键清屏</button>
                      </div>
                  </li> 
                </ul>
              </div>
            </ul>
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

var ws;

$(function(){
  username = "{{ userInfo()['nickname'] ??'' }}";//声明被回复者的user_id
  user_id = "{{ userInfo()['id'] ?? '' }}";//声明用户id
  user_avatar = "{{ userInfo()['avatar'] ?? '' }}";//声明用户id
  time = "{{ date('Y-m-d H:i:s',time()) }}";
  link();
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
    placeholder: "请使用 Markdown 格式书写 （Enter 发送；Enter + Shift 换行） ;-)",
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

 //websock
function link () {
     if(user_id == '') return;
      ws = new WebSocket("ws://localhost:9501");//连接服务器
      console.log(ws);
      ws.onopen = function(event){
          var msg = {};
          msg.nickname = username;
          msg.type = 'joinMessage';
          data = JSON.stringify(msg);
          ws.send(data);
      };
      ws.onmessage = function (event) {
          var msg = JSON.parse(event.data);
          if (msg['type'] == 'sendMessage'){
              var isMe = ''
              if (user_id != msg.user_id) { isMe='am-comment-flip' }
              var str = '<li class="am-comment '+isMe+'"><a href="#link-to-user-home"><img src="'+msg.user_avatar+'" alt="" class="am-comment-avatar" width="48" height="48"/></a><div class="am-comment-main"><header class="am-comment-hd"><div class="am-comment-meta"><a href="#link-to-user" class="am-comment-author">'+msg.username+'</a><time style="float:right">'+msg.time+'</time></div><div class="am-comment-actions"><a href="javascript:;"class="del"></a></div></header><div class="am-comment-bd">'+msg.data+'</div></li>';
              $('.comment_list').append(str);
              doPrism();//加载prism样式
          }else if(msg['type'] == 'joinMessage'){
              if (!msg['nickname'] || msg['nickname'] != undefined) {
                  var str = '<p style="text-align: center;color: #faa8a8">欢迎 '+ msg['nickname']+'加入聊天室</p>';
                  $('.comment_header').append(str);
              }

          }

      }
      ws.onclose = function(event){alert("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};

      ws.onerror = function(event){alert("WebSocket异常！");};
}

//发送方法
function sendMsg(){
    var msg = {};
    if (user_id == '') { alert('请先登录'); return;}
    msg.username = username;
    msg.data = simplemde.value();
    msg.user_id = user_id;
    msg.user_avatar = user_avatar;
    msg.time = time;
    msg.type = 'sendMessage';
    data = JSON.stringify(msg)
    ws.send(data);
    simplemde.value('');
}

//监听shirt+enter发送按键
$(document).keyup(function(event){
    if (!event.shiftKey){
        if(13 == event.keyCode){
            sendMsg();
        }
    }

 });

//清屏操作
function cls(){
    $('.comment_list').html('');
    $('html,body').animate({scrollTop: '0px'}, 800);
}
</script>
@stop