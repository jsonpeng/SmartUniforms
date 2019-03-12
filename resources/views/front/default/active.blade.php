@extends('front.default.layout.base')

@section('css')
<style type="text/css">
	.activation_title{
		text-align: center;font-size: 24px;
	}
	.mt10{
		margin-top:10%;
	}
</style>
@endsection

@section('title')
    <title>激活智能标</title>
@endsection

@section('content')
	<h1 class="activation_title mt10">激活智能标</h1>
  <form class="mt10">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" maxlength="11" placeholder="请输入手机号" name="phone"/>
                </div>
            </div>
            
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">识别码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" placeholder="请输入识别码" name="code"/>
                </div>
            </div>
        </div>
        <div class="weui-btn-area mt10">
            <input class="weui-btn weui-btn_primary" id="active_code" value="激活" type="button"></input>
        </div>
    </form>

@endsection


@section('js')
<script type="text/javascript">
    var code= '';
	$('#active_code').click(function(){
		var phone=$('input[name=phone]').val();
	    code=$('input[name=code]').val();
        if(phone.length < 11){
            alert('手机号格式不正确');
            return false;
        }
		if(phone=='' || code == ''){
			alert('参数不完整');
			return false;
		}
		   $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $.ajax({
                url:'/api/activaCard/'+{{ $user->id }},
                type:'GET',
                data:{
                	type:'手机',
                	code:phone+'_'+code
                },
                success:function(data){
                	if(data.code==0){
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });
                          $.ajax({
                              url:"/pay_weixin/"+data.message,
                              type:"GET",
                              data:'',
                              success: function(data) {
                                if (data.code == 0) {
                                  if (typeof WeixinJSBridge === 'undefined') { // 微信浏览器内置对象。参考微信官方文档
                                    if (document.addEventListener) {
                                      document.addEventListener('WeixinJSBridgeReady', onBridgeReady(data.message), false)
                                    } else if (document.attachEvent) {
                                      document.attachEvent('WeixinJSBridgeReady', onBridgeReady(data.message))
                                      document.attachEvent('onWeixinJSBridgeReady', onBridgeReady(data.message))
                                    }
                                  } else {
                                    onBridgeReady(data.message)
                                  }
                                }else if(data.code == 3){
                                    sendMessage();
                                }
                              },
                              error: function(data) {
                                  //提示失败消息
                              },
                          });
                	}
                    else{
                		alert('激活失败');
                	}
                }
            });
	});

    function onBridgeReady(data) {
      data = JSON.parse(data)
      var that = this
      /* global WeixinJSBridge:true */
      WeixinJSBridge.invoke(
        'getBrandWCPayRequest', {
          'appId': data.appId, // 公众号名称，由商户传入
          'timeStamp': data.timeStamp, // 时间戳，自1970年以来的秒数
          'nonceStr': data.nonceStr, // 随机串
          'package': data.package,
          'signType': data.signType, // 微信签名方式：
          'paySign': data.paySign // 微信签名
        },
        function (res) {
          // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
          if (res.err_msg === 'get_brand_wcpay_request:ok') {
              sendMessage();
          } 
          else {
            layer.open({
              content: '支付失败,错误信息: ' + res.err_msg
              ,skin: 'msg'
              ,time: 2 //2秒后自动关闭
            });
          }
        }
      )
    }

    function sendMessage(){
              var message= '{{ getSettingValueByKey('jihuo_success_info') }}';
              if(message == ''){
                  message ='激活成功';
              }
              message = '亲爱的家长 您的智能标 '+ code +' 已经激活，如果您孩子的物品回到了学校的失物招领处，我们会在早上7点发手机短信通知您！'
              alert(message);
              location.href="https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzU4MDUxOTI2Ng==&scene=124#wechat_redirect";
    }
</script>
@endsection