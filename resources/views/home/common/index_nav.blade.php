<!-- 内容侧边栏开始 -->
    <div class="sidebar">
        <div class="paihang">
            <h2 class="hometitle">博主推荐</h2>
            <ul>
                @foreach($home['recommendArticle'] as $key)
                <li data-scroll-reveal="enter from the left after 0.2s"><b><a href="{{ url('/article/').'/'.$key->id}}" target="_blank">{{ $key->title}}</a></b>
                    <p style="margin-top:0"><i><a href="{{ url('/article/').'/'.$key->id}}" target="_blank"><img src="{{ $key->cover }}"></a></i><span>{{ $key->desc}}</span></p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="aboutme">
            <h2 class="ab_title">关于我</h2>
            <div class="time" style="border:#CCC 2px solid;border-radius:10px;padding-left: 3%;margin-bottom:5px;width:250px;margin-left:30px">
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" name="movie" width="235" height="97" id="movie">
                    <param name="movie" value="/d/file/p/2017-08-21/61590c204d46216b3939d39d57ab7b84.swf">
                    <param name="quality" value="high">
                    <param name="menu" value="false">
                    <embed src="{{ asset('home/article/icons/61590c204d46216b3939d39d57ab7b84.swf') }}" width="235" height="97" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" id="movie" name="movie" menu="false">
                    <param name="wmode" value="Opaque">
                </object>
            </div>
            <div class="ab_con">
                <p>网名：Choice→選 | 喜欢悠闲独自在</p>
                <p>职业：PHP开发工程师、网页设计</p>
                <p>籍贯：广东省—广州市</p>
                <p>邮箱：linyiyuann@163.com</p>
            </div>
        </div>
        <div class="search">
            <div class="am-u-lg-12">
                <div class="am-input-group am-input-group-primary">
                    <input type="text" class="am-form-field">
                  <span class="am-input-group-btn">
                    <button class="am-btn am-btn-secondary" type="button"><span class="am-icon-search"></span></button>
                  </span>
                </div>
            </div>
        </div>
        <div class="cloud">
            <h2 class="hometitle">标签云</h2>
            <ul>
                @foreach($home['articleTags'] as $key)
                    <a href="{{ url('/tags').'/'.$key->id}}">{{ $key->tag_name }}</a>
                @endforeach
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">点击排行</h2>
            <ul>
                @foreach($home['HotsArticle'] as $key)
                <li data-scroll-reveal=" enter from the left after 0.3s"><b><a href="{{ url('/article').'/'.$key->id }}" target="_blank">{{ $key->title }}</a></b>
                    <p style="margin-top:0"><i><a href="{{ url('/article').'/'.$key->id }}" target="_blank"><img src="{{ $key->cover }}"></a></i><span>{{ $key->desc}}</span></p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">友情链接</h2>
            <ul>
                @foreach($home['links'] as $k)
                    <li><a href="{{ $k->url }}" title="{{ $k->title }}" target="_blank">{{ $k->title }}</a></li>
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
    <!-- 内容侧边栏结束 -->