<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>狗达与佩唲</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('home/css/amazeui.css') }}">
    <link href=" {{ asset('home/article/css/base.css') }}" rel="stylesheet">
    <link href=" {{ asset('home/article/css/index.css') }}" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('home/article/css/carouse.css') }}">
    <link rel="stylesheet" href="{{ asset('home/article/icons/entypo.css') }}">
    <link rel="stylesheet" href=" {{ asset('home/article/css/navtool.css') }}">
    <link href=" {{ asset('home/article/css/m.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="http://paan0ksle.bkt.clouddn.com//admin/user/2018-06-14-07-04-15-5b22136fc5d0c.jpeg">
    <link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{ asset('home/article/js/scrollReveal.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="js/modernizr.js"></script>
    <![endif]-->
    <script>
    window.onload = function() {
        var oH2 = document.getElementsByTagName("h2")[0];
        var oUl = document.getElementsByTagName("ul")[0];
        oH2.onclick = function() {
            var style = oUl.style;
            style.display = style.display == "block" ? "none" : "block";
            oH2.className = style.display == "block" ? "open" : ""

        }
    }
    </script>

    @section('style')
    @show

    <style>
        .model-2 i{
            font-size: 22px;
            /*position: absolute;*/
        }
    </style>
</head>

<body>
<!-- 头部开始 -->
<header>
    @include('home.common.header')
</header>
<!-- 头部结束 -->

<!-- 内容开始 -->
<article>
    @yield('content')
</article>
<!-- 内容结束 -->

<!-- 底部开始 -->
<footer>
    @if(userInfo())
        <div class="model-2" data-scroll-reveal=" enter top after 0.3s">
            <div class="float-btn-group open">
                <button class="btn-float btn-triger">
                    <img src="{{ userInfo()['avatar']}}" alt="" style="width:50px,!important;height:50px;border-radius:50%">
                </button>
                <div class="btn-list">
                    <a href="{{ url('/')}}"></a>
                    <a href="{{ url('/info') }}" class="btn-float yellow"><i class="fa fa-edit"> </i></a>
                <a href="{{ url('/info/msg')}}" class="btn-float purple"><i class="fa fa-commenting-o "> </i></a>
                <a href="{{ url('/info/fav')}}" class="btn-float green"><i class="fa fa-thumbs-o-up "> </i></a>
                <a href="javascript:;" class="btn-float blue logout"><i class="fa fa-reply"></i></a>
            </div>
            </div>
        </div>
    @else
        <div class="model-2">
            <div class="float-btn-group open">
                <button class="btn-float btn-triger pink">
                    <i class="fa fa-home"></i>
                </button>
                <div class="btn-list">
                    <a href="{{ url('/')}}"></a>
                    <a href="{{ url('/blog/OAuth/qq')}}" class="btn-float blue"><i class="fa fa-qq"></i></a>
                    <a href="{{ url('/blog/OAuth/weibo')}}" class="btn-float weibo"><i class="fa fa-weibo"> </i></a>
                    <a href="{{ url('/blog/OAuth/github')}}" class="btn-float black"><i class="fa fa-github"></i></a>
                    <a href="{{ url('/blog/login')}}" class="btn-float purple"><i class="fa fa-user"> </i></a>
                </div>
            </div>
        </div>
    @endif
    @include('home.common.footer')
</footer>
<!-- 底部结束 -->

<script src="{{ asset('home/article/js/jquery-2.1.1.min.js ')}}"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script src="{{ asset('home/article/js/slider.js ')}}"></script>
<script src="{{ asset('home/article/js/hammer.min.js ')}}"></script>
<script src="{{ asset('admin/js/amazeui.min.js') }}"></script>
<script src="{{ asset('home/article/js/canvas.js ')}}"></script>
<script>
window.scrollReveal = new scrollReveal();
//声明滚动样式
$('.btn-triger').click(function() {
    $(this).closest('.float-btn-group').toggleClass('open');
});

//清除cookie
$('.logout').click(function(){
    // $.removeCookie('_token')
    $.removeCookie('userinfo',{path:'/'});
    location.href = "/blog"; 
})

//侧边导航栏插件
$(document).ready(function (ev) {
        var toggle = $('#ss_toggle');
        var menu = $('#ss_menu');
        var rot;
        $('#ss_toggle').on('click', function (ev) {
            rot = parseInt($(this).data('rot')) - 180;
            menu.css('transform', 'rotate(' + rot + 'deg)');
            menu.css('webkitTransform', 'rotate(' + rot + 'deg)');
            if (rot / 180 % 2 == 0) {
                toggle.parent().addClass('ss_active');
                toggle.addClass('close');
            } else {
                toggle.parent().removeClass('ss_active');
                toggle.removeClass('close');
            }
            $(this).data('rot', rot);
        });
        menu.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
            if (rot / 180 % 2 == 0) {
                $('#ss_menu div i').addClass('ss_animate');
            } else {
                $('#ss_menu div i').removeClass('ss_animate');
            }
        });
        
});

</script>
@section('javascript')

@show

</body>

</html>