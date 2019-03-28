<?php

namespace App\Repositories;

use App\Repositories\BannerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SpecProductPriceRepository;
use App\Repositories\OrderPrompRepository;
use App\Repositories\OrderRepository;
use App\Repositories\CityRepository;
use App\Repositories\RegCodeRepository;
use App\Repositories\CardRecordRepository;
use App\Repositories\ConsultRecordRepository;
use App\Repositories\MemberCardRepository;
use App\Repositories\ArticlecatsRepository;

use Auth;
use Config;
use ShoppingCart;
use Carbon\Carbon;
use App\Models\CouponUser;
use App\Models\UserLevel;
use App\Models\CreditLog;
use App\Models\MoneyLog;
use App\Models\RefundLog;
use App\Models\OrderAction;
use App\Models\DistributionLog;
use App\Models\MemberCard;
use App\Models\RegCode;
use App\Models\Item;
use App\User;
use Log;

use EasyWeChat\Factory;
use App\Events\OrderPay;
use Overtrue\EasySms\EasySms;

use EasyWeChat\Kernel\Messages\Text;

class CommonRepository
{
    private $memberCardRepository;
    private $productRepository;
    private $couponRepository;
    private $categoryRepository;
    private $couponUserRepository;
    private $specProductPriceRepository;
    private $orderPrompRepository;
    private $orderRepository;
    private $cityRepository;
    private $bannerRepository;
    private $regCodeRepository;
    private $cardRecordRepository;
    private $consultRecordRepository;
    private $ArticlecatsRepository;
    public function __construct(
        MemberCardRepository $memberCardRepo,
        ConsultRecordRepository $consultRecordRepo,
        CouponRepository $couponRepo, 
        CategoryRepository $categoryRepo, 
        CouponUserRepository $couponUserRepo, 
        ProductRepository $productRepo,
        SpecProductPriceRepository $specProductPriceRepo,
        OrderRepository $orderRepo,
        OrderPrompRepository $orderPrompRepo,
        CityRepository $cityRepo,
        BannerRepository $bannerRepo,
        RegCodeRepository $regCodeRepo,
        CardRecordRepository $cardRecordRepo,
        ArticlecatsRepository $ArticlecatsRepo
    )
    {
        $this->memberCardRepository = $memberCardRepo;
        $this->consultRecordRepository = $consultRecordRepo;
        $this->productRepository = $productRepo;
        $this->couponRepository = $couponRepo;
        $this->categoryRepository = $categoryRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->specProductPriceRepository = $specProductPriceRepo;
        $this->orderPrompRepository = $orderPrompRepo;
        $this->orderRepository = $orderRepo;
        $this->cityRepository=$cityRepo;
        $this->bannerRepository = $bannerRepo;
        $this->regCodeRepository=$regCodeRepo;
        $this->cardRecordRepository=$cardRecordRepo;
        $this->ArticlecatsRepository = $ArticlecatsRepo;
    }

    public function catRepo(){
        return $this->ArticlecatsRepository;
    }

    public function memberCardRepo(){
        return $this->memberCardRepository;
    }

    public function consultRecordRepo(){
        return $this->consultRecordRepository;
    }

    public function cardRecordRepo(){
        return $this->cardRecordRepository;
    }

    public function bannerRepo()
    {
        return $this->bannerRepository;
    }

    public function orderRepo()
    {
        return $this->orderRepository;
    }



    /**
     * [导出excel]
     * @param  [type] $filter [表头信息]
     * @param  [type] $data   [导出数据]
     * @param  string $title  [导出标题]
     * @return [type]         [description]
     */
    public function exportExcel($filter,$data,$title='导出记录')
    {
        if(!empty($filter) && is_array($filter))
        #输入到CSV文件中
        $html="\xEF\xBB\xBF";

        foreach ($filter as $key => $value) {
            #循环列 表头
            $html .= trim($value) . "\t,"; 
        }
        #换行
        $html .= "\n";
        foreach ($data as $key => $value) {
                #写入单行文本
                foreach ($filter as $key2 => $val2) {
                   if(isset($value[$key2])) $html .= trim($value[$key2]) . "\t,";
                }
                #换行
                $html .= "\n";
                   
        }
        header("Content-type:text/csv;charset=utf-8");
        $title = iconv("utf-8", "GB2312", $title);
        header("Content-Disposition:attachment;filename={$title}.csv;charset=utf-8");
        echo $html;
        exit;
        // header('Content-type: text/csv; charset=UTF-16LE');
        // header("Content-Disposition:attachment;filename={$title}.csv");
        // //输出BOM
        // echo(chr(255).chr(254));
        // echo(mb_convert_encoding($html,"UTF-16LE","UTF-8"));
        // exit;
    }

