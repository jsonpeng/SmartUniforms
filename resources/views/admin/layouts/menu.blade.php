
<li class="treeview {{ Request::is('zcjy/setting*') || Request::is('zcjy/settings/themeSetting*') || Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems') || Request::is('zcjy/singelPages*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>基本设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/settings/setting*') ? 'active' : '' }}">
            <a href="{!! route('settings.setting') !!}"><i class="fa fa-edit"></i><span>网站设置</span></a>
        </li>
        <li class="{{ Request::is('zcjy/settings/system') ? 'active' : '' }}">
            <a href="{!! route('settings.system') !!}"><i class="fa fa-edit"></i><span>系统功能</span></a>
        </li>
        @if( Config::get('web.FUNC_THEME') || Config::get('web.FUNC_COLOR'))
        <li class="{{ Request::is('zcjy/settings/themeSetting*') ? 'active' : '' }}">
            <a href="{!! route('settings.themeSetting') !!}"><i class="fa fa-edit"></i><span>主题设置</span></a>
        </li>
        @endif

        <li class="{{ Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems') ? 'active' : '' }}">
            <a href="{!! route('banners.index') !!}"><i class="fa fa-edit"></i><span>滚动横幅</span></a>
        </li>
        
        @if(Config::get('web.FUNC_FOOTER'))
        <li class="{{ Request::is('zcjy/singelPages*') ? 'active' : '' }}">
            <a href="{!! route('singelPages.index') !!}"><i class="fa fa-edit"></i><span>业务介绍</span></a>
        </li>
        @endif
    </ul>
</li>
<li class="">
    <a href="javascript:;" id="refresh"><i class="fa fa-refresh"></i><span>清理缓存</span></a>
</li>

{{-- <li class="{{ Request::is('zcjy/consultRecords*') ? 'active' : '' }}">
    <a href="{!! route('consultRecords.index') !!}"><i class="fa fa-edit"></i><span>征询单记录</span></a>
</li> --}}
<li class="header">机器管理</li>
<li class="{{ Request::is('zcjy/machineIdes*') ? 'active' : '' }}">
    <a href="{!! route('machineIdes.index') !!}"><i class="fa fa-edit"></i><span>机器管理</span></a>
</li>
<li class="header">卡功能</li>
<li class="{{ Request::is('zcjy/memberCards*') ? 'active' : '' }}">
    <a href="{!! route('memberCards.index') !!}"><i class="fa fa-edit"></i><span>激活记录</span></a>
</li>

<li class="{{ Request::is('zcjy/regCodes*') ? 'active' : '' }}">
    <a href="{!! route('regCodes.index') !!}"><i class="fa fa-edit"></i><span>激活码设置</span></a>
</li>

<li class="{{ Request::is('zcjy/cardRecords*') ? 'active' : '' }}">
    <a href="{!! route('cardRecords.index') !!}"><i class="fa fa-edit"></i><span>读取器读取记录</span></a>
</li>



@if(funcOpen('FUNC_FUNDS'))
<!--li class="{{ Request::is('zcjy/withDrawls*')? 'active' : '' }}">
    <a href="{!! route('withDrawls.index') !!}"><i class="fa fa-edit"></i><span>钱包用户操作记录</span></a>
</li-->
@endif


<li class="header">校服征订管理</li>
<li class="{{ Request::is('zcjy/schools*') ? 'active' : '' }}">
    <a href="{!! route('schools.index') !!}"><i class="fa fa-edit"></i><span>学校管理</span></a>
</li>

<li class="{{ Request::is('zcjy/schoolClothesIndex*') || Request::is('zcjy/schoolClothesCreate*') || Request::is('zcjy/schoolClothesEdit*') ? 'active' : '' }}">
    <a href="{!! route('products.sindex') !!}"><i class="fa fa-edit"></i><span>校服管理</span></a>
</li>

<li class="{{ Request::is('zcjy/consultRecords*') ? 'active' : '' }}">
    <a href="{!! route('consultRecords.index') !!}"><i class="fa fa-edit"></i><span>征询单记录管理</span></a>
</li>



<li class="header">商城功能</li>
<li class="treeview {{ Request::is('zcjy/users*') || Request::is('zcjy/userLevels*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>会员管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/users*') ? 'active' : '' }}">
            <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>会员管理</span></a>
        </li>
       {{--  @if(funcOpen('FUNC_MEMBER_LEVEL'))
            <li class="{{ Request::is('zcjy/userLevels*') ? 'active' : '' }}">
                <a href="{!! route('userLevels.index') !!}"><i class="fa fa-edit"></i><span>会员等级</span></a>
            </li>
        @endif --}}
    </ul>
</li>
@if(Config::get('web.FUNC_WECHAT'))
<li class="{{ Request::is('zcjy/wechat/menu*') || Request::is('zcjy/wechat/reply*') ? 'active' : '' }}">
    <a href="{!! route('wechat.menu') !!}"><i class="fa fa-edit"></i><span>微信设置</span></a>
