@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%; margin-top: 1rem;}
        .weui-grid__icon{width: 25px; height: 25px;}
        .weui-grid__icon img{width: 25px; height: 25px;}
    </style>
@endsection

@section('content')
    <?php
        $banners = banners('brand');
    ?>
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
    
    <div class="weui-grids">
        @foreach ($brands as $brand)
            <a href="/brand/{{$brand->id}}" class="weui-grid">
                <div class="weui-grid__icon">
                    <img src="{{$brand->image}}" alt="">
                </div>
                <p class="weui-grid__label">{{$brand->name}}</p>
            </a>
        @endforeach
    </div>
    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection

@section('js')
    
@endsection





