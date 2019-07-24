<div class="sidebar">
    <div class="search">
      <form action="/e/search/index.php" method="post" name="searchform" id="searchform">
        <input name="keyboard" id="keyboard" class="input_text" style="color: rgb(153, 153, 153);" onfocus="if(value=='请输入要搜索的文章'){this.style.color='#000';value=''}" onblur="if(value==''){this.style.color='#999';value='请输入要搜索的文章'}" type="text" placeholder="请输入要搜索的文章">
        <input name="show" value="title" type="hidden">
        <input name="tempid" value="1" type="hidden">
        <input name="tbname" value="news" type="hidden">
        <input name="Submit" class="input_submit" value="搜索" type="submit">
      </form>
    </div>
    <div class="lmnav">
      <h2 class="hometitle">分类导航</h2>
      <ul class="navbor">
        @foreach($sidebar['articleType'] as $key => $value)
        <li data-scroll-reveal=" enter from the left after 0.5s"><a href="{{ url('/type').'/'.$key}}">{{ $value['type_name'] }}</a>
          @if(!empty($value['list']))
            <ul>
              @foreach($value['list'] as $k => $v)
                <li><a href="{{ url('/type').'/'.$k}}">{{ $v['type_name']}}</a></li>
              @endforeach
            </ul>
          @endif
        </li>
        @endforeach
      </ul>
    </div>
    <div class="cloud">
      <h2 class="hometitle">标签云</h2>
      <ul>
          @foreach($sidebar['articleTags'] as $k)
           <a href="{{ url('/tags').'/'.$k->id}}">{{ $k->tag_name }}</a>
          @endforeach
      </ul>
    </div>
    <div class="paihang">
      <h2 class="hometitle">点击排行</h2>
      <ul>
        @foreach($sidebar['articleClickDescList'] as $k)
          <li data-scroll-reveal=" enter from the left after 0.25s"><b><a href="{{ url('/article/'.$k->id)}}">{{ $k->title}}</a></b>
            <p style="margin-top:0"><i><a href="{{ url('/article/'.$k->id)}}"><img src="{{ $k->cover }} "></a></i><span>{{ $k->desc}}</span></p>
          </li>
        @endforeach
      </ul>
    </div>
    <div class="paihang">
        <h2 class="hometitle">关注我</h2>
        <ul>

            <span  data-scroll-reveal=" enter from the left after 0.25s" class="social-widget-link social-link-weibo"> <span class="social-widget-link-count"><i class="am-icon-weibo"></i>狗达微博</span> <span class="social-widget-link-title">新浪微博</span> <a href="https://weibo.com/u/3118916401" target="_blank" rel="nofollow"></a></span>

            <span data-scroll-reveal=" enter from the left after 0.5s" class="social-widget-link social-link-tencent-weibo"> <span class="social-widget-link-count"><i class="am-icon-github"></i>喜欢悠闲独自在</span> <span class="social-widget-link-title">GitHub</span> <a href="https://github.com/linyiyuan" target="_blank" rel="nofollow"></a> </span>

            <span data-scroll-reveal=" enter from the left after 0.75s" class="social-widget-link social-link-qq"> <span class="social-widget-link-count"><i class="am-icon-qq"></i>375133100</span> <span class="social-widget-link-title">QQ号</span> <a id="tooltip-s-weixin" href="javascript:void(0);"></a> </span>

            <span data-scroll-reveal=" enter from the left after 1s" class="social-widget-link social-link-email"> <span class="social-widget-link-count"><i class="icon-mail"></i>linyiyuann@163.com</span> <span class="social-widget-link-title">QQ邮箱</span> <a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&amp;email=393593897@qq.com" target="_blank" rel="nofollow"></a> </span>

            <span data-scroll-reveal=" enter from the left after 1.25s" class="social-widget-link social-link-wechat"> <span class="social-widget-link-count"><i class="am-icon-wechat"></i>13211035441</span> <span class="social-widget-link-title">微信</span> <a id="tooltip-s-weixin" href="javascript:void(0);"></a> </span>

        </ul>
    </div>
  </div>