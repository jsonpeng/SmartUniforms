@extends('front.social.layout.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/social/app.css') }}">
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}
       
    </style>
@endsection

@section('title')
@endsection

@section('content')

    <!-- 搜索框 -->
    <div class="weui-cells all_products">
        <a class="weui-cell search-box" href="javascript:;">
                <i class="icon ion-ios-email-outline weui-cell__hd"></i>
            <div class="weui-cell__bd">
                <i class="icon ion-ios-search  find-icon"></i>
                <input type="text" placeholder="输入搜索的内容" value="">
            </div>
        </a>

        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide active"><a href="javascript:;">首页</a></div>
            <div class="swiper-slide"><a href="javascript:;">美容护肤</a></div>
            <div class="swiper-slide"><a href="javascript:;">滋补保健</a></div>
            <div class="swiper-slide"><a href="javascript:;">母婴健康</a></div>
            <div class="swiper-slide"><a href="javascript:;">百货轻奢</a></div>
            <div class="swiper-slide"><a href="javascript:;">百货商品</a></div>
            <div class="swiper-slide"><a href="javascript:;">首页轻奢</a></div>
          </div>
        </div>
    </div>

    <div id='slider' class='swipe'>
        <div class='swipe-wrap'>
            @foreach ($banners as $banner)
                <div class="swiper-slide">
                    <a @if($banner->link) href="{{ $banner->link }}" @else href="javascript:;" @endif><img src="{{ $banner->image }}" class="swiper-lazy"></a> 
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            @endforeach

        </div>
    </div>
    <script>
        window.mySwipe = new Swipe(document.getElementById('slider'), {
            startSlide: 0,
            speed: 400,
            auto: 3000,
            continuous: true,
            disableScroll: false,
            stopPropagation: false,
            callback: function(index, elem) {},
            transitionEnd: function(index, elem) {}
        });
    </script>
    
    <!-- 资讯 -->
    <div class="weui-cell notice">
        <div class="weui-cell__hd">
            <p>NOTICE</p>
        </div>
        <div class="weui-cell__bd">
            <span class="title">310满返名单公布</span>
            <span class="content">310满返名单公布</span>
        </div>
    </div>
    
    <!-- 标题 -->
    <div class="top-title">
        <p>精选分类</p>
    </div>
    <!-- 精选分类 -->
    <div class="weui-panel__bd index-recommend-cat" style="">
        <a class="left_content" style="" href="/post_cat">
            <div class="weui-media-box__bd">
                <div class="img" style="">新品橱窗</div>
                <h4 class="weui-media-box__title">每日新款大推荐</h4>
                <p class="weui-media-box__desc">GO ＞</p>
            </div>
        </a>
        <div class="right_content">
            <a href="tel:{{ getSettingValueByKeyCache('service_tel') }}" class="weui-media-box__bd" style="">
                    <div class="img" style="">优惠活动</div>
                    <h4 class="weui-media-box__title">每日优惠大推荐</h4>
                    <p class="weui-media-box__desc">GO ＞</p>
            </a>
            <a href="/page/weixin" class="weui-media-box__bd" >
                    <div class="img" style="">本周销量榜</div>
                    <h4 class="weui-media-box__title">偷看达人购物车</h4>
                    <p class="weui-media-box__desc">GO ＞</p>
            </a>
        </div>
    </div>
    <!-- 板块 -->
<!--     <div class="weui-grids index-function-grids">
    @if(funcOpen('FUNC_FLASHSALE'))
    <a href="/flash_sale" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g1.png') }}" alt="">
        </div>
        <p class="weui-grid__label">秒杀专场</p>
    </a>
    @endif
    
    @if(funcOpen('FUNC_TEAMSALE'))
    <a href="/team_sale" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g2.png') }}" alt="">
        </div>
        <p class="weui-grid__label">拼团</p>
    </a>
    @endif
    
    @if(funcOpen('FUNC_PRODUCT_PROMP'))
    <a href="/product_promp" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g3.png') }}" alt="">
        </div>
        <p class="weui-grid__label">优惠活动</p>
    </a>
    @endif
    
    @if(funcOpen('FUNC_COUPON'))
    <a href="/coupon" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g4.png') }}" alt="">
        </div>
        <p class="weui-grid__label">优惠券</p>
    </a>
    @endif

    <a href="/category" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g5.png') }}" alt="">
        </div>
        <p class="weui-grid__label">全部分类</p>
    </a>

    @if(funcOpen('FUNC_BRAND'))
    <a href="/brands" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g6.png') }}" alt="">
        </div>
        <p class="weui-grid__label">品牌街</p>
    </a>
    @endif


    
    <a href="/orders" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g7.png') }}" alt="">
        </div>
        <p class="weui-grid__label">我的订单</p>
    </a>

    <a href="/usercenter" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="{{ asset('images/default_03/g8.png') }}" alt="">
        </div>
        <p class="weui-grid__label">个人中心</p>
    </a>
