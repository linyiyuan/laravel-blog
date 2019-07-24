@extends('home.common.common')


@section('style')
<link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
@stop

@section('content')
<!-- 博客内容开始 -->
  <h1 class="t_nav"></h1>
  <div class="blogs">
    <div class="mt20"></div>
    @foreach($article as $key)
      <li data-scroll-reveal="enter top and move 50px over {{ (array_search($key,$article) * 0.25) + 1 }}s"><span class="blogpic"><a href="{{ url('/article').'/'.$key->id}}"><img src="{{ $key->cover}}" style="height:160px"></a></span>
        <h3 class="blogtitle"><a href="{{ url('/article').'/'.$key->id}}">{{ $key->title}}</a></h3>
        <div class="bloginfo">
          <p>{{ $key->desc }}</p>
        </div>
        <div class="autor">
          <span class="lm">
            @foreach($key->tags as $k)
              <a href="{{ url('/blog')}}" title="" target="_blank" class="classname">{{ $k->tag_name}}</a>
            @endforeach
          </span>
          <span class="dtime">{{ date('Y-m-d',$key->time)}}</span>
          <span class="viewnum">浏览（<a href="/">{{ $key->click}}</a>）</span>
          <span class="readmore"><a href="{{ url('/article').'/'.$key->id}}">阅读文章</a></span>
        </div>
      </li>
    @endforeach
    <div class="pagelist">
        <a title="Total record">&nbsp;<b>{{ $page['total'] }}</b> </a>&nbsp;&nbsp;&nbsp;
          <a href="{{ $page['nowPage']!=1?url('/'.Request::path()).'?page='.($page['nowPage'] - 1):'javascript:;'}}">上一页</a>&nbsp;
          <!-- <b>1</b>&nbsp;<a href="/download/index_2.html">2</a>&nbsp; -->
          <a href="{{ $page['nowPage']<$page['totalPage']?url('/'.Request::path()).'?page='.($page['nowPage'] + 1):'javascript:;'}}">下一页</a>
          <a title="Total record">&nbsp;<b>{{ $page['nowPage'].'/'.$page['totalPage'] }}</b> </a>
    </div>

  </div>
	@include('home.common.right_nav')

@stop


@section('javascript')
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>


@stop