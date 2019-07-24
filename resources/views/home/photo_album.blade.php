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
  <div class="picbox">
    @foreach($list as $key => $value)
    <ul>
      @foreach($value as $k)
      <li data-scroll-reveal="enter top and move 50px over 0.6s" ><a href="{{ url('photo').'/'.str_replace(' ','-',Pinyin::sentence($k['name']))}}"><i><img src="{{ $k['cover'] }}"></i>
        <div class="picinfo">
          <h3>{{ $k['name'] }}</h3>
          <span>{{ $k['desc']}}</span> </div>
        </a>
      </li>
      @endforeach
    </ul>
    @endforeach
  </div>
	

@stop


@section('javascript')
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>


@stop