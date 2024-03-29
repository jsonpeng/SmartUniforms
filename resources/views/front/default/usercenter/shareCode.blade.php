@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        body{background-color:#84d4da;}
        .nav_tip{background:transparent;}
        .nav_tip .titile{color: #fff;font-size: 17px;}
		#shopinfo{background-color: transparent;}
		.store-info p{display: inline-block;color: #fff;}
		.store-info a{color:#fff;}
		.store-text{color: #fff;}
		.store-text a{color: #fff;}
    </style>
@endsection

@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><img src="{{ asset('images/default/white_left.png') }}" alt=""></a></div>
	  <p class="titile">分享二维码</p>
	  <div class="userSet">
	      <a href="javascript:;">
	            <img src="{{ asset('images/default/share.png') }}" alt="">
	      </a>
	  </div>
	</div>
	<div style="text-align: center;">
		<img src="{{ $share_img }}" style="width: 80%; margin-top: 30px; margin-bottom: 15px;">
	</div>

	@include('front.'.theme()['name'].'.layout.shopinfo')
@endsection


@section('js')
    
@endsection