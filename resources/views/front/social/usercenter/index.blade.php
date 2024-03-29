    @extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .user-zone .weui-cell{border-bottom:1px solid #e0e0e0;}
        .weui-cell .weui-cell__bd{color: #000;font-weight: bold;}
        .userInfo{background-image: url('images/social/bg.jpg');background-repeat: no-repeat;background-position: center;background-size: cover;box-sizing: border-box;padding-bottom: 15px;}
        .userInfo .weui-media-box_appmsg{margin-top:15px;}
        .app-wrapper .userInfo .weui-media-box .weui-media-box__desc span{color: #fff;}
        .userInfo .line{margin: 0 15px;}
        .nav-top a .icon{color: #fff;font-size:30px;}
        .nav-top .weui-cell__bd{text-align: right;}
    </style>
@endsection

@section('content')
<!--     <div class="nav_tip">
  <div class="img">
    <a href="javascript:history.back(-1)"><img src="{{ asset('images/return.png') }}" alt=""></a></div>
  <p class="titile">我的</p>
</div> -->
    <div class="userInfo">
        {{-- <img class="bg" src="{{ asset('images/social/bg.jpg') }}" alt=""> --}}
{{--         <div class="add">
            <img src="{{asset('images/place.png')}}" alt=""><a>查看商家地址</a>
        </div> --}}
        <div class="weui-cell nav-top">
            <a href="javascript:;" class="weui-cell__hd">
                <i class="icon ion-ios-email-outline weui-cell__hd"></i>
            </a>
            <a class="weui-cell__bd" href="javascript:;">
                <i class="icon ion-ios-gear-outline"></i>
            </a>
        </div>

        <div class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <div class="userImg">
                    <img src="{{ $user->head_image }}" alt="">
                </div>
            </div>
            <div class="weui-media-box__bd">
                <div class="weui-media-box__title">
                    @if(funcOpen('FUNC_MEMBER_LEVEL') && !empty($userLevel))
                        <div class="menber">
                            <img src="{{ asset('images/vip.png') }}" alt="">
                        </div>
                    @endif
                    <div class="name">
                        {{ $user->nickname }}
                    </div>
                </div>
                <div class="weui-media-box__desc">
                    <span>积分：</span><span>88</span><span class="line">|</span><span>余额：</span><span>88</span>
                </div>
            </div>
        </div>

    </div>
    <div class="weui-cells section-margin">
        <a class="weui-cell weui-cell_access" href="/orders">
            <div class="weui-cell__bd">
                <p>我的订单</p>
            </div>
            <div class="weui-cell__ft">所有订单</div>
        </a>
        <div class="weui-grids index-function-grids">
            <a href="/orders/2" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/social/c1.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待付款</p>
            </a>
            <a href="/orders/3" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/social/c2.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待发货</p>
            </a>
            <a href="/orders/4" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/social/c3.png') }}" alt="">
                </div>
                <p class="weui-grid__label">待收货</p>
            </a>
            <a href="/orders/4" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{ asset('images/social/c4.png') }}" alt="">
                </div>
                <p class="weui-grid__label">交易成功</p>
            </a>
        </div>
    </div>


    <div class="weui-cells section-margin user-zone">
        <a class="weui-cell weui-cell_access" href="/coupon">
            <div class="weui-cell__bd">
                <p>我的优惠券</p>
            </div>
            <div class="weui-cell__ft">去领券</div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/collections">
            <div class="weui-cell__bd">
                <p>我的收藏</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/address">
            <div class="weui-cell__bd">
                <p>地址管理</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    <div class="weui-cells section-margin user-zone">
        <a class="weui-cell weui-cell_access" href="/usercenter/fellow">
            <div class="weui-cell__bd">
                <p>推荐人</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/bonus">
            <div class="weui-cell__bd">
                <p>分佣记录</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="/usercenter/qrcode">
            <div class="weui-cell__bd">
                <p>分享二维码</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    
@endsection