<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="target-densitydpi=device-dpi,width=640,user-scalable=no">
    <meta name="format-detection" content="telephone=no, email=no">
	<script>
        var userAgentInfo = navigator.userAgent;
        if (userAgentInfo.indexOf("Android") > 0 || userAgentInfo.indexOf("iPhone") > 0 || userAgentInfo.indexOf("SymbianOS") > 0 || userAgentInfo.indexOf("Windows Phone") > 0 || userAgentInfo.indexOf("iPod") > 0 || userAgentInfo.indexOf("iPad") > 0 || userAgentInfo.indexOf("UCBrowser") > 0) {
            
        }else{
            //window.location.href="http://www.halfrin.com";
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .img_auto{
            width: 100%;height: auto;
        }
    </style>
    @yield('title') 
    <link rel="stylesheet" href="http://www.halfrin.com/mobile/assets/iconfont/iconfont.css">
    <link rel="stylesheet" href="http://www.halfrin.com/mobile/assets/swiper/swiper.min.css">
    <link rel="stylesheet" href="http://www.halfrin.com/mobile/assets/css/style.css">
    <script src="http://www.halfrin.com/mobile/assets/js/jquery.min.js"></script>
    <script src="http://www.halfrin.com/mobile/assets/swiper/swiper.min.js"></script>
    @yield('css')
</head>
<body youdao="bind">

    <!-- 页头公用----------------------------------------------------------------------------start -->
<div class="loading" style="display: none;"></div>
<div class="menu-wrap" style="display: none;">
    <nav class="menu" style="background: rgb(72,159,248);">
        <a class="close iconfont icon-shang" href="javascript:;"  style="background: rgb(72,159,248);"></a>
        <dl>
            <dt><img src="/images/jidingjia_new_t.png" class="img_auto" style="width: 120px;height: auto;text-align: center;" alt="jidingjia"></dt>
            <dd><a href="/m/index">我们是谁</a></dd>
            <dd><a href="/">产品展示</a></dd>
            <dd><a href="/usercenter">用户中心</a></dd>
            <dd><a href="/cloth_proxy">校服代理</a></dd>
        </dl>
        <div class="tel" style="font-size: 24px;">
            <i class="iconfont icon-dianhua"></i> {!! getSettingValueByKeyCache('service_tel') !!}
        </div>
    </nav>
</div>
<header class="header">
    <a href="javascript:;" data-state="close" class="iconfont icon-menu menu-btn" ></a>
    <div class="logo">
        <img src="/images/jidingjia_new_t.png" style="height: 60px;" alt="吉丁甲"> 
    </div>
    <span class="z-fanyi" style="color:rgb(72,159,248);font-size: 24px;right: 80px;font-weight: 700">国际校服定制</span>
   {{--  <a class="z-fanyi" href="http://halfrin.com/index-en.html"><img src="http://www.halfrin.com/mobile/assets/images/en.png"></a> --}}
</header>
<!-- 页头公用----------------------------------------------------------------------------end -->

@yield('content')


<footer class="footer" style="background-image: url('{{  asset('images/12.8/640_12.jpg') }}');background-repeat: no-repeat;height: 287px;background-color:transparent;margin-bottom: 120px;position: relative;">

    <div class="row" style="
    position: absolute;
    bottom: 80px;
    left: 164px;">
            <p style="text-align: center;font-size: 16px;color: white;">四季校服</p>
            <p style="text-align: center;font-size: 16px;color: white;">Making premium school uniform since 1999</p>
    </div>

    <div class="row" style="position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding-bottom: 5px;
    display: flex;
    justify-content: space-around;"> 
        <div style="
    float: left;
    font-size: 14px;
    color: white;    margin-left: 20px;position: relative;padding-left: 16px;">
            <img src="{{ asset('images/12.8/footer/logo1.png') }}" style="position: absolute;left: -12px;top: 10px" />
           <p style="display: inline-block;"> {!! getSettingValueByKeyCache('icp') !!} </p>
        </div>
        <div style="
    float: left;
    font-size: 14px;
    color: white;    margin-left: 20px;position: relative;padding-left: 16px;">
            <img src="{{ asset('images/12.8/footer/logo2.png') }}" style="position: absolute;left: -12px;top: 10px" />
            <p style="display: inline-block;">{!! getSettingValueByKeyCache('service_tel') !!}</p>
        </div>
        <div style="
    float: left;
    font-size: 14px;
    color: white;    margin-left: 20px;position: relative;padding-left: 16px;">
            <img src="{{ asset('images/12.8/footer/logo3.png') }}" style="position: absolute;left: -12px;top: 10px"/>
            <p style="display: inline-block;">www.eagletags.com</p>
        </div>
    </div>
<!--     <div class="pull-left">
        <img class="footer-logo" src="/images/jidingjia.png" style="max-width: 80px;height: auto;">
        <p class="footer-tel">业务合作：{!! getSettingValueByKeyCache('service_tel') !!}</p>
    </div>
    <div class="pull-right">
        <img src="{!! getSettingValueByKeyCache('weixin') !!}">
    </div>
    <p class="clearfix">浙ICP备1247921号-2  Copyright ©2010-2018  shop.eagletags.com All Rights Reserved</p> -->
</footer>
<footer class="footer-bar">
    <nav class="text-center">
        <a href="/" class="btn"><i class="iconfont icon-yifu"></i><span>查看产品</span></a>
        <a href="/m/index" class="iconfont icon-xinxi z-kefu">
            <!-- <span>0</span> -->
        </a>
        <a href="tel:{!! getSettingValueByKeyCache('service_tel') !!}" class="btn z-tel"><i class="iconfont icon-dianhua"></i><span>电话联系</span></a>
    </nav>
</footer>
<a href="javascript:;" class="iconfont icon-shang back-top"></a>
<!-- 页尾公用----------------------------------------------------------------------------end -->



<script src="http://www.halfrin.com/mobile/assets/js/script.js"></script>
<script>        
    var mySwiper = new Swiper ('.swiper-container', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
        },
        autoplay:true
    });
</script>
@yield('js')
</body></html>