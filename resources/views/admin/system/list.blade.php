@extends('common.common')

@section('title')
系统配置信息
@stop

@section('content')
<div class="tpl-content-page-title">
    角色管理列表
</div>
<ol class="am-breadcrumb">
    <li><a href="{{ url('/admin/index') }}" class="am-icon-home">首页</a></li>
    <li class="am-active">系统配置</li>
</ol>
<div class="row-content am-cf">
        <ul class="am-list am-list-border">
          <li>
          		<a href="#"><i class="am-icon-home am-icon-fw"></i>
           		 主机名称:{{ php_uname()}}
        	    </a>
          </li>
           <li>
          		<a href="#"><i class="am-icon-home am-icon-server"></i>
           		 服务器域名 {{$_SERVER['SERVER_NAME'] 
        }}
        	    </a>
          </li>
           <li>
              <a href="#"><i class="am-icon-home am-icon-server"></i>
               服务器信息: {{$_SERVER ['SERVER_SOFTWARE']}}
              </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-book"></i>
           		 PHP版本信息:{{ PHP_VERSION	}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-database"></i>
           		 数据库版本信息: 5.7.19
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-table"></i>
           		 Laravel框架版本: 5.5
        	    </a>
          </li>
          <li>
              <a href="#"><i class="am-icon-home am-icon-table"></i>
               Zend版本: {{Zend_Version()}}
              </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-server"></i>
           		 操作系统: {{PHP_OS}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-edge"></i>
           		 服务器IP: {{ $_SERVER['SERVER_ADDR']}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-edge"></i>
           		 当前访问客户端IP: {{$_SERVER['REMOTE_ADDR']}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-support"></i>
           		 端口号: {{   $_SERVER['SERVER_PORT']}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-file"></i>
           		 根目录路径: {{ $_SERVER['DOCUMENT_ROOT']}}
        	    </a>
          </li>
          <li>
          		<a href="#"><i class="am-icon-home am-icon-upload"></i>
           		 最大上传限制: {{ get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"}}
        	    </a>
          </li>
          <li>
              <a href="#"><i class="am-icon-home am-icon-clock-o"></i>
               当前服务器系统时间: {{ date("Y-m-d G:i:s")}}
              </a>
          </li>
          <li>
              <a href="#"><i class="am-icon-home am-icon-clock-o"></i>
               最大执行时间:{{ get_cfg_var("max_execution_time").'秒'}}
              </a>
          </li>
          <li>
              <a href="#"><i class="am-icon-home am-icon-rocket"></i>
               PHP运行方式:{{ php_sapi_name()}}
              </a>
          </li>    


        </ul>

</div>

@stop


@section('javascript')
<script>
	
	
</script>
@stop