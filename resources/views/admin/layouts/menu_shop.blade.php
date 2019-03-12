<li class="{{ Request::is('zcjy/stat*') ? 'active' : '' }}">
    <a href="{!! route('stat.index') !!}"><i class="fa fa-edit"></i><span>统计信息</span></a>
</li>

<?php
    $active = Request::is('zcjy/orders*') || Request::is('zcjy/orderCancels*') || Request::is('zcjy/orderRefunds*') || Request::is('zcjy/refundMoneys*');
?>

<li class="treeview @if ($active) active @endif">
    <a href="#">
    <i class="fa fa-laptop"></i>
        <span>订单管理</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" @if ($active) style="display: block;" @else style="display: none;" @endif>
        <li class="{{ Request::is('zcjy/orders*') && empty(Request::get('menu_type'))? 'active' : '' }}">
            <a href="{!! route('orders.index') !!}"><i class="fa fa-edit"></i><span>全部订单</span></a>
        </li>

        @if(funcOpen('FUNC_FLASHSALE'))
        <li class="{{ Request::get('menu_type')=='1'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('秒杀订单') !!}"><i class="fa fa-edit"></i><span>秒杀订单</span></a>
        </li>
        @endif

        @if(funcOpen('FUNC_TEAMSALE'))
        <li class="{{ Request::get('menu_type')=='5'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('拼团订单') !!}"><i class="fa fa-edit"></i><span>拼团订单</span></a>
        </li>
        @endif

        <li class="{{ Request::get('menu_type')=='6'?'active':'' }}">
            <a href="{!! route('orders.index').varifyOrderType('发货单') !!}"><i class="fa fa-edit"></i><span>发货单</span></a>
        </li>
        <li class="{{ Request::is('zcjy/orderCancels*') ? 'active' : '' }}">
            <a href="{!! route('orderCancels.index') !!}"><i class="fa fa-edit"></i><span>退款单</span></a>
        </li>
        
        @if(funcOpen('FUNC_AFTERSALE'))
        <li class="{{ Request::is('zcjy/orderRefunds*') ? 'active' : '' }}">
            <a href="{!! route('orderRefunds.index') !!}"><i class="fa fa-edit"></i><span>退换货</span></a>
        </li>
        @endif

        <li class="{{ Request::is('zcjy/refundMoneys*') ? 'active' : '' }}">
            <a href="{!! route('refundMoneys.index') !!}"><i class="fa fa-edit"></i><span>退款查询</span></a>
        </li>
    </ul>
</li>

<?php
    $active2 = Request::is('zcjy/products*') || Request::is('zcjy/all_products*') || Request::is('zcjy/categories*') || Request::is('zcjy/brands*') || Request::is('zcjy/productTypes*') || Request::is('zcjy/word_products*') || Request::is('zcjy/specs*') || Request::is('zcjy/productAttrs*');
?>
<li class="treeview @if($active2) active @endif">
    <a href="#">
    <i class="fa fa-laptop"></i>
        <span>产品管理</span>
    <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" @if($active2) style="display: block;" @else style="display: none;" @endif >
        <li class="{{ Request::is('zcjy/products*') && !Request::is('zcjy/products/create') ? 'active' : '' }}">
            <a href="{!! route('products.index') !!}"><i class="fa fa-edit"></i><span>产品列表</span></a>
        </li>
        <li class="{{ Request::is('zcjy/products/create') ? 'active' : '' }}">
            <a href="{!! route('products.create') !!}"><i class="fa fa-edit"></i><span>添加产品</span></a>
        </li>
        <li class="{{ Request::is('zcjy/all_products/allLowGoods*')?'active':'' }}">
            <a href="{!! route('products.alllow') !!}"><i class="fa fa-edit"></i><span>库存报警</span></a>
        </li>
        <li class="{{ Request::is('zcjy/categories*') ? 'active' : '' }}">
            <a href="{!! route('categories.index') !!}"><i class="fa fa-edit"></i><span>分类信息</span></a>
        </li>
        @if(funcOpen('FUNC_BRAND'))
        <li class="{{ Request::is('zcjy/brands*') ? 'active' : '' }}">
            <a href="{!! route('brands.index') !!}"><i class="fa fa-edit"></i><span>品牌</span></a>
        </li>
        @endif
        <li class="{{ Request::is('zcjy/productTypes*') ? 'active' : '' }}">
            <a href="{!! route('productTypes.index') !!}"><i class="fa fa-edit"></i><span>规格属性</span></a>
        </li>
        <li class="{{ Request::is('zcjy/word_products*') ? 'active' : '' }}">
            <a href="{!! route('wordlist.index') !!}"><i class="fa fa-edit"></i><span>产品保障</span></a>
        </li>
    </ul>
</li>






<!--li class="{{ Request::is('zcjy/themes*') ? 'active' : '' }}">
    <a href="{!! route('themes.index') !!}"><i class="fa fa-edit"></i><span>专题</span></a>
</li-->
<!--
<li class="header">规格属性</li>
<li class="{{ Request::is('zcjy/productTypes*') ? 'active' : '' }}">
    <a href="{!! route('productTypes.index') !!}"><i class="fa fa-edit"></i><span>模型</span></a>
</li>
<li class="{{ Request::is('zcjy/specs*') ? 'active' : '' }}">
    <a href="{!! route('specs.index') !!}"><i class="fa fa-edit"></i><span>规格</span></a>
</li>
<li class="{{ Request::is('zcjy/productAttrs*') ? 'active' : '' }}">
    <a href="{!! route('productAttrs.index') !!}"><i class="fa fa-edit"></i><span>属性</span></a>
</li>
-->