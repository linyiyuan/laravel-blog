@extends('home.common.common')


@section('style')
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
  <div class="about_me" style="margin-top:20px" data-am-widget="gallery" data-am-gallery="{ pureview: true }">
      <div class="infosbox">
        <main>
          <div class="newsview">
            <h3 class="news_title">个人简历</h3>
            <div class="news_author">
              <span class="au01">
                <a href="mailto:dancesmiling@qq.com">林益远</a>
              </span>
            </div>
          </div>
        </main>
      </div>
  </div>
	

@stop


@section('javascript')
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>


@stop