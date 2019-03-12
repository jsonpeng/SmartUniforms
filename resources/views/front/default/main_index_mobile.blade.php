@extends('front.default.layout.mobile_base')

@section('title')
<title>四季校服 专业校服定制</title>
<style type="text/css">
    .product_common{
        position: relative;
    }
    .product1_bg{

    }
    .product1_img_cloth{

    }
    .product1_img_logo{
        position: absolute;
        top: 180px;
        left: 168px;
    }
    .product1_h4{
        position: absolute;
        top: 311px;
        left: 352px;
        color: rgb(61,62,64);
    }
    .product1_a{
        position: absolute;
        top: 360px;
        left: 410px;
        padding: 5px 40px;
        background: rgb(61,62,64);
        border-radius: 15px;
        font-size: 24px;
        color: white;
    }

    .product2_title{
        color:rgb(104,176,234);
        font-size: 28px;
        text-align: center;
        font-weight: 900;
    }
    .product2_line{
        position: absolute;
        top: 30px;
    }
    .product2_word{
        color:rgb(104,176,234);
        font-size: 20px;
        text-align: center;
        padding-top: 40px;
    }

    .product2_p p{
        position: absolute;
        top: 200px;
        left: 180px;
        font-size: 20px;
        line-height: 30px;
    }

    .product2_p.style2 p{
        position: absolute;
        top: 260px;
        left: 60px;
        font-size: 20px;
        line-height: 30px;
    }

    .h600{
        height: 600px;
    }

   .white{
    color: white !important;
   }

</style>

@endsection

@section('content')

<section class="wrapper">
    <!-- product1 -->
    <section class="index-banner index-main-bg text-center" style="background-image: url('{!! asset('new/背景/640-背景_01.jpg') !!}');    background-position: inherit; height: 654px;position: relative;">
        <img class="product1_img_cloth" src="{!! asset('new/产品/640-产品_01.png') !!}" />
         <img class="product1_img_logo" src="{!! asset('new/产品/640-产品_12.png') !!}" />
         <h4 class="product1_h4">专注国际校服定制及相关服务</h4>
         <a class="product1_a" href="/">查看产品</a>
    </section>

    <?php $i=0;?>
    @foreach($new_posts as $post)
        <?php $height = imgHeight($post->image); $i++; if($i==1){$height=730;$banners=banners('mobile1');} if($i==3){$banners=banners('mobile2');$height=730;} if($i==8){$height=1750;}?>
        <?php ?>
        <section class="index-brand product_common" style="background-image: url('{!! $post->image !!}');padding: 0px;padding-top: 65px;height: {!! $height !!}px;    margin-bottom: 15px !important;">
            <h4 class="product2_title @if($post->title_color) white @endif">{!! $post->name !!}</h4>
     
            <h4 class="product2_word @if($post->title_color) white @endif">{!! $post->brief !!}</h4>
            <div class="product2_p @if($i==2) style2 @endif @if($post->title_color) white @endif" >
            {!! $post->content !!}
            </div>
            @if($i==1 || $i==3)
                @if(isset($banners) && count($banners))
                    <div class="http://m.halfrin.com/duland-show swiper-container swiper-container-horizontal swiper-container-ios" style="margin-top: 200px;
            margin-left: 6.5%;">
                    <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(-4800px, 0px, 0px);">
                        @foreach($banners as $banner)
                            <div class="swiper-slide swiper-slide-duplicate-active" data-swiper-slide-index="0" style="width: 600px;">
                                <img onerror="javascript:this.src='http://m.halfrin.com/duland-show/img1.jpg';" src="{!! $banner->image !!}">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span></div>
                    </div>
                @endif
            @endif

            @if($i==8)
            <section class="index-case" style="margin-top: 480px;">
                <div class="main-title">
                    <h2>合作学校</h2>
                    <h6>超过40%为市重点学校，约15%为贵族学校</h6>
                </div>
                <img  src="{!! getSettingValueByKeyCache('mobile_index_img_hezuo') !!}" />
            </section>
            @endif
        </section>
    @endforeach

</section>

@endsection


@section('js')
    <script type="text/javascript">
      
    </script>
@endsection