    /*导出成table方式
    public function exportExcelTable($filter,$data,$title='导出记录')
    {
        if(!empty($filter) && is_array($filter))

        #输入开始
        $html="<tr>";

        foreach ($filter as $key => $value) {
            #循环列 表头
            $html .= "<td>".$value."</td>"; 
        }

        #结束
        $html .= "</tr>";

        foreach ($data as $key => $value) {
            $html .="<tr>";
                #写入单行文本
                foreach ($filter as $key2 => $val2) {
                   if(isset($value[$key2])) $html .= "<td>".$value[$key2]."</td>";
                }
            $html .="</tr>";       
        }

        header("Content-type:application/vnd.ms-excel;charset=UTF-8");
        $title = iconv("utf-8", "GB2312", $title);
        header("Content-Disposition:attachment;filename={$title}.xls;charset=utf-8");
        echo "<table border=1>".$html."</table>";
        exit;
    }*/

    //导出成table方式
    public function exportExcelTable($filter,$data,$title=null)
    {
        if(!empty($filter) && is_array($filter))

        #输入开始
        $html="<tr>";

        foreach ($filter as $key => $value) {
            $value = iconv("utf-8", "'GB2312//IGNORE",$value);
            #循环列 表头
            $html .= "<td>".$value."</td>"; 
        }

        #结束
        $html .= "</tr>";

        foreach ($data as $key => $value) {
            $html .="<tr>";
                #写入单行文本
                foreach ($filter as $key2 => $val2) {
                   if(isset($value[$key2])) {
                        $one_line =  iconv("utf-8", "'GB2312//IGNORE",$value[$key2]);
                        $html .= "<td>".$one_line."</td>";
                    }
                }
            $html .="</tr>";       
        }

        header("Content-type:application/vnd.ms-excel;charset=UTF-8");
        if (empty($title)) {
            $title = date('Y-m-d-h-i-s');
        }
        $title = iconv("utf-8", "'GB2312//IGNORE", $title);
        header("Content-Disposition:attachment;filename={$title}.xls;charset=utf-8");
        echo "<table border=1>".$html."</table>";
        exit;
    }

    //计算运费
    public function freight($address)
    {
        if (empty($address)) {
            return 0;
        }
        //满额免运费
        // if (getSettingValueByKey('freight_free_limit') <= ShoppingCart::total()) {
        //     return 0;
        // }

        $freight_data=$this->cityRepository->getFreightInfoByAddress($address);

        $lufei = 0;
        //计费方式
        $weightType = $freight_data['freight_type'];
        //首重重量
        $freight_first_weight = $freight_data['freight_first_count'];
        //首重价格
        $freight_first_price = $freight_data['freight_first_price'];
        //续重重量
        $freight_continue_weight = $freight_data['freight_continue_count'];
        //续重价格
        $freight_continue_price = $freight_data['freight_continue_price'];

        if ($weightType == 1) {
            //按重计费
            $weight = 0; //计算运费商品重量
            $items = ShoppingCart::all();

            foreach ($items as $item) {
                //确认用户购买的商品存在
                $tmp = explode('_', $item->id);
                //不带规格
                $product = $this->productRepository->findWithoutFail($tmp[0]);
                if (!empty($product)) {
                    //计算运费
                    if (!$product->free_shipping) {
                        $weight += $product->weight * $item->qty;
                    }
                }
            }
            if ($weight == 0) {
                $lufei = 0;
            } else {
                if ($freight_first_weight >= $weight) {
                    //首重内
                    $lufei = $freight_first_price;
                } else {
                    //超首重
                    $weight_exceed = $weight - $freight_first_weight;
                    if ($freight_continue_weight != 0) {
                        $exceed_num = ceil($weight_exceed/$freight_continue_weight);
                        $lufei = $freight_first_price + $exceed_num * $freight_continue_price;
                    }
                }
            }
        } else {
            //按件计费
            $total_count = ShoppingCart::count();
            if ($freight_first_weight >= $total_count) {
                //首次计件内
                $lufei = $freight_first_price;
            } else {
                //超首计件
                $weight_exceed = $total_count - $freight_first_weight;
                if ($freight_continue_weight != 0) {
                    $exceed_num = ceil($weight_exceed/$freight_continue_weight);
                    $lufei = $freight_first_price + $exceed_num * $freight_continue_price;
                }
            }
        }
        return empty($lufei) ? 0 : $lufei;
    }

