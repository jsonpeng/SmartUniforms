@extends('admin.layouts.app')


@section('content')
<section class="content pdall0-xs pt10-xs">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">商城设置</span>
                </a>
            </li>
            <li class="active">
                <a href="#tab_1" data-toggle="tab">网站设置</a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab">购物设置</a>
            </li>
            @if(funcOpen('FUNC_CREDITS'))
            <li>
                <a href="#tab_3" data-toggle="tab">积分设置</a>
            </li>
            @endif
            <!--li>
            <a href="#tab_4" data-toggle="tab">分销设置</a>
            </li>
            <li>
                <a href="#tab_5" data-toggle="tab">短信设置</a>
            </li-->

            <li>
                <a href="#tab_8" data-toggle="tab">其他设置</a>
            </li>
          {{--   <li>
                <a href="#tab_9" data-toggle="tab">其他设置</a>
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form1">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">名称<span class="bitian">(必填)</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" maxlength="60" placeholder="网站名称" value="{{ getSettingValueByKey('name') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="logo" class="col-sm-3 control-label">网站LOGO</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image1" name="logo" placeholder="网站LOGO" value="{{ getSettingValueByKey('logo') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('logo')) {{ getSettingValueByKey('logo') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                    </div>
                                    <p class="help-block">默认网站首页LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                                </div>
                            </div>

                            @if(funcOpen('FUNC_SEO'))
                            <div class="form-group">
                                <label for="seo_title" class="col-sm-3 control-label">网站标题</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_title" maxlength="60" placeholder="网站标题" value="{{ getSettingValueByKey('seo_title') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="seo_des" class="col-sm-3 control-label">网站描述</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_des" maxlength="60" placeholder="网站描述" value="{{ getSettingValueByKey('seo_des') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="seo_keywords" class="col-sm-3 control-label">网站关键字</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_keywords" maxlength="60" placeholder="网站关键字" value="{{ getSettingValueByKey('seo_keywords') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="icp" class="col-sm-3 control-label">ICP备案信息</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="icp" maxlength="60" placeholder="ICP备案信息" value="{{ getSettingValueByKey('icp') }}">
                                    <p class="help-block">网站备案号，将显示在前台底部欢迎信息等位置</p>
                                </div>
                            </div>
                            @endif
                         <div class="form-group">
                                <label for="icp" class="col-sm-3 control-label">ICP备案信息</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="icp" maxlength="60" placeholder="ICP备案信息" value="{{ getSettingValueByKey('icp') }}">
                                    <p class="help-block">网站备案号，将显示在前台底部欢迎信息等位置</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="service_tel" class="col-sm-3 control-label">服务电话</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="service_tel" maxlength="60" placeholder="网站标题" value="{{ getSettingValueByKey('service_tel') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="weixin" class="col-sm-3 control-label">微信公众号</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image2" name="weixin" placeholder="微信公众号二维码" value="{{ getSettingValueByKey('weixin') }}">
                               <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image2')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('weixin')) {{ getSettingValueByKey('weixin') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                    </div>
                                </div>
                            </div>

                                <div class="form-group">
                                <label for="weixin" class="col-sm-3 control-label">PC端首页主图(建议大小1920*900)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image3" name="pc_index_img" placeholder="PC端首页主图" value="{{ getSettingValueByKey('pc_index_img') }}">
                               <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image3')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('pc_index_img')) {{ getSettingValueByKey('pc_index_img') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                    </div>
                                </div>
                            </div>

                                <div class="form-group">
                                <label for="mobile_index_img" class="col-sm-3 control-label">移动端首页主图(建议大小640*960)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image4" name="mobile_index_img" placeholder="移动端首页主图" value="{{ getSettingValueByKey('mobile_index_img') }}">
                               <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image4')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('mobile_index_img')) {{ getSettingValueByKey('mobile_index_img') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                    </div>
                                </div>
                            </div>

                            @if(funcOpen('FUNC_MEMBER_LEVEL'))
                            <div class="form-group">
                                <label for="user_level_switch" class="col-sm-3 control-label">开启用户等级</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="user_level_switch" value="开启" @if( '开启' == getSettingValueByKey('user_level_switch') )checked="" @endif>开启</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="user_level_switch" value="不开启" @if( '不开启' == getSettingValueByKey('user_level_switch') || '' == getSettingValueByKey('user_level_switch') )checked="" @endif>不开启</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if(funcOpen('FUNC_BIND_MOBILE'))
                            <div class="form-group">
                                <label for="account_bind" class="col-sm-3 control-label">第三方登录是否必须绑定账号</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="account_bind" value="是" @if( '是' == getSettingValueByKey('account_bind') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="account_bind" value="否" @if( '否' == getSettingValueByKey('account_bind') )checked="" @endif>否</label>
                                    </div>
                                    <p class="help-block">否: 第三方账号首次登录时会自动创建账号, 不需要额外绑定账号</p>
                                    <p class="help-block">
                                        是:(推荐)第三方账号首次登录时必须先绑定一个注册账号, 否则无法购买商品(优点:可以避免微商城, PC端产生多账户问题)
                                    </p>
                                </div>
                            </div>
                            @endif

                            {{--  <div class="form-group">
                                <label for="jihuo_success_info" class="col-sm-3 control-label">激活成功提示</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  rows="3" name="jihuo_success_info" maxlength="60" placeholder="激活成功提示模板" >{{ getSettingValueByKey('jihuo_success_info') }} </textarea></div>
                            </div> --}}

                {{--             <div class="form-group">
                                <label for="weixin" class="col-sm-3 control-label">尺码选项</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control"  id="chima_list" name="chima_list" placeholder="尺码选项(多个选择使用回车换行，一行一个选项)" rows="{!! count(chimaList()) !!}">{!! getSettingValueByKey('chima_list') !!}</textarea>
                                    <p class="help-block">多个选择使用回车换行，一行一个选项</p>
                                </div>
                            </div>
 --}}
                            <div class="form-group">
                                <label for="weixin" class="col-sm-3 control-label">自动发送短信时间</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="send_sms_time">
                                        <option value="now"   @if(getSettingValueByKey('send_sms_time') == 'now') selected="selected" @endif>即刻</option>
                                        <option value="07:00" @if(getSettingValueByKey('send_sms_time') == '07:00') selected="selected" @endif>早上7点</option>
                                        <option value="07:30" @if(getSettingValueByKey('send_sms_time') == '07:30') selected="selected" @endif>早上7点30</option>
                                        <option value="08:00" @if(getSettingValueByKey('send_sms_time') == '08:00') selected="selected" @endif>早上8点</option>
                                        <option value="08:30" @if(getSettingValueByKey('send_sms_time') == '08:30') selected="selected" @endif>早上8点30</option>
                                        <option value="07:30" @if(getSettingValueByKey('send_sms_time') == '07:30') selected="selected" @endif>早上7点30</option>
                                        <option value="11:00" @if(getSettingValueByKey('send_sms_time') == '11:00') selected="selected" @endif>早上11点</option>
                                        <option value="12:00" @if(getSettingValueByKey('send_sms_time') == '12:00') selected="selected" @endif>中午12点</option>
                                        <option value="15:00" @if(getSettingValueByKey('send_sms_time') == '15:00') selected="selected" @endif>下午3点</option>
                                        <option value="16:00" @if(getSettingValueByKey('send_sms_time') == '16:00') selected="selected" @endif>下午4点</option>
                                        <option value="17:00" @if(getSettingValueByKey('send_sms_time') == '17:00') selected="selected" @endif>下午5点</option>
                                        <option value="17:40" @if(getSettingValueByKey('send_sms_time') == '17:40') selected="selected" @endif>下午5点40</option>
                                        <option value="18:00" @if(getSettingValueByKey('send_sms_time') == '18:00') selected="selected" @endif>下午6点</option>
                                        <option value="19:00" @if(getSettingValueByKey('send_sms_time') == '19:00') selected="selected" @endif>下午7点</option>
                                        <option value="20:00" @if(getSettingValueByKey('send_sms_time') == '20:00') selected="selected" @endif>下午8点</option>
                                        <option value="21:00" @if(getSettingValueByKey('send_sms_time') == '21:00') selected="selected" @endif>下午9点</option>
                                        <option value="22:00" @if(getSettingValueByKey('send_sms_time') == '22:00') selected="selected" @endif>下午10点</option>
                                    </select>
                                </div>
                            </div>

                                        <div class="form-group">
                                <label for="mobile_index_img_hezuo" class="col-sm-3 control-label">合作学校图(建议大小640*801)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image41" name="mobile_index_img_hezuo" placeholder="合作学校图" value="{{ getSettingValueByKey('mobile_index_img_hezuo') }}">
                               <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image41')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('mobile_index_img_hezuo')) {{ getSettingValueByKey('mobile_index_img_hezuo') }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                                    </div>
                                </div>
                            </div>


                    {{--          <div class="form-group">
                                <label for="send_sms_tem" class="col-sm-3 control-label">短信模板</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="send_sms_tem">
                                        <option value="0"   @if(getSettingValueByKey('send_sms_tem') == '0') selected="selected" @endif>默认(亲爱的家长，我们于{time}在{address}发现了您的{product}，请知悉。)</option>
                                        <option value="1"   @if(getSettingValueByKey('send_sms_tem') == '1') selected="selected" @endif>备选(亲爱的家长，您的{product}于{time}已经安放在{address}，请速领取。)</option>
                                   </select>
                                </div>
                            </div> --}}

                     {{--        <div class="form-group">
                                <label for="seo_title" class="col-sm-3 control-label">激活智能标金额</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="active_price" maxlength="60" placeholder="激活智能标金额" value="{{ getSettingValueByKey('active_price') }}"></div>
                            </div> --}}

                        </form>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(1)">保存</button>
                    </div>
                    <!-- /.box-footer --> </div>
            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form2">
                             <div class="form-group">
                                <label for="category_level" class="col-sm-3 control-label">商品分类等级</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="category_level"  placeholder="商品分类等级" value="{{ getSettingValueByKey('category_level') }}">
                                    <p class="help-block">设置商品的分类等级，值为0-3，设置为0则不对商品分类。 设置商品分类是为了便于商品管理和展示</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inventory_default" class="col-sm-3 control-label">默认库存</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inventory_default"  maxlength="10" placeholder="默认库存" value="{{ getSettingValueByKey('inventory_default') }}">
                                    <p class="help-block">设置商品的默认库存，上传商品的时候可以单独设置商品的库存，如果不设置将使用默认库存，-1表示无限量库存</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inventory_warn" class="col-sm-3 control-label">库存预警数</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inventory_warn" maxlength="10" placeholder="库存预警数" value="{{ getSettingValueByKey('inventory_warn') }}">
                                <p class="help-block">库存小于预警数值，将会提醒用户</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="freight_free_limit" class="col-sm-3 control-label">全场满多少免运费(0表示不免运费)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="freight_free_limit" maxlength="10" placeholder="全场满多少免运费 0不免运费" value="{{ getSettingValueByKey('freight_free_limit') }}">
                                        <span class="input-group-addon">元</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="auto_complete" class="col-sm-3 control-label">自动确认收货时间</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="auto_complete" maxlength="10" placeholder="" value="{{ getSettingValueByKey('auto_complete') }}">
                                        <span class="input-group-addon">天</span>
                                    </div>
                                </div>
                            </div>

                            @if(funcOpen('FUNC_AFTERSALE'))
                            <div class="form-group">
                                <label for="after_sale_time" class="col-sm-3 control-label">多少天内可申请售后</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="after_sale_time" maxlength="10" placeholder="" value="{{ getSettingValueByKey('after_sale_time') }}">
                                        <span class="input-group-addon">天</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="form-group">
                                <label for="inventory_consume" class="col-sm-3 control-label">减库存的时机</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inventory_consume" value="下单成功" @if( '下单成功' == getSettingValueByKey('inventory_consume') )checked="" @endif>下单成功</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="inventory_consume" value="支付成功" @if( '支付成功' == getSettingValueByKey('inventory_consume') )checked="" @endif>支付成功</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="after_sale_time" class="col-sm-3 control-label">订单支付超时时间(0表示永不过期)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="order_expire_time" maxlength="10" placeholder="" value="{{ getSettingValueByKey('order_expire_time') }}">
                                        <span class="input-group-addon">小时</span>
                                    </div>
                                </div>
                            </div>


                            @if (funcOpen('FUNC_CASH_WITHDRWA'))
                                <p class="help-block">提现设置</p>
                                <div class="form-group">
                                    <label for="withdraw_limit" class="col-sm-3 control-label">满多少才能提现</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="withdraw_limit" placeholder="满多少才能提现" value="{{ getSettingValueByKey('withdraw_limit') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdraw_min" class="col-sm-3 control-label">最少提现额度</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="withdraw_min" placeholder="最少提现额度" value="{{ getSettingValueByKey('withdraw_min') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="after_sale_time" class="col-sm-3 control-label">单日最多提现多少次</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="withdraw_day_max_num" maxlength="10" placeholder="" value="{{ getSettingValueByKey('withdraw_day_max_num') }}">
                                           
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(2)">保存</button>
                    </div>
                </div>
            </div>
            
            @if(funcOpen('FUNC_CREDITS'))
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form3">
                            <div class="form-group">
                                <label for="credits_alias" class="col-sm-3 control-label">积分别名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="credits_alias" maxlength="10" placeholder="积分别名" value="{{ getSettingValueByKey('credits_alias') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="register_credits" class="col-sm-3 control-label">注册赠送积分</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="register_credits" maxlength="10" placeholder="赠送数值" value="{{ getSettingValueByKey('register_credits') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="invite_credits" class="col-sm-3 control-label">邀请人获赠积分</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="invite_credits" maxlength="10" placeholder="" value="{{ getSettingValueByKey('invite_credits') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="consume_credits" class="col-sm-3 control-label">购物送积分比例(占商品总金额)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="consume_credits" maxlength="3" placeholder="" value="{{ getSettingValueByKey('consume_credits') }}">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="credits_rate" class="col-sm-3 control-label">1元能兑换多少积分</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="credits_rate" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_rate') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="credits_switch" class="col-sm-3 control-label">积分可抵扣订单金额</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="credits_switch" value="是" @if( '是' == getSettingValueByKey('credits_switch') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="credits_switch" value="否" @if( '否' == getSettingValueByKey('credits_switch') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="credits_min" class="col-sm-3 control-label">最低多少积分才能使用</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="credits_min" maxlength="10" placeholder="" value="{{ getSettingValueByKey('credits_min') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="credits_max" class="col-sm-3 control-label">积分抵扣订单金额上限(比例)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="credits_max"  maxlength="3" placeholder="" value="{{ getSettingValueByKey('credits_max') }}">
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(3)">保存</button>
                    </div>
                </div>
            </div>
            @endif

            
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_4"></div>
            <!-- /.tab-pane
            <div class="tab-pane" id="tab_5">
                <div class="box box-info form">
                    <div class="box-body">
                        <form class="form-horizontal" id="form5">
                            <div class="form-group">
                                <label for="sms_platform" class="col-sm-3 control-label">短信平台(目前只支持阿里云)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_platform" disabled="" placeholder="短信平台" value="{{ getSettingValueByKey('sms_platform') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="sms_appkey" class="col-sm-3 control-label">短信平台[APP_KEY]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_appkey"   maxlength="60" placeholder="Access Key ID" value="{{ getSettingValueByKey('sms_appkey') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="sms_secretKey" class="col-sm-3 control-label">短信平台[APP_SECRET]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_secretKey" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_secretKey') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="sms_sign" class="col-sm-3 control-label">签名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_sign" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_sign') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="sms_vevify_template" class="col-sm-3 control-label">验证短信模板</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_vevify_template" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_vevify_template') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="sms_notify_template" class="col-sm-3 control-label">通知消息模板</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sms_notify_template" maxlength="60" placeholder="Access Key Secret" value="{{ getSettingValueByKey('sms_notify_template') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="sms_send_register" class="col-sm-3 control-label">用户注册时是否发送短信</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_register" value="是" @if( '是' == getSettingValueByKey('sms_send_register') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_register" value="否" @if( '否' == getSettingValueByKey('sms_send_register') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sms_send_password" class="col-sm-3 control-label">用户找回密码时是否发送短信</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_password" value="是" @if( '是' == getSettingValueByKey('sms_send_password') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_password" value="否" @if( '否' == getSettingValueByKey('sms_send_password') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sms_send_account_check" class="col-sm-3 control-label">身份验证时是否发送短信</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_account_check" value="是" @if( '是' == getSettingValueByKey('sms_send_account_check') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_account_check" value="否" @if( '否' == getSettingValueByKey('sms_send_account_check') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sms_send_order" class="col-sm-3 control-label">用户下单时是否发送短信给商家</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_order" value="是" @if( '是' == getSettingValueByKey('sms_send_order') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_order" value="否" @if( '否' == getSettingValueByKey('sms_send_order') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sms_send_pay" class="col-sm-3 control-label">客户支付时是否发短信给商家</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_pay" value="是" @if( '是' == getSettingValueByKey('sms_send_pay') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_pay" value="否" @if( '否' == getSettingValueByKey('sms_send_pay') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sms_send_deliver" class="col-sm-3 control-label">商家发货时是否给客户发短信</label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_deliver" value="是" @if( '是' == getSettingValueByKey('sms_send_deliver') )checked="" @endif>是</label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sms_send_deliver" value="否" @if( '否' == getSettingValueByKey('sms_send_deliver') )checked="" @endif>否</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(5)">保存</button>
                    </div>
                </div>
            </div>  -->

            <div class="tab-pane" id="tab_8">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form8">
                            <div class="form-group">
                                <label for="feie_sn" class="col-sm-3 control-label">每页显示记录数量</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="records_per_page" value="{{ getSettingValueByKey('records_per_page') }}"></div>
                            </div>
                            <div class="form-group">
                                <label for="feie_sn" class="col-sm-3 control-label">订单提醒邮箱</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" value="{{ getSettingValueByKey('email') }}"></div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(8)">保存</button>
                    </div>
                </div>
            </div>
    {{--         <div class="tab-pane" id="tab_9">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form9">
                            <div class="form-group">
                                <label for="freight_first_weight" class="col-sm-3 control-label">每页显示信息条目</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="records_per_page" maxlength="10" placeholder="" value="{{ getSettingValueByKey('records_per_page') }}"></div>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right" onclick="saveForm(9)">保存</button>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- /.tab-content -->
    </div>
</section>
@endsection

@include('admin.partials.imagemodel')

@section('scripts')
<script>
        function saveForm(index){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/settings/setting",
                type:"POST",
                data:$("#form"+index).serialize(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            }); 
        }

        $('#chima_list').keypress(function(e) {  
            var rows=parseInt($(this).attr('rows'));
            // 回车键事件  
           if(e.which == 13) {  
                rows +=1;
           }  
           $(this).attr('rows',rows);
       });
    </script>
@endsection