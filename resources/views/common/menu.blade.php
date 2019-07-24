<div class="tpl-left-nav-title">
    狗达与佩唲
</div>
<div class="tpl-left-nav-list">
    <ul class="tpl-left-nav-menu">
        <li class="tpl-left-nav-item">
            <a href="{{ url('admin/index')}}" class="nav-link {{strpos(Request::getPathInfo(),'admin/index') !== false?'active' :'' }}">
                <i class="am-icon-home"></i>
                <span>首页</span>
            </a>
        </li>
        @foreach($menu as $k => $v)
        <li class="tpl-left-nav-item">
            <a href="javascript:;" class="nav-link tpl-left-nav-link-list {{ strpos(Request::getPathInfo(),$v['url']) !== false?'active' :'' }}">
                <i class="{{ $v['icon']}}"></i>
                <span>{{ $v['type'] }}</span>
                @if(in_array(Request::getPathInfo(),array_column($v['data'],'url')))
                    <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                @else
                     <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                @endif
            </a>
            <ul class="tpl-left-nav-sub-menu" id="tpl-left-nav-sub-menu" style="{{strpos(Request::getPathInfo(),$v['url']) !== false?'display: block;' :'' }}">
                <li>
                    @foreach($v['data'] as $key => $val)
                        <a href="{{ url($val['url'])}}" class="{{ strpos(Request::getPathInfo(),$val['url']) !== false?'active':''}} {{$val['url']}}">
                            <i class="am-icon-angle-right"></i>
                            <span>{{ $val['type'] }}</span>
                            <i class="tpl-left-nav-content-ico am-fr am-margin-right"></i>
                        </a>
                     @endforeach
                </li>

            </ul>
        </li>
        @endforeach
    </ul>
</div>