</div>
 -->
    <!-- 限时秒杀 -->
    @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
    <div class="weui-cells">
        <div class="weui-cell weui-cell_access">
            <div class="weui-cell__bd title-img" id="count_timer">
                <img src="{{ asset('images/default/index/miaosha.png') }}" style="vertical-align: middle; margin-right: 10px;">
                <span style="vertical-align: middle">限时秒杀</span> 
                <span style="vertical-align: middle"> 
                    <i class="time time-hour">01</i>:<i class="time time-minute">15</i>:<i class="time time-second">25</i> 
                </span>
            </div>
            <a class="weui-cell__ft" href="/flash_sale">查看更多</a>
        </div>
    </div>
    
    <div class="product-wrapper">
        @foreach ($flashSaleProduct as $element)
            <a class="product-item3" href="/product/{{ $element->product_id }}">
                <div class="img">
                    <img class="lazy" data-original="{{ $element->image }}">
                </div> 
                <div class="title">{{ $element->product_name }}</div>
                <div class="price">¥{{ $element->price }} <span class="cross">¥{{ $element->origin_price }}</span></div>
            </a>
        @endforeach
    </div>
    @endif
    
    


    <!-- 拼团专区 -->
    @if(funcOpen('FUNC_TEAMSALE') && $teamSaleProduct->count())
    <div class="top-title">
        <p>环球国家馆</p>
    </div>
    <div class="product-wrapper">
        @foreach ($teamSaleProduct as $element)
            <a class="product-item3" href="/product/{{ $element->product_id }}">
                <div class="img">
                    <img class="lazy" data-original="{{ $element->share_img }}">
                </div> 
                <div class="country">{{ $element->product_name }}</div>
            </a>
        @endforeach
    </div>
    @endif

    <div class="product-show">
        <div class="show-item" style="background-image: url('images/f3.jpg');">
            <p class="item-name">OOU</p>
            <p class="item-band">更科技的刀</p>
        </div>
    </div>
    <!-- 今日限量秒杀 -->
    <div class="top-title">
        <p>今日限量秒杀</p>
    </div>
    <div class="product-wrapper">
            <a class="product-item3" href="javascript:;">
                <div class="img">
                    <img class="lazy" data-original="{{asset('images/social/f2.jpg')}}">
                </div> 
                <div class="title">1</div>
                <div class="price">¥2 <span class="cross">¥1</span></div>
            </a>
    </div>

    <!-- 今日限量秒杀 -->
    <div class="top-title">
        <p>拼团专区</p>
    </div>
    <div class="product-wrapper">
            <a class="product-item3" href="javascript:;">
                <div class="img">
                    <img class="lazy" data-original="{{asset('images/social/f2.jpg')}}">
                </div> 
                <div class="title">1</div>
                <div class="price">¥2 <span class="cross">¥1</span></div>
            </a>
    </div>
    

    <!-- 精选专题 -->
    <div class="top-title">
        <p>精选专题</p>
    </div>
    <div class="weui-cell">
        <div class="product-show">
            <div class="show-item" style="background-image: url('images/f3.jpg');">
                <p class="item-name">品质腕表汇聚</p>
                <p class="item-band">彰显高贵品质</p>
            </div>
        </div>
    </div>
    <div class="weui-cell">
        <div class="product-show">
            <div class="show-item" style="background-image: url('images/f3.jpg');">
                <p class="item-name">家居清洁</p>
                <p class="item-band">健康生活尽享清净</p>
            </div>
        </div>
    </div>
    <div class="weui-cell">
        <div class="product-show">
            <div class="show-item" style="background-image: url('images/f3.jpg');">
                <p class="item-name">大牌包包集结</p>
                <p class="item-band">明星同款大放送</p>
            </div>
        </div>
    </div>
    <div class="weui-cell">
        <div class="product-show">
            <div class="show-item" style="background-image: url('images/f3.jpg');">
                <p class="item-name">乳胶系列</p>
                <p class="item-band">泰国原装进口</p>
            </div>
        </div>
    </div>
    
    <!-- 猜你喜欢 -->
    <div class="top-title">
        <p>猜你喜欢</p>
    </div>
    
    <div class="product-wrapper">
            <a class="product-item3" href="javascript:;">
                <div class="img">
                    <img class="lazy" data-original="{{asset('images/social/f2.jpg')}}">
                </div> 
                <div class="title">1</div>
                <div class="price">¥2 <span class="cross">¥1</span></div>
            </a>

            <a class="product-item3" href="javascript:;">
                <div class="img">
                    <img class="lazy" data-original="{{asset('images/social/f2.jpg')}}">
                </div> 
                <div class="title">1</div>
                <div class="price">¥2 <span class="cross">¥1</span></div>
            </a>

            <a class="product-item3" href="javascript:;">
                <div class="img">
                    <img class="lazy" data-original="{{asset('images/social/f2.jpg')}}">
                </div> 
                <div class="title">1</div>
                <div class="price">¥2 <span class="cross">¥1</span></div>
            </a>
    </div>








    <div id="shopinfo">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 1])
