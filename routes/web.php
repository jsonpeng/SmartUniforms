<?php

use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$mid = ['web', 'wechat.oauth:snsapi_userinfo', 'auth.user'];

if (Config::get('web.app_env') == 'local'){
	$mid = ['web', 'auth.user'];
}

//微信支付
Route::get('/pay_weixin/{order_id}','Front\PayController@payWechat');
//微信支付征订
Route::get('/pay_zd/{price}','Front\PayController@payZhengDing');

Route::any('/notify_wechcat_pay', 'Front\PayController@payWechatNotify');
//PAYS_API支付
Route::get('/pays_api/{order_id}', 'Front\PayController@paysApi');
Route::any('/paysapi_return', 'Front\PayController@paysapiReturn');
Route::any('/paysapi_notify', 'Front\PayController@paysapiNotify');

Route::any('/wechat', 'Admin\Wechat\WechatController@serve');

Route::group(['middleware' => ['api']], function () {
	//发送短信验证码
	Route::get('/sendCode', 'Front\UserController@sendCode');
});

//新首页
Route::get('/index','Front\IndexController@mainIndex');
//校服代理
Route::get('cloth_proxy','Front\IndexController@clothProxy');

Route::group(['prefix'=>'m'],function(){
	//移动端首页
	Route::get('index','Front\IndexController@mainIndexMobile');


});


