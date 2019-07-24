<html lang="zh-CN"><head>
    <meta charset="UTF-8">
    <title>用户登录</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="Keywords" content="网站关键词">
    <meta name="Description" content="网站介绍">
    <meta name="Redirect_url" content="{{ $redirect_url }}">
    <link rel="stylesheet" href="{{ asset('home/css/login/base.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/login/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/login/reg.css') }}">
    <link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <style>

        .fa{
                font-size: 40px;
                color: #e5e5e5;
                display: inline-block;
                vertical-align: middle;
        }
        .fa:hover{
            background: red;
        }
    </style>
</head>
<body>
<div id="particles"><canvas class="particles-js-canvas-el" width="1747" height="414" style="width: 100%; height: 100%;"></canvas></div>
<div id="ajax-hook"></div>
<div class="wrap">
    <div class="wpn">
        <div class="form-data pos" data-scroll-reveal="enter bottom and move 50px over 1s">
            <a href=""><img src="" class="head-logo"></a>
            <div class="change-login" data-scroll-reveal="enter bottom and move 50px over 1.33s">
                <p class="account_number on">账号登录</p>
                <p class="message">账号注册</p>
            </div>
            <div class="form1" data-scroll-reveal="enter bottom and move 50px over 2.33s">
                <p class="p-input pos">
                    <label for="num" style="">手机号/用户名/UID/邮箱</label>
                    <input type="text" id="num">
                    <span class="tel-warn num-err hide"><em>账号或密码错误，请重新输入</em><i class="icon-warn"></i></span>
                </p>
                <p class="p-input pos">
                    <label for="pass">请输入密码</label>
                    <input type="password" style="display:none">
                    <input type="password" id="pass" autocomplete="new-password">
                    <span class="tel-warn pass-err hide"><em>账号或密码错误，请重新输入</em><i class="icon-warn"></i></span>
                </p>
            </div>
            <div class="form2 hide">
                <p class="p-input pos">
                    <label for="num2">手机号</label>
                    <input type="number" id="num2">
                    <span class="tel-warn num2-err hide"><em>账号或密码错误</em><i class="icon-warn"></i></span>
                </p>
                <p class="p-input pos"> 
                    <label for="veri-code">输入手机验证码</label>
                    <input type="number" id="veri-code">
                    <a href="javascript:;" class="send ">发送验证码</a>
                    <span class="time hide"><em>120</em>s</span>
                    <span class="tel-warn error hide">验证码错误</span>
                </p>
                <p class="p-input pos code">
                    <label for="veri">请输入验证码</label>
                    <input type="text" id="veri">
                    <span class="" style="cursor:pointer">
                        <img src="{{ captcha_src()}}" onclick="this.src='/captcha/default?'+Math.random()" height="50">
                    </span>
                    <span class="tel-warn img-err hide"><em>验证码错误</em><i class="icon-warn"></i></span>
                    <span class="tel-succ img-succ hide"><em>验证码正确</em><i class="icon-succ"></i></span>
                    <!-- <a href="javascript:;">换一换</a> -->
                </p>
            </div>
            <div class="r-forget cl" data-scroll-reveal="enter bottom and move 50px over 3.33s">
                <a href="./getpass.html" class="y">忘记密码</a>
            </div>
            <button class="lang-btn off log-btn" data-scroll-reveal="enter bottom and move 50px over 3.33s">登录</button>
            <div class="third-party" data-scroll-reveal="enter bottom and move 50px over 4.33s">
                <a href="#" class="log-qq icon-qq-round"></a>
                <a href="#" class="log-qq icon-weixin"></a>
                <a href="#" class="log-qq icon-sina1"></a>
            </div>
            <p class="right">Powered by © 2018</p>
        </div>
    </div>
</div>
<script async="" src="https://www.google-analytics.com/analytics.js"></script>
<script src="{{ asset('home/js/particles.min.js') }}"></script>
<script src="{{ asset('home/js/login/jquery.js') }}"></script>
<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script src="{{ asset('home/js/login/agree.js') }}"></script>
<script src="{{ asset('home/js/login/login.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/article/js/scrollReveal.js') }}"></script>
<script>
    //加载缓冲样式
    window.scrollReveal = new scrollReveal();
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-81634754-1', 'auto');
    ga('send', 'pageview');
</script>
<script>
    particlesJS("particles", {
        "particles": {
            "number": {
                "value": 10,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#52697f"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.1,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 20,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 20,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 1000,
                "color": "#52697f",
                "opacity": 0.2,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 4,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": false,
                    "mode": "grab"
                },
                "onclick": {
                    "enable": false,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 140,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
</script>

</body></html>