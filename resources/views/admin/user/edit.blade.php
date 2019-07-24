@extends('common.common')

@section('title')
	{{ $user->id?'管理员修改页面':'管理员添加页面'}}
@stop

@section('content')
<div class="tpl-content-page-title">
    {{ $user->name?'管理员修改页面':'管理员添加页面'}}
</div>
<ol class="am-breadcrumb">
    <li><a href="{{url('/admin/index')}}" class="am-icon-home">首页</a></li>
    <li><a href="{{url('/admin/user_manage/user')}}">管理员列表</a></li>
    <li class="am-active">{{ $user->id?'管理员修改页面':'管理员添加页面'}}</li>
</ol>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-code"></span> {{ $user->id?'管理员修改页面':'管理员添加页面'}}
        </div>
    </div>
    <div class="tpl-block">
         <div class="am-g tpl-amazeui-form">
            <div class="am-u-sm-12 am-u-md-9">
                <form class="am-form am-form-horizontal" method="post" action="{{ isset($user->id)?url('/admin/user_manage/user').'/'.$user->id:url('/admin/user_manage/user') }}" enctype="multipart/form-data">
                	{{ csrf_field() }}
                	@if(isset($user->id))
						{{ method_field('PUT') }}
                	@endif
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">姓名 / Name</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="user-name" name="name" placeholder="姓名 / Name" value="{{ $user->name?$user->name:''}}" required>
                            <small>输入你的名字，让我们记住你。</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">电子邮件 / Email</label>
                        <div class="am-u-sm-9">
                            <input type="email" name="email" id="user-email" value="{{ $user->email?$user->email:''}}" placeholder="输入你的电子邮件 / Email" {{ $user->email?'disabled':''}}>
                            <small>邮箱你懂得...</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">密码 / Password</label>
                        <div class="am-u-sm-9">
                            <input type="password" name="password" id="user-password" placeholder="输入你的密码 / Password">
                            <small>密码你懂得...</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-email" class="am-u-sm-3 am-form-label">确定密码 / Password_Confirmation</label>
                        <div class="am-u-sm-9">
                            <input type="password" name="password_confirmation" id="user-password_confirmation" placeholder="再次输入你的密码 / Password_Confirmation">
                            <small>密码你懂得...</small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-phone" class="am-u-sm-3 am-form-label">角色<span class="tpl-form-line-small-title">Role</span></label>
                        <div class="am-u-sm-9">
                            <select multiple data-am-selected="{searchBox: 1,maxHeight: 150}" style="display: none;" name="role[]" required>
                              @foreach($role as $k)
                                  <option value="{{ $k->id }}" {{ $user->hasRole($k->name)?'selected':''}}>-{{ $k->display_name }}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label for="user-intro" class="am-u-sm-3 am-form-label">简介 / Intro</label>
                        <div class="am-u-sm-9">
                            <textarea class="" rows="5" id="user-intro" placeholder="输入个人简介" name="desc">{{ $user->desc?$user->desc:''}}</textarea>
                            <small>250字以内写出你的一生...</small>
                        </div>
                    </div>
					<div class="am-form-group">
                            <label for="user-weibo" class="am-u-sm-3 am-form-label">用户头像 <span class="tpl-form-line-small-title">Img</span></label>
                            <div class="am-u-sm-9">
                                <div class="am-form-group am-form-file">
                                    <div class="tpl-form-file-img">
                                    </div>
                                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                      <input class="doc-form-file" type="file" multiple name="img">
                                </div>
                                <div class="file-list">
                                    @if($user->img)<img src="{{ $user->img }}" alt="" class="title_pic" style="width:300px;height:300px">@endif
                                </div>
                            </div>
                    </div>

                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <a href="{{ url('/admin/user_manage/user') }}" class="am-btn am-btn-warning">返回</a>
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop