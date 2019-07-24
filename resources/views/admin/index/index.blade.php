@extends('common.common')

@section('title')
	佩唲与狗达💗
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
 <div class="tpl-content-page-title">
                佩唲与狗达的博客管理
            </div>
            <ol class="am-breadcrumb">
                <li><a href="#" class="am-icon-home">首页</a></li>
            </ol>
            <div class="tpl-content-scope">
                <div class="note note-info">
                    <h3>博客管理后台
                        <span class="close" data-close="note"></span>
                    </h3>
                    <p>该博客主要用于记录佩唲与狗达的生活点点滴滴，并且记录狗达工作相关技术内容</p>
                    <p><span class="label label-danger">提示:</span> 该博客使用Laravel + Amaze UI 开发。
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="am-icon-comments-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"> 1349 </div>
                            <div class="desc"> 新留言 </div>
                        </div>
                        <a class="more" href="#"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="am-icon-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{ $dataStatistics['commentCount']}} </div>
                            <div class="desc"> 新评论 </div>
                        </div>
                        <a class="more" href="{{ url('/admin/comment_manage/comment') }}"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="am-icon-user"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{ $dataStatistics['visitorCount']}} </div>
                            <div class="desc"> 用户数量 </div>
                        </div>
                        <a class="more" href="{{ url('/admin/visitor_manage/tourist')}}"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
                <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
                    <div class="dashboard-stat purple">
                        <div class="visual">
                            <i class="am-icon-android"></i>
                        </div>
                        <div class="details">
                            <div class="number"> {{ $dataStatistics['articleCount']}}</div>
                            <div class="desc"> 文章数量 </div>
                        </div>
                        <a class="more" href="{{ url('/admin/article_manage/article') }}"> 查看更多
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <i class="am-icon-cloud-download"></i>
                                <span> OperationLog 操作日志</span>
                            </div>
                            <div class="actions">
                                <ul class="actions-btn">
                                    <a href="/admin/system_config/operation_log"><li class="red-on">操作日志</li></a>
                                </ul>
                            </div>
                        </div>

                        <!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
                        <div id="wrapper" class="wrapper">
                        <table class="am-table tpl-table">
                                <thead>
                                    <tr class="tpl-table-uppercase">
                                        <th>操作人员</th>
                                        <th>操作</th>
                                        <th>详情</th>
                                        <th>结果</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($operationLog as $key)
                                    <tr>
                                        <td>
                                            {{ $key->username }}
                                        </td>
                                        <td>
                                            @if($key->operate == 1)
                                                <span class="label label-sm label-info">登录操作</span>
                                            @elseif($key->operate == 4)
                                                <span class="label label-sm label-danger">删除操作</span>
                                            @elseif($key->operate == 3)
                                                <span class="label label-sm label-warning">修改操作</span>
                                            @elseif($key->operate == 2)
                                                <span class="label label-sm label-success">增加操作</span>
                                            @endif
                                        </td>
                                        <td><div class="am-text-truncate" style="width: 250px; padding: 10px;">{{ $key->detail}}</div></td>
                                        <td class="font-green bold">
                                            @if($key->result == 1)
                                                    成功
                                            @elseif($key->result === 0)
                                                    失败
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <i class="am-icon-cloud-download"></i>
                                <span>数据统计</span>
                            </div>
                            <div class="actions">
                                <ul class="actions-btn">
                                    <a href="{{ url('/admin/data_statistics_manage/pv') }}"><li class="red-on">查看</li></a>
                                </ul>
                            </div>
                        </div>

                        <!--此部分数据请在 js文件夹下中的 app.js 中的 “百度图表A” 处修改数据 插件使用的是 百度echarts-->
                        <div class="tpl-echarts" id="tpl-echarts-A" _echarts_instance_="ec_1535012814098" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;">
                            <div style="position: relative; overflow: hidden; width: 579px; height: 400px; cursor: default;">
                                <canvas width="579" height="400" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 579px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                </canvas>
                            </div>
                            <div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(50, 50, 50, 0.7); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font: 14px/21px sans-serif; padding: 5px; left: 110.728px; top: 178px;">周一<br><span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#59aea2"></span>邮件 : 120<br><span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#e7505a"></span>媒体 : 220<br><span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#32c5d2"></span>资源 : 150
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="am-u-md-6 am-u-sm-12 row-mb">

                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span>最新添加文章</span>
                                <span class="caption-helper">{{ count($article)}} 篇</span>
                            </div>
                            <div class="tpl-portlet-input">
                                <div class="portlet-input input-small input-inline">
                                    <div class="input-icon right">
                                        <i class="am-icon-search"></i>
                                        <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
                                </div>
                            </div>
                        </div>
                        <div id="wrapper" class="wrapper">
                            <div id="scroller" class="scroller">
                                <ul class="tpl-task-list">
                                    @foreach($article as $k)
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="hidden" value="1" name="test">
                                                <input type="checkbox"  name="test">
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp"> {{ $k->title}} </span>
                                                 @if($k->is_show == 1)
                                                    <a href="{{ url('/admin/article_manage/article/'.$k->id.'?is_show=1')}}" class="label label-sm label-success">显示</a>
                                                    <span class="task-bell">
                                                            <i class="am-icon-bell-o"></i>
                                                </span>
                                                @else
                                                    <a href="{{ url('/admin/article_manage/article/'.$k->id.'?is_show=0')}}" class="label label-sm label-default">隐藏</a>
                                                @endif
                                                <span class="task-bell">
                                            </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="am-dropdown tpl-task-list-dropdown" data-am-dropdown>
                                                    <a href="###" class="am-dropdown-toggle tpl-task-list-hover " data-am-dropdown-toggle>
                                                        <i class="am-icon-cog"></i> <span class="am-icon-caret-down"></span>
                                                    </a>
                                                    <ul class="am-dropdown-content tpl-task-list-dropdown-ul">
                                                        <li>
                                                            <a href="{{ url('admin/article_manage/detail/').'/'.$k->id }}">
                                                                <i class="am-icon-eye"></i>  详情 </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('admin/article_manage/article/').'/'.$k->id.'/edit' }}">
                                                                <i class="am-icon-pencil"></i> 编辑 </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" class="del" data-id="{{ $k->id }}">
                                                                <i class="am-icon-trash-o"></i> 删除 </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-u-md-6 am-u-sm-12 row-mb">
                    <div class="tpl-portlet">
                        <div class="tpl-portlet-title">
                            <div class="tpl-caption font-green ">
                                <span>项目进度</span>
                            </div>

                        </div>

                        <div class="am-tabs tpl-index-tabs" data-am-tabs>
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                <li class="am-active"><a href="#tab1">进行中</a></li>
                                <li><a href="#tab2">已完成</a></li>
                            </ul>

                            <div class="am-tabs-bd">
                                <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                    <div id="wrapperA" class="wrapper">
                                        <div id="scroller" class="scroller">
                                            <ul class="tpl-task-list tpl-task-remind">
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                        <i class="am-icon-bell-o"></i>
                      </span>

                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display: block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                            <i class="am-icon-share"></i>
                                                        </span></span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                        <i class="am-icon-bolt"></i>
                      </span>

                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw 将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>

                                                </li>

                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                        <i class="am-icon-bullhorn"></i>
                      </span>

                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        1天前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-warning">
                        <i class="am-icon-plus"></i>
                      </span>

                                                        <span> 部分用户反应在过长的 Tabs 中滚动页面时会意外触发 Tab 切换事件，用户可以选择禁用触控操作。</span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                        <i class="am-icon-bell-o"></i>
                      </span>

                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display: block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                            <i class="am-icon-share"></i>
                                                        </span></span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                        <i class="am-icon-bolt"></i>
                      </span>

                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw 将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>

                                                </li>

                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                        <i class="am-icon-bullhorn"></i>
                      </span>

                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="am-tab-panel am-fade" id="tab2">
                                    <div id="wrapperB" class="wrapper">
                                        <div id="scroller" class="scroller">
                                            <ul class="tpl-task-list tpl-task-remind">
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                        <i class="am-icon-bell-o"></i>
                      </span>

                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display: block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                            <i class="am-icon-share"></i>
                                                        </span></span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                        <i class="am-icon-bolt"></i>
                      </span>

                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw 将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>

                                                </li>

                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                        <i class="am-icon-bullhorn"></i>
                      </span>

                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        1天前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-warning">
                        <i class="am-icon-plus"></i>
                      </span>

                                                        <span> 部分用户反应在过长的 Tabs 中滚动页面时会意外触发 Tab 切换事件，用户可以选择禁用触控操作。</span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        12分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco">
                        <i class="am-icon-bell-o"></i>
                      </span>

                                                        <span> 注意：Chrome 和 Firefox 下， display: inline-block; 或 display: block; 的元素才会应用旋转动画。<span class="tpl-label-info"> 提取文件
                                                            <i class="am-icon-share"></i>
                                                        </span></span>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="cosB">
                                                        36分钟前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-danger">
                        <i class="am-icon-bolt"></i>
                      </span>

                                                        <span> FontAwesome 在绘制图标的时候不同图标宽度有差异， 添加 .am-icon-fw 将图标设置为固定的宽度，解决宽度不一致问题（v2.3 新增）。</span>
                                                    </div>

                                                </li>

                                                <li>
                                                    <div class="cosB">
                                                        2小时前
                                                    </div>
                                                    <div class="cosA">
                                                        <span class="cosIco label-info">
                        <i class="am-icon-bullhorn"></i>
                      </span>

                                                        <span> 使用 flexbox 实现，只兼容 IE 10+ 及其他现代浏览器。</span>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                 </div>
		</div>
@stop

@section('javascript')
<script src="{{ asset('admin/js/chart.js') }}"></script>
{{--<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
{{--<script src="/js/app.js"></script>--}}
<script>
</script>
@stop