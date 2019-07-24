@extends('home.common.common')


@section('style')
<style>
    .is_up {
            background-color: #FF5E52;
            margin: -1px 0 0 0;
            display: inline-block;
            padding: 4px 15px;
            color: #fff;
            font-size: 14px;
            font-weight: normal;
            float:right;
            margin-top: -18px;
            margin-right: -18px;
            cursor: pointer;
        }
    .is_up:hover{
        transform:rotate(360deg);
        transition-duration: 1s,1s,1s,1s,1s,1s;
    }
    .news_con img{
        max-width: 650px;
        height: auto;
        border: 0;
    }
</style>
@stop

@section('content')
<!-- 博客内容开始 -->
    <div class="blogs">
        <div class='o-sliderContainer hasShadow ' id="pbSliderWrap3">
            <div class='o-slider' id='pbSlider3'>
            	@foreach($home['carousel'] as $key)
                <a href="{{ $key->type==3?url('/article/').'/'.$key->third_id:$key->url}}">
                    <div class="o-slider--item" data-image="{{ $key->cover}}">
                        <div class="o-slider-textWrap">
                            <h1 class="o-slider-title">{{ $key-> title}}</h1>
                            <span class="a-divider"></span>
                            <h2 class="o-slider-subTitle">{{ $key->sub_title}}</h2>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @foreach($home['article'] as $key)
        <li data-scroll-reveal="enter top and move 50px over 0.6s">@if($key->is_up == 1)<strong class="is_up">博主置顶</strong>@endif<span class="blogpic"><a href="{{ url('/article').'/'.$key->id}}"><img style="height:170px" src="{{ $key->cover}}"></a></span>
            <h3 class="blogtitle"><a href="{{ url('/article').'/'.$key->id}}">{{ $key->title }}</a></h3>
            <div class="bloginfo">
                <p>{{ $key->desc}}</p>
            </div>
            <div class="autor">
	            <span class="lm">
	            	@foreach($key->tags as $k)
	            		 <a href="{{ url('/tags').'/'.$k->id}}" title="" target="_blank" class="classname">{{ $k->tag_name}}</a>
	            	@endforeach
	            </span>
	            <span class="dtime">{{ date('Y-m-d',$key->time)}}</span>
	            <span class="viewnum">浏览（<a href="javascript:;">{{ $key->click }}</a>）</span>
	            <span class="readmore"><a href="{{ url('/article/') .'/'.$key->id}}">阅读文章</a></span>
       		 </div>
             <div class="post-top"></div>
        </li>
        @endforeach
    </div>

	@include('home.common.index_nav')

@stop


@section('javascript')
<script>
//轮播图样式
$('#pbSlider3').pbTouchSlider({
    slider_Wrap: '#pbSliderWrap3',
    slider_Threshold: 50,
    slider_Speed: 400,
    slider_Ease: 'linear',
    slider_Breakpoints: {
        default: {
            height: 400
        },
        tablet: {
            height: 300,
            media: 1024
        },
        smartphone: {
            height: 200,
            media: 768
        }
    }
});

</script>

@stop