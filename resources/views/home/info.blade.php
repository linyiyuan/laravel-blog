@extends('home.common.common')


@section('style')
<link href="{{ asset('admin/css/prism.css') }}" rel="stylesheet" />
<link href="{{ asset('home/article/css/info.css') }}" rel="stylesheet" />

<style>
	
</style>
@stop

@section('content')
<!-- 博客内容开始 -->
  <h1 class="t_nav">
@if (session('error'))
    <div class="alert alert-danger">
        <ul>
            {{ session('error') }}
        </ul>
    </div>
@elseif(session('success'))
	<div class="alert alert-success">
	  <ul>
		  {{ session('success') }}
	  </ul>
	</div>
@endif
  </h1>
  <div class="blogs">
  <div class="about_me" style="margin-top:20px;width:100%">
      <div class="infosbox">
      	<div class="col-md-12  left-col" style="padding-left:0">
		
	    <div class="panel panel-default padding-md" style="padding-bottom:0;margin-bottom:0">

	      <div class="panel-body ">

	        <h2><i class="fa fa-cog" aria-hidden="true"></i> 编辑个人资料</h2><hr>

	        <form class="form-horizontal" method="POST" action="{{ url('/info/update') }}" accept-charset="UTF-8" enctype="multipart/form-data">
	            <input type="hidden" name="_token" value="{{ userInfo()->_token }}">
	            <div class="form-group">
	                <label for="" class="col-sm-2 control-label">手机号码</label>
	                <div class="col-sm-6">
	                    <input class="form-control" type="text" value="{{ userInfo()->phone}}" disabled="">
	                </div>
	            </div>
	            <div class="form-group">
	              <label for="" class="col-sm-2 control-label">用户名</label>
	              <div class="col-sm-6">
	                  <input class="form-control" name="username" type="text" value="{{ userInfo()->username}}">
	              </div>
	              <div class="col-sm-4 help-block">
	                如：李小明
	              </div>
	          </div>
	            <div class="form-group">
	                <label for="" class="col-sm-2 control-label">邮 箱</label>
	                <div class="col-sm-6">
	                    <input class="form-control" name="email" type="text" value="{{ userInfo()->email}}">
	                </div>
	                <div class="col-sm-4 help-block">
	                    如：name@website.com
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="" class="col-sm-2 control-label">密 码</label>
	                <div class="col-sm-6">
	                    <input class="form-control" name="password" type="password" value="">
	                </div>
	                <div class="col-sm-4 help-block">
	                   密码：6位以上
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="" class="col-sm-2 control-label">确定密码</label>
	                <div class="col-sm-6">
	                    <input class="form-control" name="password_confirmation" type="password" value="">
	                </div>
	                <div class="col-sm-4 help-block">
	                   密码：6位以上
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="wechat_qrcode" class="col-sm-2 control-label">头像</label>
	                <div class="col-sm-6">
	                    <input type="file" name="img" class="image-upload-input">

	                    <input type="hidden" name="wechat_qrcode_text" class="image-upload-hidden" value="">

	                                    </div>
	                <div class="col-sm-4 help-block">
	                    个人头像（大小限制2M）
	                </div>
           		</div>

	          <div class="form-group">
	              <div class="col-sm-offset-2 col-sm-6">
	                <input class="btn btn-primary" id="user-edit-submit" type="submit" value="应用修改">
	              </div>
	            </div>
	      </form>
	      </div>

	    </div>

    </div>
      </div>
  
  </div>
  </div>
	@include('home.common.right_nav')

@stop


@section('javascript')
<script src="{{ asset('admin/js/echarts.min.js') }}"></script>
<script src="{{ asset('admin/js/prism.js') }}"></script>


@stop