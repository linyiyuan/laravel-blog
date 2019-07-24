<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="狗达,佩唲,个人博客,Laravel,狗达与佩唲">
    <meta name="author" content="Jiajian Chan">
    <meta name="description" content="狗达与佩唲的个人博客">

    <title>Welcome To PJ Blog!</title>
    <link rel="shortcut icon" href="http://paan0ksle.bkt.clouddn.com//admin/user/2018-06-14-07-04-15-5b22136fc5d0c.jpeg">

    <link rel="stylesheet" href="{{ asset('home/css/home/home.css') }}">

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }
        #particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .full-height {
            background-color: #fff;
            color: #6289ad;
            font-family: 'Raleway';
            font-weight: 100;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            z-index: 100;
            margin-bottom: 15vh;
        }

        .title {
            font-size: 84px;
        }

        .description {
            margin: 30px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .links > a {
            color: #9caebf;
            padding: 0 25px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .links > a:hover {
            color: #52697f;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .avatar {
            width: 120px !important;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div id="particles"><canvas class="particles-js-canvas-el" width="1747" height="414" style="width: 100%; height: 100%;"></canvas></div>
    <div class="content">
        <div class="title m-b-md" data-scroll-reveal="enter bottom and move 50px over 1.33s">
            <img class="avatar img-circle" src="http://images.linyiyuan.top//admin/user/2018-07-12-14-18-33-5b46f2b944b8e.jpeg" alt="Pig Jian">
        </div>

        <div class="description" data-scroll-reveal="enter bottom and move 50px over 2.33s">
            Welcome To My Blog
        </div>

        <div class="links">
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s" href="{{ url('/blog')}}">Blog</a>
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s" href="http://resume.linyiyuan.top/">Resume</a>
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s"target="_blank" href="https://weibo.com/u/3118916401">Weibo</a>
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s"target="_blank" href="https://github.com/linyiyuan">GitHub</a>
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s"href="/about">Me</a>
            <a data-scroll-reveal="enter bottom and move 50px over 3.33s" href="{{ url('/blog/login') }}">Login</a>
        </div>
    </div>
</div>

<script async="" src="https://www.google-analytics.com/analytics.js"></script>
<script src="{{ asset('home/js/particles.min.js') }}"></script>
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
</body>
</html>