    /**
     * 计算优惠券优惠金额
     * @param [integer] $coupon_id [优惠券ID]
     */
    public function CouponPreference($coupon)
    {
        //计算优惠券能不能用
        //$coupon = $this->couponUserRepository->findWithoutFail($coupon_id);
        if (empty($coupon)) {
            return ['code' => 1, 'message' => '优惠券不存在'];
        }
        //检查优惠券状态
        if ($coupon->status != 0) {
            switch ($coupon->status) {
                case 1:
                    return ['code' => 1, 'message' => '优惠券被冻结'];
                    break;
                case 2:
                    return ['code' => 1, 'message' => '优惠券已使用'];
                    break;
                case 3:
                    return ['code' => 1, 'message' => '优惠券已过期'];
                    break;
                case 4:
                    return ['code' => 1, 'message' => '优惠券已作废'];
                    break;
                default:
                    return ['code' => 1, 'message' => '优惠券无法被使用'];
                    break;
            }
        }

        //检查优惠券的有效期
        $today = Carbon::today();
        if ( Carbon::parse($coupon->time_begin)->gt($today) || Carbon::parse($coupon->time_end)->lt($today) ) {
            return ['code' => 1, 'message' => '不在优惠券的使用期限内'];
        }
        //检查优惠券的使用条件
        //金额是否可以达到
        $total = ShoppingCart::total();
        $originCoupon = $coupon->coupon;

        if ($originCoupon->base > $total) {
            return ['code' => 1, 'message' => '无法使用该优惠券，购物金额还差'.($originCoupon->base - $total)];
        }

        $totalPrice = 0;
        $youhui = 0;
        $preferPriceTotal = 0;

        //全场通用型
        if ($originCoupon->range == 0) {
            $preferPriceTotal = $total;
        }

        //指定分类型
        if ($originCoupon->range == 1) {
            $category = $this->categoryRepository->findWithoutFail($originCoupon->category_id);
            if (empty($category)) {
                return ['code' => 1, 'message' => '优惠券不符合使用条件，错误代码E050'];
            }
            //获取分类及其子分类的ID数组
            $productCats = $this->categoryRepository->getChildCatIds($category->id);
            array_push($productCats, $category->id);
            $items = ShoppingCart::all();
            //计算能够优惠的商品金额
            foreach ($items as $item) {
                $tmp = explode('_', $item->id);
                $product = $this->productRepository->findWithoutFail($tmp[0]);
                //商品是否在优惠范围内
                if (in_array($product->category_id, $productCats)) {
                    if ($tmp[1] < 1) {
                        //不带规格
                        $preferPriceTotal += $this->productRepository->getSalesPrice($product, false)*$item->qty;;
                    } else {
                        $specPrice = $this->specProductPriceRepository->findWithoutFail($tmp[1]);
                        $preferPriceTotal += $this->specProductPriceRepository->getSalesPrice($specPrice, false)*$item->qty;;
                    }
                }
            }
            //金额是否达到要求
            if ($originCoupon->base > $preferPriceTotal) {
                return ['code' => 1, 'message' => '无法使用该优惠券，优惠分类商品金额还差'.($originCoupon->base - $preferPriceTotal)];
            }
        }

        //指定商品
        if ($originCoupon->range == 2) {
            $okProducts = $originCoupon->products()->get();

            //获取分类及其子分类的ID数组
            $items = ShoppingCart::all();
            $product = null;

            foreach ($items as $item) {
                $tmp = explode('_', $item->id);
                $product = $this->isInProducts($tmp, $okProducts);
                if (!empty($product)) {
                    if ($tmp[1] < 1) {
                        //不带规格
                        $preferPriceTotal += $this->productRepository->getSalesPrice($product, false)*$item->qty;;
                    } else {
                        $specPrice = $this->specProductPriceRepository->findWithoutFail($tmp[1]);
                        $preferPriceTotal += $this->specProductPriceRepository->getSalesPrice($specPrice, false)*$item->qty;;
                    }
                }
            }
            //金额是否达到要求
            if ($originCoupon->base > $preferPriceTotal) {
                return ['code' => 1, 'message' => '无法使用该优惠券，优惠分类商品金额还差'.($originCoupon->base - $preferPriceTotal)];
            }
        }

        $name = '';
        if ($originCoupon->type == '满减') {
            $youhui = $originCoupon->given;
            $name = '满'.$originCoupon->base.'减'.$originCoupon->given;
        }else{
            $youhui = round((100 - $originCoupon->discount) * $preferPriceTotal/100, 2);
            $name = '满'.$originCoupon->base.'打'.$originCoupon->discount.'折';
        }

        return ['code' => 0, 'message' => [
            'discount' => $youhui,
            'coupon_id' => $coupon->id,
            'name' => $name
        ]];
    }

