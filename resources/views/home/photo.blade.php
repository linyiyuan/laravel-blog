@extends('home.common.common')


@section('style')
<link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('pubuliu/style/index.css') }}">
<style>
  article {
    width:1280px;
  }
  
  #cas {
    display: none;
  }
</style>
@stop


@section('content')
<!-- 博客内容开始 -->
  <h1 class="t_nav"></h1>
  <!-- 瀑布流样式开始 -->
    <div class="waterfull clearfloat" id="waterfull"  data-id="{{ $photo_album_id}}">
      @if($photo->isEmpty())
      <div class="am-modal-bd" id="imloading">
          暂无数据
          <div>
          </div>
      </div>
      @else
      <ul data-am-widget="gallery" class="am-gallery-default" data-am-gallery="{ pureview: true }">
          @foreach($photo as $k)
            <li class="item">
              <a href="javascript:;" class="a-img">
                  <img class="my-img" src="{{ $k->img }}" alt="" >           
              </a>
            </li>
          @endforeach
      </ul>
        <!-- loading按钮自己通过样式调整 -->
        <div class="am-modal-bd" id="imloading">
            正在为您加载图片....
            <div>
              <span class="am-icon-spinner am-icon-spin"></span>
            </div>
        </div>
      @endif
    </div>
@stop


@section('javascript')
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>
  <!--这个插件是瀑布流主插件函数必须-->
<script type="text/javascript" src="{{ asset('pubuliu/js/jquery.masonry.min.js') }}"></script>
  <!--这个插件只是为了扩展jquery的animate函数动态效果可有可无-->
<script type="text/javascript" src="{{ asset('pubuliu/js/jQeasing.js') }}"></script>
<script type="text/javascript">
$(function(){
        /*瀑布流开始*/
        var container = $('.waterfull ul');
        var loading=$('#imloading');
        var cur_page = 1;
        var page_size = 12;
        // 初始化loading状态
        loading.data("on",true);
        //统计判断初始数量
        linum = $('.am-gallery-default').children('li').length;
        if (linum < page_size) {
          loading.text('就有这么多了！');
        }
        /*判断瀑布流最大布局宽度，最大为1280*/
        function tores(){
          var tmpWid=$(window).width();

          if(tmpWid>1280){
            tmpWid=1280;
          }else{
            var column=Math.floor(tmpWid/320);
            tmpWid=column*320;
          }
          $('.waterfull').width(tmpWid);
        }
        tores();
        $(window).resize(function(){
          tores();
        });
        container.imagesLoaded(function(){
          container.masonry({
            columnWidth: 320,
            itemSelector : '.item',
            isFitWidth: false,//是否根据浏览器窗口大小自动适应默认false
            isAnimated: false,//是否采用jquery动画进行重拍版
            isRTL:false,//设置布局的排列方式，即：定位砖块时，是从左向右排列还是从右向左排列。默认值为false，即从左向右
            isResizable: true,//是否自动布局默认true
            animationOptions: {
            duration: 800,
            easing: 'easeInOutBack',//如果你引用了jQeasing这里就可以添加对应的动态动画效果，如果没引用删除这行，默认是匀速变化
            queue: false//是否队列，从一点填充瀑布流
          }
          });
        });
        /*模拟从后台获取到的数据*/
        
        /*本应该通过ajax从后台请求过来类似sqljson的数据然后，便利，进行填充，这里我们用sqlJson来模拟一下数据*/
        $(window).scroll(function(){
          if(!loading.data("on")) return;
          // 计算所有瀑布流块中距离顶部最大，进而在滚动条滚动时，来进行ajax请求，方法很多这里只列举最简单一种，最易理解一种
          var itemNum=$('#waterfull').find('.item').length;
          var itemArr=[];
          itemArr[0]=$('#waterfull').find('.item').eq(itemNum-1).offset().top+$('#waterfull').find('.item').eq(itemNum-1)[0].offsetHeight;
          itemArr[1]=$('#waterfull').find('.item').eq(itemNum-2).offset().top+$('#waterfull').find('.item').eq(itemNum-1)[0].offsetHeight;
          itemArr[2]=$('#waterfull').find('.item').eq(itemNum-3).offset().top+$('#waterfull').find('.item').eq(itemNum-1)[0].offsetHeight;
          var maxTop=Math.max.apply(null,itemArr);
          function loadData(sqlJson){
              /*这里会根据后台返回的数据来判断是否你进行分页或者数据加载完毕这里假设大于30就不在加载数据*/
              if(sqlJson.length == []){
                loading.text('就有这么多了！');
              }else{
                var html="";
                for(var i in sqlJson){
                  html+="<li class='item'><a href='javascript:;' class='a-img'><img src='"+sqlJson[i].img+"'></a></li>";
                }
                /*模拟ajax请求数据时延时800毫秒*/
                var time=setTimeout(function(){
                  $(html).find('img').each(function(index){
                    loadImage($(this).attr('img'));
                  })
                  var $newElems = $(html).css({ opacity: 0}).appendTo(container);
                  $newElems.imagesLoaded(function(){
                    $newElems.animate({ opacity: 1},800);
                    container.masonry( 'appended', $newElems,true);
                    loading.data("on",true).fadeOut();
                    clearTimeout(time);
                      });
                },800)
              }
          };
          if(maxTop<$(window).height()+$(document).scrollTop()){
            //加载更多数据
            loading.data("on",false).fadeIn(800);
            //发起ajax请求获取数据
            cur_page++; 
            var photo_album_id = $('#waterfull').attr('data-id');
            console.log(photo_album_id)
             $.ajax({
                url:"{{ url('api/photo/detail') }}",
                    method:'get',
                    data:{cur_page:cur_page,page_size:page_size,photo_album_id:photo_album_id},
                    dataType:'json',
                    success:function(msg)
                    {
                        loadData(msg.data);
                    }   
            });
          }
        });
        function loadImage(url) {
             var img = new Image(); 
             //创建一个Image对象，实现图片的预下载
              img.img = url;
              if (img.complete) {
                 return img.img;
              }
              img.onload = function () {
                return img.img;
              };
         };
         loadImage('http://paan0ksle.bkt.clouddn.com/admin/article/2018-06-25-14-53-42-5b309176024a2.jpeg');
        /*item hover效果*/
        var rbgB=['#71D3F5','#F0C179','#F28386','#8BD38B'];
        $('#waterfull').on('mouseover','.item',function(){
          var random=Math.floor(Math.random() * 4);
          $(this).stop(true).animate({'backgroundColor':rbgB[random]},1000);
        });
        $('#waterfull').on('mouseout','.item',function(){
          $(this).stop(true).animate({'backgroundColor':'#fff'},1000);
        });
        // // var s
        //  var a = $('.my-img').css('width');
        //  console.log(parseInt(a)/4);
        //  $('.item').css({'width':parseInt($('.my-img').css('width'))/2+'px'});
        //  $('.item').css({'height':parseInt($('.my-img').css('height'))/2+'px'});

        //  $('.my-img').css({'width':parseInt($('.my-img').css('width'))/2+'px'});
    
})
</script>

@stop