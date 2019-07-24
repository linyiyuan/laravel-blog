@extends('common.common')

@section('title')
403页面
@stop

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/css/error.css')}}">
@stop
@section('content')
<div class="tpl-portlet-components">
        <div class="row-content am-cf">
            <div class="widget am-cf">
                <div class="widget-body">
                    <div class="tpl-page-state">
                        <div class="tpl-page-state-title am-text-center tpl-error-title">403</div>
                        <div class="tpl-error-title-info">You have not Permission</div>
                        <div class="tpl-page-state-content tpl-error-content">

                            <p>您没有权限访问该页面</p>
                            <a class="am-btn am-btn-secondary am-radius tpl-error-btn" href="/admin/index">Back Home</a></div>

                    </div>
                </div>
            </div>
        </div>
</div>
@stop