    /**
     * 订单优惠金额
     * @param  [float] $totalPrice [订单总金额]
     * @return [type]             [description]
     */
    public function orderPreference($totalPrice)
    {
        $orderPromp = $this->orderPrompRepository->getSuitablePromp($totalPrice);
        if (empty($orderPromp)) {
            return ['prom_id' => 0, 'money' => 0, 'name' => ''];
        }else{
            if ($orderPromp->type) {
                //减价
                return ['prom_id' => $orderPromp->id, 'money' => $orderPromp->value, 'name' => '购物满'.$orderPromp->base.'减'.$orderPromp->value];
            } else {
                //打折
                $final = round($totalPrice * (100 - $orderPromp->value) / 100, 2);
                return ['prom_id' => $orderPromp->id, 'money' => $final, 'name' => '购物满'.$orderPromp->base.'打'.$orderPromp->value.'折'];
            }
        }
    }

    /**
     * 用户等级优惠
     * @param [mixed] $user  [用户对象]
     * @param [float] $total [订单总金额]
     */
    public function UserLevelPreference($user, $total)
    {
        if (getSettingValueByKeyCache('user_level_switch') == '不开启') {
            return 0;
        }
        $user_level = UserLevel::where('id',$user->user_level)->first();
        if (!empty($user_level) && $user_level->discount < 100) {
            return round($total * (100 - $user_level->discount) / 100, 2);
        }else{
            return 0;
        }
    }

    /**
     * 用户积分日志
     * @param [type] $amount  [积分余额]
     * @param [type] $change  [ 积分变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗 4管理员操作]
     * @param [type] $user_id [用户ID]
     */
    public function addCreditLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        
        CreditLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 用户余额日志
     * @param [type] $amount  [余额余额]
     * @param [type] $change  [ 余额变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗]
     * @param [type] $user_id [用户ID]
     */
    public function addMoneyLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        MoneyLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 添加分佣记录
     * @param [type] $order            [订单信息]
     * @param [type] $get_money_id     [分佣用户ID]
     * @param [type] $distribute_level [推荐用户等级]
     * @param [type] $given_money      [分佣金额]
     */
    public function addDistributionLog($order, $get_money_id, $distribute_level, $given_money)
    {
        DistributionLog::create([
            'order_user_id' => $order->user_id,
            'user_id' => $get_money_id,
            'commission' => $given_money,
            'order_money' => $order->price,
            'user_dis_level' => $distribute_level,
            'status' => '已发放',
            'order_id' => $order->id
        ]);
    }

    /**
     * 售后日志
     * @param [type] $name            [description]
     * @param [type] $des             [description]
     * @param [type] $order_refund_id [description]
     */
    public function addRefundLog($name, $des, $order_refund_id)
    {
        RefundLog::create([
            'order_refund_id' => $order_refund_id,
            'name' => $name,
            'des' => $des,
            'time' => \Carbon\Carbon::now()
        ]);  
    }
    /**
     * 添加订单操作日志
     * @param [type] $order_status    [订单状态]
     * @param [type] $shipping_status [物流状态]
     * @param [type] $pay_status      [支付状态]
     * @param [type] $action          [操作]
     * @param [type] $status_desc     [描述]
     * @param [type] $user            [操作用户]
     * @param [type] $order_id        [订单ID]
     */
    public function addOrderLog($order_status, $shipping_status, $pay_status, $action, $status_desc, $user, $order_id)
    {
        OrderAction::create([
            'order_status' => $order_status,
            'shipping_status' => $shipping_status,
            'pay_status' => $pay_status,
            'action' => $action,
            'status_desc' => $status_desc,
            'user' => $user,
            'order_id' => $order_id,
        ]);
    }
    
