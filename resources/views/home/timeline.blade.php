@extends('home.common.common')


@section('style')
<link rel="stylesheet" href="{{ asset('home/article/css/timeline.css')}}">
<link rel="stylesheet" href="{{ asset('home/article/css/shake.css')}}">
<style>
 #list2{
 	margin-top: 20px;
 }
</style>
@stop

@section('content')
<!-- 博客内容开始 -->
  <h1 class="t_nav"></h1>
	
<div class="box">		
		<ul class="event_list">
			@foreach($list as $key => $value)
				<div>
					<h3>{{ $key }}</h3>
					@foreach($value as $k => $v)
						<li data-scroll-reveal="enter from the left after 0.1s">
							<span>{{ date('Y年m月d日',strtotime($k)) }}</span>
							<p><span><a href="{{ url('/article/').'/'.$v['id']}}" class="shake shake-opacity">{{ $v['title']}}</a></span></p>
						</li>
					@endforeach
				</div>
			@endforeach
		</ul>
	
		<div class="clearfix"></div>
		
	</div>
	@include('home.common.right_nav')

@stop


@section('javascript')


@stop