Route::group(['middleware' => $mid], function () {

	//联系客服
	Route::get('/kefu','Front\UserController@contactKefu');
	
	//账户功能
	Route::get('/mobile','Front\UserController@mobile');
	Route::post('/mobile','Front\UserController@postMobile');
	Route::get('/reset_password','Front\UserController@resetPassword');

	//文章分类
	Route::get('/post_cat/{cat_id?}','Front\PostController@postCats');
	//文章列表
	Route::get('/posts/{cat_id?}','Front\PostController@posts');
	//文章详情
	Route::get('/post/{id}','Front\PostController@postDetail');
	//页面
	Route::get('/page/{slug}','Front\PostController@page');

	//填写征询单
	Route::get('/create_consult','Front\IndexController@createConsult');

	//填写征订单
	Route::get('/create_consult_sub','Front\IndexController@createConsultSub');

	Route::post('/create_consult','Front\IndexController@saveConsult');

	Route::post('/update_consult/{id}','Front\IndexController@updateConsult');

	//征订校服记录
	Route::get('/consultRecords/{type?}','Front\IndexController@myConsultLog');
	//征订校服详情
	Route::get('/consultRecord/{id}/{type?}','Front\IndexController@myConsultDetailLog');
	//获取商品规格通过名称
	Route::get('/getProductGuiGeByName','Front\IndexController@getProductGuiGeByName');
	//获取学校信息通过学校代码
	Route::get('/getSchoolInfoByCode','Front\IndexController@getSchoolInfoByCode');
	//获取商品的价格通过尺码和名称
	Route::get('/getPriceByNameAndChima','Front\IndexController@getPriceByNameAndChima');
	//通过学校名称获取班级信息
	Route::get('/getClassesBySchoolName','Front\IndexController@getClassesBySchoolName');
	//我的学校
	Route::get('/mySchoolProduct','Front\CategoryController@schoolIndex');

	//账号需注册手机号
	Route::group(['middleware' => 'mobile'], function () {
		//商城首页
		Route::get('/', 'Front\IndexController@index');
		//激活卡信息
		Route::get('/activation','Front\IndexController@activation');
		//分类页面
		Route::get('/category','Front\CategoryController@index');

		Route::get('/category/level1/{id}','Front\CategoryController@level1');
		Route::get('/category/level2/{id}','Front\CategoryController@level2');
		Route::get('/category/level3/{id}','Front\CategoryController@level2');
		Route::get('/category/cat_level_01/{cat_id?}','Front\CategoryController@catLevel01');

		//品牌街
		Route::get('/brands','Front\BrandController@index');
		Route::get('/brand/{brand_id}','Front\BrandController@productList');

		//商品页面
		Route::get('/product/{id}','Front\ProductController@index')->name('front.mobile.product');

		//用户中心
		Route::get('/usercenter','Front\UserController@index');
		//团购管理
		Route::get('/usercenter/team','Front\UserController@teamList');

	    //收藏列表
	    Route::get('/usercenter/collections','Front\UserController@collections');
	    Route::get('/ajax/collections','Front\UserController@ajaxCollections');
	    //添加或取消收藏
	    Route::post('/ajax/collect_or_cancel/{product_id}','Front\UserController@collectOrCancel');

		//银行卡管理
		Route::get('/usercenter/bankcards','Front\BankCardController@index');
	    Route::get('/usercenter/bankcards/add','Front\BankCardController@add');
        Route::get('/usercenter/bankcards/edit/{bank_id}','Front\BankCardController@edit');
        //银行卡列表选择
        Route::get('/usercenter/bankcards/list','Front\BankCardController@bankListToChoose');
        //bankListToChoose
        //banklist
		Route::get('/usercenter/credits','Front\CreditController@index');
		Route::get('/ajax/credits','Front\CreditController@ajaxCredits');
		//余额
        Route::get('/usercenter/blances','Front\UserController@userBalancePage');
        Route::get('/ajax/blances','Front\UserController@ajaxUserBalance');
        //提现列表
        Route::get('/usercenter/withdrawal','Front\UserController@userWithDrawalPageList');
        //提现操作
        Route::get('/usercenter/withdrawal/action','Front\UserController@userWithDrawalPageAction');

		//推荐人列表
		Route::get('/usercenter/fellow','Front\UserController@followMembers');
		Route::get('/ajax/fellow','Front\UserController@ajaxFollowMembers');


		//分佣记录
		Route::get('/usercenter/bonus','Front\UserController@bonusList');
		Route::get('/ajax/bonus','Front\UserController@ajaxBonusList');


		Route::get('/usercenter/qrcode','Front\UserController@shareCode');

		//购物车API
		Route::get('/api/cart/add','Front\CartController@add');
		Route::get('/api/cart/update','Front\CartController@update');
		Route::get('/api/cart/delete','Front\CartController@delete');
		Route::get('/api/coupons','Front\CouponController@getCoupons');
		Route::get('/api/coupon_choose/{coupon_id}','Front\CouponController@getCouponChoose');
		Route::get('/api/cart_num','Front\CartController@getCartNum');
		//再次购买
		Route::get('/buy_again/order/{id}','Front\CartController@buyAgain');
		//购物车页面
		Route::get('/cart','Front\CartController@cart');
		//结算页面
		Route::get('/check','Front\CartController@check');
		Route::post('/check','Front\CartController@postCheck');

		//邮件通知新订单
        Route::post('/mailInform/{order_id}','Front\IndexController@mailInform');

		Route::get('/checknow','Front\CartController@checkNow');
		Route::post('/checknow','Front\CartController@postCheckNow');
		//订单管理
		
		Route::get('/orders/{type?}','Front\OrderController@index');
		Route::get('/ajax/orders','Front\OrderController@orders');
		Route::get('/order/{id}','Front\OrderController@detail');
		Route::get('/cancel/order/{id}','Front\OrderController@cancel');
		Route::get('/confirm/order/{id}','Front\OrderController@confirm');

		//退换货
		Route::get('/refunds','Front\OrderController@refundList');
		Route::get('/refund/{item_id}','Front\OrderController@refund');
		Route::post('/postRefund/{item_id}','Front\OrderController@postRefund');
		Route::get('/refundStatus/{id}','Front\OrderController@refundStatus');
		Route::get('/canRefund/{id}','Front\OrderController@canRefund');
		Route::get('/refund/changeDelivery/{id}','Front\OrderController@refundChangeDelivery');
		Route::get('/refund/cancel/{id}','Front\OrderController@refundCancel');

		//优惠券
		Route::get('/coupon/{type?}','Front\CouponController@index');
		Route::get('/ajax/coupons/{type?}','Front\CouponController@ajaxCoupon');

		//地址管理
		//个人中心地址管理首页
		Route::get('/address','Front\AddressController@index');
		//结算页面，收货地址列表
		Route::get('/address/change','Front\AddressController@change');
		//用户选择收货地址
		Route::get('/address/select/{id}','Front\AddressController@select');
		//用户设置默认收货地址
		Route::get('/address/default/{id}/{default}','Front\AddressController@default');
		//添加地址页面
		Route::get('/address/add','Front\AddressController@create');
		//保存地址
		Route::post('/address/add','Front\AddressController@store');
		//编辑地址
		Route::get('/address/edit/{id}','Front\AddressController@edit');
		//更新地址
		Route::post('/address/update/{id}','Front\AddressController@update');
		//删除地址
		Route::get('/address/delete/{id}','Front\AddressController@delete');
		//获取城市信息
		Route::post('/api/cities/getAjaxSelect/{id}','Front\AddressController@CitiesAjaxSelect');

		//活动促销
		Route::get('/product_promp','Front\ProductPrompController@index');
		Route::get('/product_promp/{id}','Front\ProductPrompController@list');

		//团购
		Route::get('/group_sale','Front\ProductGroupController@index');
		//秒杀
		Route::get('/flash_sale','Front\FlashSaleController@index');
		//拼团
		Route::get('/team_sale','Front\TeamSaleController@index');
		Route::get('/team_share/{found_id}','Front\TeamSaleController@share');

	    
	    //银行卡信息列表
	    Route::post('/api/ajax_get_bank_info','Front\BankCardController@ajax_get_bank_info');
	    //保存银行卡信息
	    Route::post('/api/bank_info/save','Front\BankCardController@save_bank_info');
	    //删除银行卡信息
	    Route::post('/api/bank_info/{id}/del','Front\BankCardController@del_bank_info');

        //领取优惠券
        Route::post('/api/userGetCoupons/{coupons_id}','Front\IndexController@userGetCoupons');
        //用户发起提现
        Route::post('/api/withdraw_account','Front\UserController@withdraw_account');

  //       //单页面
  //       
		// //文章分类
		// Route::get('/cat/{id}','Front\ArticleAndPageController@cat');
		// //文章内页
		// Route::get('/post/{id}','Front\ArticleAndPageController@post');
		// //页面内页
		// Route::get('/page/{id}','Front\ArticleAndPageController@page');

		//退换货上传图片
		Route::post('/api/refundUploadImage/{refunds_id}','Admin\OrderRefundController@refundUploadImage');
		//退换货切换图片
		Route::post('/api/switchRefundUploadImage/{or_id}','Admin\OrderRefundController@switchRefundUploadImage');



		// 主题social  新增页面
		Route::get('/find','Front\UserController@withdraw_account');

	
	});
});




// Route::resource('attachConsults', 'AttachConsultController');