    /**
     * 计算积分减免金额
     * @param [mixed] $user       [用户对象]
     * @param [float] $totalprice [订单总金额]
     * @param [integer] $credits    [积分数目]
     */
    public function CreditPreference($user, $totalprice, $credits)
    {
        $credits = $user->credits > $credits ? $credits : $user->credits;
        //积分现金兑换比例
        $creditRate = getSettingValueByKeyCache('credits_rate');
        //积分最多可抵用金额比例
        $maxTotalRate = getSettingValueByKeyCache('credits_max');
        //最多抵扣金额
        $maxCancel = round($totalprice * $maxTotalRate / 100);

        $credits = ($credits > $maxCancel * $creditRate) ? $maxCancel * $creditRate : $credits;
        return ['credits' => $credits, 'creditPreference' => round($credits / $creditRate, 2)];
    }

    /**
     * 微信授权登录,根据微信用户的授权信息，创建或更新用户信息
     * @param [mixed] $socialUser [微信用户对象]
     */
    public function CreateUserFromWechatOauth($socialUser)
    {
        $user = null;
        $unionid = null;
        //用户是否公众平台用户
        if (array_key_exists('unionid', $socialUser)) {
            $unionid = $socialUser['unionid'];
            $user = User::where('unionid', $socialUser['unionid'])->first(); 
        }
        //不是，则是否是微信用户
        if (empty($user)) {
            $user = User::where('openid', $socialUser['openid'])->first();
        }
        
        if (is_null($user)) {
            $first_level = UserLevel::orderBy('amount', 'asc')->first();
            $user_level  = empty($first_level) ? 0 : $first_level->id;

            //是否自动成为分销用户
            $is_distribute = 0;
            if (getSettingValueByKeyCache('distribution_condition') == '注册用户' && getSettingValueByKeyCache('distribution') == '是') {
                $is_distribute = 1;
            }
            // 新建用户
            $user = User::create([
                'openid' => $socialUser['openid'],
                'unionid' => $unionid,
                'name' => $socialUser['nickname'],
                'nickname' => $socialUser['nickname'],
                'head_image' => $socialUser['headimgurl'],
                'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                'province' => $socialUser['province'],
                'city' => $socialUser['city'],
                'user_level' => $user_level,
                'oauth' => '微信',
                'is_distribute' => $is_distribute
            ]);
            //新注册用户的好处发放
            
        }else{
            
            $user->update([
                'nickname' => $socialUser['nickname'],
                'head_image' => $socialUser['headimgurl'],
                'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                'province' => $socialUser['province'],
                'city' => $socialUser['city']
            ]);
        }
        return $user;
    }


    /**
     * 支付成功后，处理商品订单信息
     * @param  [mixed] $order [订单信息]
     * @return [type]        [description]
     */
    public function processOrder($order, $pay_platform='微信支付', $pay_no=000000){
        //修改订单状态
        $order->update(['order_pay' => '已支付', 'pay_time' => Carbon::now(), 'pay_platform' => $pay_platform, 'pay_no' => $pay_no]);

        //减库存
        if (getSettingValueByKey('inventory_consume') == '支付成功') {
            $this->orderRepository->deduceInventory($order->id);
        }
        
        //发送提醒
        event(new OrderPay($order));

        //生成激活码
        //$this->generateCode($order);
        
        
        //如果存在激活信息
        if(!empty($order->code)){
            $user =User::find($order->user_id);

            if(!empty($user)){

            $reg_code =RegCode::where('code',$order->code)->first();

            if(!empty($reg_code)){

                $reg_code->update(['status'=>1]);
        
                MemberCard::where('code',$order->code)->delete();

                MemberCard::create([
                        'register_type' =>'微信',
                        'mobile' => $user->mobile,
                        'code' => $order->code,
                ]);
                app('commonRepo')->weixinText('亲爱的家长 您的智能标 '.  $order->code .' 已经激活，如果您孩子的物品回到了学校的失物招领处，我们会在早上7点发短信及公众号消息通知您！',$user->openid);
                }
            }
        }
        //购物券
        CouponUser::where('order_id', $order->id)->update(['status' => '已使用']);
    }

