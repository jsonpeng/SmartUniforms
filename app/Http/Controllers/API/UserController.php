<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserLevel;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\UserRepository;

class UserController extends Controller
{

	private $couponRepository;
    private $couponUserRepository;
    private $userRepository;
    public function __construct(
        UserRepository $userRepo,
        CouponUserRepository $couponUserRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->userRepository=$userRepo;
    }

	/**
	 * 用户注册或登录
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
    public function postLogin(Request $request)
    {
    	# nickname
    	# head_image
    	# sex
    	# province
    	# city
    	# country
    	# openid
    	# unionid

    	#检查用户是否注册过
    	$user = null;
    	if ($request->has('unionid')) {
    		$user = User::where('unionid', $request->input('unionid'))->first();
    	}
    	if (empty($user)) {
    		$user = User::where('openid', $request->input('openid'))->first();
    	}
    	
    	if (empty($user)) {
    		# 新用户
    		$user = User::create( $request->all() );
    	}
    	
    	$token = auth()->login($user);
    	return ['status_code' => 0, 'data' => $token];
    }

    /**
     * 用户登出
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postLogout(Request $request)
    {
    	auth()->logout();
    	return ['status_code' => 0, 'data' => '退出登录'];
    }

    /**
     * 获取用户信息带用户等级
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function userInfo(Request $request)
    {
    	$user = auth()->user();
    	$userLevel = null;
    	if( funcOpen('FUNC_MEMBER_LEVEL') ){
            $userLevel = UserLevel::where('id', $user->user_level)->first();
        }
        return ['status_code' => 0, 'data' => [
        	'user' => $user,
        	'userLevel' => $userLevel
        ]];
    }

    /**
     * 用户积分记录
     * @return [type] [description]
     */
    public function credits(Request $request)
    {
    	$user = auth()->user();
    	$skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $creditLogs = $user->creditLogs()->skip($skip)->take($take)->get();
        return ['status_code' => 0, 'data' => $creditLogs];
    }

    /**
     * 用户余额记录
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function funds(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
//        $moneyLogs = $user->moneyLogs()->skip($skip)->take($take)->get();
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take);
        return ['status_code' => 0, 'data' => $moneyLogs];
    }

    /**
     * 用户分佣记录
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function bouns(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take, '分佣');
        return ['status_code' => 0, 'data' => $moneyLogs];
    }

    /**
     * 分销推荐人列表
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function parterners(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $fellows = $this->userRepository->followMembers($user, $skip, $take);
        return ['status_code' => 0, 'data' => $fellows];
    }
    
    /**
     * 获取用户的优惠券
     * @param  Request $request [description]
     * @param  integer $type    [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function coupons(Request $request, $type = -1)
    {
    	$user = auth()->user();
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