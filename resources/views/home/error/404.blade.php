<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>跳动的404错误页面_dowebok</title>
    <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/404.css') }}">
    <script src="{{ asset('home/js/404.js') }}"></script>

</head>

<body>
    <div class="dowebok error">
        <div class="container-floud">
            <div class="col-xs-12 ground-color text-center">
                <div class="container-error-404">
                    <div class="clip">
                        <div class="shadow">
                            <span class="digit thirdDigit"></span>
                        </div>
                    </div>
                    <div class="clip">
                        <div class="shadow">
                            <span class="digit secondDigit"></span>
                        </div>
                    </div>
                    <div class="clip">
                        <div class="shadow">
                            <span class="digit firstDigit"></span>
                        </div>
                    </div>
                    <div class="msg">OH!
                        <span class="triangle"></span>
                    </div>
                </div>
                <h2 class="h1">很抱歉，你访问的页面找不到了</h2>
                <p>
                    <a class="tohome" href="{{ url('/blog')}}">返回首页</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>