    //生成激活码
    public function generateCode($order)
    {

        $items = $order->items;
        foreach ($items as $key => $item) {

            #生成新的激活码并且给予
            $randomString = $this->regCodeRepository->newCode(true);
            $item->register_code = $randomString;
            $item->save();

            #把激活码的状态更新
            $this->regCodeRepository->updateRelByCode($randomString, ['status'=>1]);
        }

    }

    private function randomString($length = 6)
    { 
        // 密码字符集，可任意添加你需要的字符 
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
        $password = ''; 
        for ( $i = 0; $i < $length; $i++ ) 
        { 
        // 这里提供两种字符获取方式 
        // 第一种是使用 substr 截取$chars中的任意一位字符； 
        // 第二种是取字符数组 $chars 的任意元素 
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
        }
        //判断是否重复
        if (Item::where('register_code', $password)->count()) {
            return $this->randomString();
        } else {
            return $password; 
        }
    } 

    /**
     * 激活积分卡
     * @param  [type] $type     [激活渠道 手机、微信]
     * @param  [type] $code     [激活码]
     * @param  [type] $identify [用户标识，手机号或者OPENID]
     * @return [type]           [description]
     */
    public function activeMemberCard($type, $code, $user)
    {
        $identify=null;
        $status=false;
        //激活格式是 手机号_激活码
        $infoes = explode("_", $code);
        
        if (count($infoes) != 2) {
            return $status;
        }

        $reg_code = RegCode::where('code',$infoes[1])->first();

        if(empty($reg_code)){
            return $status;
        }

        $price = $reg_code->price;

        $order_attr =[
            'user_id' =>  $user->id,
            'snumber' => '',
            'price' =>  $price,
            'origin_price'=> $price,
            'preferential'=>0,
            'freight'=>0,
            'cost' =>0,
            'code'=>$infoes[1]
        ];
    
        $order = app('commonRepo')->orderRepo()->create($order_attr);

        app('commonRepo')->orderRepo()->update([
                'snumber' => 6000000 + $order->id
        ], $order->id);
         
        return $order->id;
    }


    /**
     * 取消订单操作
     * @param  [type] $orderCancel [order对象]
     * @return [type]              [description]
     */
    public function cancelOrderOperation($orderCancel)
    {
        if ($orderCancel->auth == 0) {
            //待审核不处理
            return;
        }

        if ($orderCancel->auth == 1) {
            //通过审核
            $order = $this->orderRepository->findWithoutFail($orderCancel->order_id);
            if ($order->order_pay == '未支付') {
                return;
            }
            if ($orderCancel->refound == 0) {
                //资金原路返回
                //返还现金
                $payment = Factory::payment(Config::get('wechat.payment.default'));
                // 参数分别为：商户订单号、商户退款单号、订单金额、退款金额、其他参数
                $result = $payment->refund->byOutTradeNumber($order->snumber, $order->snumber.'refund', $order->price, $order->price, [
                    'refund_desc' => '订单取消退款',
                ]);
                //返还积分
                $user = User::find($order->user_id);
                $user->credits = $user->credits + $order->credits;
                $this->addCreditLog($user->credits, $order->credits, '订单取消，退还积分', 0, $order->user_id);
                
                //返还余额
                $user->user_money = $user->user_money + $order->user_money_pay;
                $user->save();
                $this->addMoneyLog($user->user_money, $order->user_money_pay, '订单取消，退还余额', 0, $order->user_id);

                //返还优惠券
                CouponUser::where('order_id', $order->id)->update(['status' => '未使用']);
            } else {
                //资金返回到余额
                //返还积分
                $user = User::find($order->user_id);
                $user->credits = $user->credits + $order->credits;
                $this->addCreditLog($user->credits, $order->credits, '订单取消，退还积分', 0, $order->user_id);
                
                //返还余额
                $user->user_money = $user->user_money + $order->user_money_pay + $order->price;
                $user->save();
                $this->addMoneyLog($user->user_money - $order->price, $order->user_money_pay, '订单取消，退还余额', 0, $order->user_id);
                $this->addMoneyLog($user->user_money, $order->price, '订单取消，将用户支付的现金退还到余额', 0, $order->user_id);

                //返还优惠券
                CouponUser::where('order_id', $order->id)->update(['status' => '未使用']);
            }
        }

        if ($orderCancel->auth == 2) {
            //审核不通过
            $order->status = '未确认';
            $order->save();
        }
        
    }