</li>
@endif

<li class="treeview {{ Request::is('zcjy/customerServices*') || Request::is('zcjy/bankSets*') || Request::is('zcjy/cities*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>商城设置</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
       <li class="{{ Request::is('zcjy/customerServices*') ? 'active' : ''  }}">
            <a href="{!! route('customerServices.index') !!}"><i class="fa fa-edit"></i><span>客服设置</span></a>
        </li>
        @if(funcOpen('FUNC_CASH_WITHDRWA'))
        <li class="{{ Request::is('zcjy/bankSets*') ? 'active' : '' }}">
            <a href="{!! route('bankSets.index') !!}"><i class="fa fa-edit"></i><span>银行卡设置</span></a>
        </li>
        @endif
        <li class="{{ Request::is('zcjy/cities*') || Request::is('zcjy/freightTems*') ? 'active' : '' }}">
            <a href="{!! route('cities.index') !!}"><i class="fa fa-edit"></i><span>物流设置</span></a>
        </li>
    </ul>
</li>



<!--
<li class="{{ Request::is('zcjy/users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>会员列表</span></a>
</li>
-->

<!--
<li class="{{ Request::is('zcjy/wechat/menu') ? 'active' : '' }}">
    <a href="{!! route('wechat.menu') !!}"><i class="fa fa-edit"></i><span>菜单设置</span></a>
</li>
<li class="{{ Request::is('zcjy/wechat/reply') ? 'active' : '' }}">
    <a href="{!! route('wechat.reply') !!}"><i class="fa fa-edit"></i><span>回复消息</span></a>
</li>
-->



<!--
<li class="{{ Request::is('zcjy/freightTems*') ? 'active' : '' }}">
    <a href="{!! route('freightTems.index') !!}"><i class="fa fa-edit"></i><span>运费模板设置</span></a>
</li>
-->

 <li class="header">权限管理</li>
<li class="{{ Request::is('zcjy/managers*') || Request::is('zcjy/roles*') || Request::is('zcjy/permissions*') ? 'active' : '' }}">
    <a href="{!! route('managers.index') !!}"><i class="fa fa-edit"></i><span>权限设置</span></a>
</li> 


<li class="header">角色设置</li>
<li class="{{ Request::is('zcjy/roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span>角色设置</span></a>
</li>
{{-- 
<li class="header">权限设置</li>
<li class="{{ Request::is('zcjy/permissions*') ? 'active' : '' }}">
    <a href="{!! route('permissions.index') !!}"><i class="fa fa-edit"></i><span>权限设置</span></a>
</li> --}}



@if(Config::get('web.FUNC_POST'))
<li class="header">文章管理</li>
<li class="treeview {{ Request::is('zcjy/articlecats') || Request::is('zcjy/articlecats/create') || Request::is('zcjy/posts') || Request::is('zcjy/posts/create') || Request::is('zcjy/customPostTypes*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-folder"></i> <span>文章管理</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('zcjy/articlecats') ? 'active' : '' }}">
            <a href="{!! route('articlecats.index') !!}"><i class="fa fa-bars"></i><span>分类列表</span></a>
        </li>
        <li class="{{ Request::is('zcjy/articlecats/create') ? 'active' : '' }}">
            <a href="{!! route('articlecats.create') !!}"><i class="fa fa-bars"></i><span>添加分类</span></a>
        </li>
        <li class="{{ Request::is('zcjy/posts') ? 'active' : '' }}">
            <a href="{!! route('posts.index') !!}"><i class="fa fa-newspaper-o"></i><span>文章管理</span></a>
        </li>
        <li class="{{ Request::is('zcjy/posts/create') ? 'active' : '' }}">
            <a href="{!! route('posts.create') !!}"><i class="fa fa-newspaper-o"></i><span>添加文章</span></a>
        </li>

        <li class="{{ Request::is('zcjy/customPostTypes*') || Request::is('zcjy/*/customPostTypeItems*') ? 'active' : '' }}">
            <a href="{!! route('customPostTypes.index') !!}"><i class="fa fa-calendar-plus-o"></i><span>自定义文章类型</span></a>
        </li>
    </ul>
</li>
@endif

<!--
<li class="header">页面</li>
<li class="{{ Request::is('zcjy/pages') ? 'active' : '' }}">
<a href="{!! route('pages.index') !!}"><i class="fa fa-newspaper-o"></i><span>页面</span></a>
</li>
<li class="{{ Request::is('zcjy/pages/create') ? 'active' : '' }}">
<a href="{!! route('pages.create') !!}"><i class="fa fa-newspaper-o"></i><span>添加页面</span></a>
</li>
<li class="{{ Request::is('zcjy/customPageTypes*') ||  Request::is('zcjy/*/pageItems*')  ? 'active' : '' }}">
<a href="{!! route('customPageTypes.index') !!}"><i class="fa fa-calendar-plus-o"></i><span>自定义页面类型</span></a>
</li>
</li>

