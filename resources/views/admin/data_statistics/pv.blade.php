@extends('common.common')

@section('title')
	访问量数据统计
@stop

@section('content')
<div class="tpl-content-page-title">
    访问量数据统计
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">访问量数据统计</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> 访问量数据统计
        </div>
        <div class="tpl-portlet-input tpl-fz-ml">
            <div class="portlet-input input-small input-inline">
                <div class="input-icon right">
                    <i class="am-icon-search"></i>
                    <input type="text" class="form-control form-control-solid" placeholder="搜索..."> </div>
            </div>
        </div>


    </div>
    <div class="tpl-block">
        <form action="{{ url('/admin/data_statistics_manage/pv/') }}" method="get">
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-form-group">
                        <select data-am-selected="{btnSize: 'sm',maxHeight: 180}" name="date">
                          @foreach($allDate as  $k)
                                <option value="{{ $k }}" {{ $k==$nowDate?'selected':''}}>{{ $k }}</option>
                          @endforeach
                        </select>
                        <button class="am-btn  am-btn-default am-btn-success tpl-am-btn-success am-btn-sm" type="submit">查询</button>
                    </div>
                </div>
                <div class="am-u-sm-12 am-u-md-3">

                </div>
            </div>
        </form>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                            <tr>
                                <th class="table-title">日期</th>
                                <th class="table-title">Ip</th>
                                <th class="table-type">地点</th>
                                <th class="table-type">邮编</th>
                                <th class="table-author am-hide-sm-only">访问日期</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pv as $k)
                                <tr>
                                    <td>{{ $nowDate }}</td>
                                    <td>{{ $k['ip']}}</td>
                                    <td>
                                       {{ $k['address']}}
                                    </td>
                                    <td>
                                        {{ $k['code']}}
                                    </td>
                                    <td class="am-hide-sm-only">{{ date('Y-m-d H:i:s',$k['times'])}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="am-cf">
                        <div class="am-fr">
                        </div>
                    </div>
                    <hr>

                </form>
            </div>

        </div>
    </div>
    <div class="tpl-alert"></div>
</div>
@stop

@section('javascript')
@stop