    /**
     * 给用户发放优惠券
     * @param  [mixed] $user   [用户对象]
     * @param  [mixed] $coupon [优惠券对象]
     * @param  [integer] $count  [发放数量]
     * @param  string $reason [发送理由]
     * @return [type]         [description]
     */
    public function issueCoupon($user, $coupon, $count, $reason='系统发放')
    {
        // 拥有该优惠券的数量受限
        if ($coupon->max_count) {
            $coupon_issue_count = CouponUser::where('user_id', $user->id)->where('coupon_id', $coupon->id)->count();
            if ($coupon_issue_count >= $coupon->max_count) {
                return;
            }
        }

        $time_begin = null;
        $time_end = null;
        if ($coupon->time_type == 0) {
            //固定时间有效期
            $time_begin = $coupon->time_begin;
            $time_end = $coupon->time_end;
        }else{
            //领券开始计算
            $time_begin = Carbon::today();
            $time_end = Carbon::today()->addDays($coupon->expire_days);
        }
        // 发放
        for ($i=0; $i < $count; $i++) { 
            CouponUser::create([
                'from_way' => $reason,
                'time_begin' => $time_begin,
                'time_end' => $time_end,
                'status' => 0,
                'user_id' => $user->id,
                'coupon_id' => $coupon->id
            ]);
        }
    }

    /**
     * [processGivenCoupon 给用户发放优惠券]
     * @param  [type] $users          [$user collection]
     * @param  [type] $couponIdsArray [coupon ids array]
     * @param  [type] $count          [发放数量]
     * @return [type]                 [description]
     */
    public function processGivenCoupon($users, $couponIdsArray, $count, $reason = '系统发放')
    {
        if (!is_array($couponIdsArray)) {
            return;
        }
        foreach ($users as $user) {
            foreach ($couponIdsArray as $key => $id) {
                $coupon = $this->couponRepository->findWithoutFail($id);
                if (empty($coupon)) {
                    continue;
                }
                $this->issueCoupon($user, $coupon, $count, $reason);
            }
        }
    }

    /**
     * 根据product_id和spec_price_id查找商品信息
     * @param  [type]  $idArray  [description]
     * @param  [type]  $products [description]
     * @return boolean           [description]
     */
    private function isInProducts($idArray, $products){
        foreach ($products as $product) {
            if ($idArray[0] == $product->id && $idArray[1] == $product->pivot->spec_price_id) {
                return $product;
            }
        }
        return null;
    }


    //发送短信验证码
    public function sendVerifyCode($mobile,$time=null,$address=null,$product=null,$template=0)
    {
        $content = sms_tem_content($time,$address,$product,$template);
        $sms_tem = sms_tem_id($template);
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => Config::get('zcjy.SMS_ID'),
                    'access_key_secret' => Config::get('zcjy.SMS_KEY'),
                    'sign_name' => Config::get('zcjy.SMS_SIGN'),
                ]
            ],
        ];

        $easySms = new EasySms($config);
        Log::info($config);
        Log::info([
            'content'  => $content,
            'template' => $sms_tem, //Config::get('zcjy.SMS_TEMPLATE_VERIFY')
            'data' => [
                'time' => $time,
                'address'=>empty($address) ? '未知地址' : $address,
                'product'=>empty($product) ? '未知物品' : $product
            ],
        ]);
        $easySms->send($mobile, [
            'content'  => $content,
            'template' => $sms_tem, //Config::get('zcjy.SMS_TEMPLATE_VERIFY')
            'data' => [
                'time' => $time,
                'address'=>empty($address) ? '未知地址' : $address,
                'product'=>empty($product) ? '未知物品' : $product
            ],
        ]);    
    }

    public function weixinText($message, $openId)
    {
        $result = app('wechat.official_account')->customer_service->message($message)->to($openId)->send();
        //$text = new Text('您好！overtrue。');
        // app('wechat.official_account')->template_message->send([
        //     'touser' => $openId,
        //     'template_id' => '0hc11d00RWw63JtDaqjrSj0X1a-_2pDxBPCuSzSBCg4',
        //     'url' => 'http://shop.eagletags.com',
        //     'data' => [
        //         'first'=> '吉丁甲为您找到以下信息',
        //         // 'keyword1' => time(),
        //         // 'keyword2' => '杭州',
        //         // 'keyword3' => '衣服',
        //         // 'keyword4' =>  Carbon::now(),
        //         'remark' => $message
        //     ],
        // ]);
        return $result;
    }

    
    
}
