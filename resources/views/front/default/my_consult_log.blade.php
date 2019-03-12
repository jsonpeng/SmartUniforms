@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
       	.credit-body .g-content .info .weui-flex__item{font-size: 13px;}
       	.credit .credit-body .g-title .weui-flex__item:last-child{flex: 3;}
       	.credit .credit-body .g-content{background-color: #fff;}
       	.credit .credit-body>div:nth-child(even){background-color:#fbfcfb;}
    </style>
@endsection

@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><img src="{{ asset('images/return.png') }}" alt=""></a></div>
	  <p class="titile">我的{!! $type !!}记录</p>
	</div>
    <div class="credit">
    	<div class="head">
    	{{-- 	<div class="intr">尊敬的会员您好，您的分佣总额为</div>
    		<div class="num"><span class="small-symbol">¥  </span>{{ $user->distribut_money }}</div> --}}
    	</div>
    	<div class="credit-body">
    		<div class="g-title weui-flex">
    			<div class="weui-flex__item">{!! $type !!}时间</div>
    {{--       <div class="weui-flex__item">备注</div> --}}
    			<div class="weui-flex__item">查看</div>
    		</div>
            <div id="scroll-container">
        		@foreach ($logs as $moneyLog)
                    <div class="g-content scroll-post seeSchoolDetail" data-url="/consultRecord/{!! $moneyLog->id !!}/{!! $type !!}">
                        <div class="info weui-flex">
                            <div class="weui-flex__item">{{ $moneyLog->created_at->format('Y-m-d H:i:s') }}</div>
                          {{--   <div class="weui-flex__item">{{ $moneyLog->remark }}</div> --}}
                            <div class="weui-flex__item ">查看详情</div>
                            <div class="weui-flex__item pic">
                                <img class="open" src="{{ asset('images/top.png') }}" alt="">
                                <img class="shut" src="{{ asset('images/bottom.png') }}" alt="">
                            </div>
                        </div>
                        <div class="detail-txt">
                           
                        </div>
                    </div>

                @endforeach
            </div>
    	</div>
    </div>
	
@endsection



@section('js')
    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/javascript">
      $('.seeSchoolDetail').click(function(){
          location.href=$(this).data('url');
      });
    </script>
@endsection