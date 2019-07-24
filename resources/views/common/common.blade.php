<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="icon" type="image/png" href="{{ asset('admin/i/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('admin/i/app-icon72x72@2x.png') }}">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="{{ asset('admin/css/amazeui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/amazeui.switch.css') }}">
    <link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
    <script src="{{ asset('admin/js/echarts.min.js') }}"></script>
    <style>
        .am-pureview{
            z-index: 1600;
        }
    </style>
    @section('style')
        <!-- 自定义样式 -->
    @show
</head>
<body data-type="index" class="theme-white">
    <!-- 头部部门 -->
    <header class="am-topbar am-topbar-inverse admin-header">
        @include('common.header')
    </header>
    
    <!-- 内容部分 -->
    <div class="tpl-page-container tpl-page-header-fixed">
        <!-- 左侧导航部分 -->
        <div class="tpl-left-nav tpl-left-nav-hover">
            @include('common.menu')
        </div>
        <!-- 右侧内容部分 -->
        <div class="tpl-content-wrapper">
            @include('common.message')
            @yield('content')
        </div>
    </div>   
</body>
<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/amazeui.min.js') }}"></script>
<script src="{{ asset('admin/js/iscroll.js') }}"></script>
<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>
<script>
    var fullscreen = $.AMUI.fullscreen;
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    var fullscreen = $.AMUI.fullscreen
    // 加载进度条
    $(document).ready(function(){
        $.AMUI.progress.start();
    });

    // 结束进度条
    window.onload = function(){
        $.AMUI.progress.done();
    };

    $(function() {
        //实现显示选择图片缩略图
        $('.tpl-block').on('change','.doc-form-file', function() {
          var that = $(this);
          var fileNames = '';
          // $.each(this.files, function() {
          //   fileNames += '<span class="am-badge"><img src="'+ this.name +'"></span> ';
          // });
          // $('#file-list').html(fileNames);
          var file = this.files[0];
            function getObjectURL(file) {
                var url = null;
                    if (window.createObjectURL != undefined) { // basic
                        url = window.createObjectURL(file);
                    }
                    else if (window.URL != undefined) {
                        url = window.URL.createObjectURL(file);
                    }
                    else if (window.webkitURL != undefined) {
                        url = window.webkitURL.createObjectURL(file);
                    }   
                return url;
             }
            var url = getObjectURL(file);
            fileNames = '<div class="tpl-form-file-img" style="margin-bottom:30px"><img src="'+ url +'" style="width:500px;height:300px"></div> ';

            that.parent().next('.file-list').html(fileNames);
        });

      });
</script>
@section('javascript')
    <!-- 自定义js -->
@show
</html>