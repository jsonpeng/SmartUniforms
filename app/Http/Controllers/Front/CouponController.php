<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use ShoppingCart;
use Carbon\Carbon;

class CouponController extends Controller
{

	private $couponRepository;
    private $couponUserRepository;

    public function __construct(
        CouponUserRepository $couponUserRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->couponUserRepository = $couponUserRepo;
    }


    //全部
    public function index(Request $request, $type = -1)

    {
    	$user = auth('web')->user();
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $coupons = $this->couponRepository->couponGetByStatus($user, $type, $skip, $take);

    	return view(frontView('usercenter.coupon.index'), compact('coupons', 'type'));
    }

    /**
     * 获取可以使用的优惠券 
     * @return [type] [description]
     */
    public function getCoupons()
    {
    	$user = auth('web')->user();
        $coupons = $this->couponRepository->couponCanUse($user);
        //过滤不满足使用条件的优惠券
        $coupons = $coupons->filter(function ($coupon, $key) {
            return app('commonRepo')->CouponPreference($coupon)['code'] == 0;
        });
    	return ['code' => 0, 'message' => $coupons];
    }

    /**
     * 应用选中的优惠券，如果优惠券可使用，则返回使用优惠券后的优惠，如果不能用，则返回不能用的原因
     * @param  Request $request   [description]
     * @param  [type]  $coupon_id [优惠券ID]
     * @return [type]             [description]
     */
    public function getCouponChoose(Request $request, $coupon_id)
    {
        $coupon = $this->couponUserRepository->findWithoutFail($coupon_id);
        return app('commonRepo')->CouponPreference($coupon);
    }

    /**
     * 获取用户的优惠券
     * @param  Request $request [description]
     * @param  integer $type    [description]
     * @return [type]           [description]
     */
    public function ajaxCoupon(Request $request, $type = -1)
    {
        $user = auth('web')->user();
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $coupons = $this->couponRepository->couponGetByStatus($user, $type, $skip, $take);
        return ['status_code' => 0, 'data' => $coupons];
    }
}