@endsection


@section('js')
<script type="text/javascript">
    $(document).ready(function(){

        //秒杀倒计时
        @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
            var end_time='{!! $time !!}';
            startShowCountDown(end_time,'#count_timer','flashsale_index');
        @endif

        //无限加载
        var fireEvent = true;
        var working = false;

        $(document).endlessScroll({

            bottomPixels: 250,

            fireDelay: 10,

            ceaseFire: function(){
              if (!fireEvent) {
                return true;
              }
            },

            callback: function(p){

              if(!fireEvent || working){return;}

              working = true;

              //加载函数
              $.ajaxSetup({ 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              $.ajax({
                url:"/api/products?skip=" + $('.scroll-post').length + "&take=18",
                type:"GET",
                success:function(data){
                  working = false;
                  var all_product=data.data;
                  if (all_product.length == 0) {
                    fireEvent = false;
                    $('#shopinfo').show();
                    return;
                  }
                  for (var i = all_product.length - 1; i >= 0; i--) {
                    $('.scroll-container').append(
                      "<a class='product-item2 scroll-post' href='/product/" + all_product[i].id + "'>\
                          <div class='img'>\
                              <img src='" + all_product[i].image + "'>\
                          </div>\
                          <div class='title'>" + all_product[i].name + "</div>\
                          <div class='price'>¥" + all_product[i].price + " <span class='buynum'> " + all_product[i].sales_count + "人购买</span></div>\
                      </a>"
                    );
                  }
                  }
              });
            }
        });
    });


    $('.price-btn').click(function(){
        var id=$(this).data('id');
        var status=$(this).data('status');
        var that=this;
        if(!status){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'/api/userGetCoupons/'+id,
                type:'post',
                success:function(data){
                    if(data.code==0){
                        layer.open({
                        content:data.message
                        ,skin: 'msg'
                        ,time: 2 
                      });
                    $(that).text('已领取');
                    $(that).data('status',true);
                    $(that).attr("style","background-color:#ddd !important;");
                    }else{
                    layer.open({
                        content:data.message
                        ,skin: 'msg'
                        ,time: 2 
                      });
                    }
                }
            });
        }else{
            return false;
        }

     });

    /**
     * 没有活动提示
     * @return {[type]} [description]
     */
     function noHuodong(){
        layer.open({
          content: '当前没有优惠活动'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
     }


     // 搜索框中是否有内容输入
     $(".search-box .weui-cell__bd").on("input",function(){
        setTimeout(function(){
            var len = $('.search-box .weui-cell__bd input').val();
            console.log(len);
            if(len == ''){
                $('.search-box .find-icon').show();
            }else{
                $('.search-box .find-icon').hide();
            }
        },300);
     });
</script>
<script> 
var mySwiper = new Swiper('.swiper-container', {
    // autoplay: 1000,//可选选项，自动滑动
    slidesPerView : 'auto',//'auto'
    centeredSlides : true,//设定为true时，active slide会居中，而不是默认状态下的居左
    slideToClickedSlide: true,
    onInit: function(swiper){
          //Swiper初始化了
          //alert(swiper.activeIndex);提示Swiper的当前索引
          $('.swiper-slide').click(function(event) {
              /* Act on the event */
              $(this).siblings().removeClass('swiper-slide-active').removeClass('active');
              $(this).addClass('swiper-slide-active').addClass('active');
          });
    }
})
</script>
@endsection