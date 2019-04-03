<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Theme;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\CouponRepository;

use App\Repositories\BannerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\FlashSaleRepository;
use App\Repositories\TeamSaleRepository;
use App\Repositories\PostRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Mail;
use App\Models\Order;
use App\Models\School;
use App\Models\ConsultRecord;
use App\Models\AttachConsult;
use App\Models\SchoolClass;

class IndexController extends Controller
{

    private $couponRepository;
    private $bannerRepository;
    private $productRepository;
    private $flashSaleRepository;
    private $teamSaleRepository;
    private $postRepository;
    public function __construct(
        ProductRepository $productRepo, 
        CouponRepository $couponRepo,
        BannerRepository $bannerRepo, 
        FlashSaleRepository $flashSaleRepo,
        TeamSaleRepository $teamSaleRepo,
        PostRepository $postRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->bannerRepository = $bannerRepo;
        $this->productRepository = $productRepo;
        $this->flashSaleRepository = $flashSaleRepo;
        $this->teamSaleRepository = $teamSaleRepo;
        $this->postRepository = $postRepo;
    }

    //商城首页
    public function index(Request $request){
        //banners
        $banners = $this->bannerRepository->getBannerCached('index');
        //获取推荐分类给前端
        $categories = Category::where('recommend', 1)->orderBy('sort', 'desc')->get();
        //秒杀倒计时给前端需要倒计时的时间
        $cur = processTime( Carbon::now() );
        $time = $cur->copy()->addHours(2);
        //获取手动领取的优惠券
        $coupons=$this->couponRepository->getCouponOfRule(4);
        //新品
        $newProducts = $this->productRepository->newProducts(0, 8);
        //促销商品
        $prompProducts = $this->productRepository->productsOfCurPromp(0, 8);
        //秒杀商品
        $flashSaleProduct = $this->flashSaleRepository->salesBetweenTime(0, 3);
        //拼团商品
        $teamSaleProduct = $this->teamSaleRepository->getTeamSales(0, 3);
        //全部商品
        $products = $this->productRepository->products(0, 1000);

        $input = $request->all();

        if(isset($input['cat_id']) && !empty($input['cat_id'])){
             $products = $this->productRepository->getProductsOfCatWithChildrenCatsCached($input['cat_id'],0,1000);
        }
     


        return view(frontView('index'), compact('banners', 'categories', 'time', 'coupons', 'newProducts', 'prompProducts', 'products', 'flashSaleProduct', 'teamSaleProduct','input'));
    }

    //用户领取优惠券
    public function userGetCoupons($coupons_id){
        $user=auth('web')->user();
        if(!empty($user)){
            app('commonRepo')->processGivenCoupon([$user], [$coupons_id], 1, '手动领取');
            return ['code'=>0,'message'=>'领取成功'];
        }else{
            return ['code'=>1,'message'=>'请先登录'];
        }
    }

    //激活页面
    public function  activation(Request $request){
        $user=auth('web')->user();
        return view(frontView('active'),compact('user'));
    }


    //我的调换记录 征订单/调换单
    public function myConsultLog(Request $request,$type='调换单') 
    {
        $user = auth('web')->user();
        $logs = ConsultRecord::where('user_id',$user->id)->where('type',$type)->orderBy('created_at','desc')->get();
        return view(frontView('my_consult_log'),compact('logs','type'));
    }

    //我的征询记录

    //我的征订详情
    public function myConsultDetailLog(Request $request,$id,$type='调换单')
    {
        $log = ConsultRecord::find($id);
        if(empty($log)){
            return redirect('/usercenter');
        }
        $schools = School::all();
        $logs = AttachConsult::where('consult_id',$log->id)->get();
        return view(frontView('my_consult_log_detail'),compact('log','schools','logs','type'));
    }

    //填写调换单
    public function createConsult(Request $request){
         $input = $request->all();
         // $schools = School::all();
         // $products = Product::where('type','校服')->where('shelf', 1)->get();
         // dd($products);
         return view(frontView('consult'),compact('input'));
    }

    //填写征订单
    public function createConsultSub(Request $request){
           $input = $request->all();
            return view(frontView('zhengding'),compact('input'));
    }

    //根据商品名称和规格尺码获取价格
    public function getPriceByNameAndChima(Request $request){
            $input = $request->all();
            if(!array_key_exists('name',$input) || !array_key_exists('key',$input)){
                return ['code'=>1,'message'=>'参数不完整'];
            }
            $product = Product::where('name',$input['name'])->where('shelf',1)->first();
            if(empty($product)){
                return ['code'=>1,'message'=>'没有找到该商品'];
            }
            $specs = $product->specs;
            $price = 0;
             if(count($specs)){
                foreach ($specs as $key => $value) {
                   if($input['key'] == $value->key_name){
                        $price = $value->price;
                   }
                }
             }
             return ['code'=>0,'message'=>$price];
    }

    //通过学校代码获取学校名称及获取对应学校的衣服
    public function getSchoolInfoByCode(Request $request)
    {
        $input = $request->all();
        if(!array_key_exists('code',$input)){
            return ['code'=>1,'message'=>'参数不完整'];
        }
        $school = School::where('number',$input['code'])->first();
        if(empty($school)){
            return ['code'=>1,'message'=>'学校代码输入错误'];
        }
        $user = auth('web')->user();
        $user->update(['school_name'=>$school->name]);
        $products = Product::where('school_name',$school->name)->where('shelf', 1)->get();
        return ['code'=>0,'message'=>['school'=>$school,'products'=>$products]];

    }

    private function dealArray($input,$key){
        if(isset($input[$key]) && !is_array($input[$key])){
            $input[$key] = explode(',', $input[$key]);
        }
        return $input[$key];
    }

    //保存征询单记录
    public function saveConsult(Request $request)
    {
        $input = $request->all();
        if(!array_key_exists('pname',$input) || !array_key_exists('chima',$input) || !array_key_exists('zengding',$input) || !array_key_exists('tuihui',$input)){
            return ['code'=>1,'message'=>'请选择校服'];
        }
    
        $record = ConsultRecord::create(
            [
                'name' => $input['name'],
                'class'=>$input['class'],
                'shengao'=>$input['shengao'],
                'tizhong'=>$input['tizhong'],
                'remark'=>$input['remark'],
                'user_id'=>$input['user_id'],
                'sex'=>$input['sex'],
                'school_name'=>$input['school_name'],
                'commit'=> $input['commit'],
                'type'=>$input['type']
        ]
    );

        $input['pname'] = $this->dealArray($input,'pname');
        $input['chima'] = $this->dealArray($input,'chima');
        $input['zengding'] = $this->dealArray($input,'zengding');
        $input['tuihui'] = $this->dealArray($input,'tuihui');
        $input['price'] = $this->dealArray($input,'price');
        if(count($input['pname']) && count($input['chima']) && count($input['zengding']) && count($input['tuihui'])){
            $i = 0;
            foreach ($input['pname'] as $key => $value) {
            if(!empty($input['pname'][$i])){
                AttachConsult::create(
                    [
                        'consult_id'=>$record->id,
                        'pname' => $input['pname'][$i],
                        'chima' => $input['chima'][$i],
                        'zengding' => $input['zengding'][$i],
                        'tuihui' => $input['tuihui'][$i],
                        'price' => $input['price'][$i]
                    ]
                );
                $i++;
            }     
            }
        }

        return ['code'=>0,'message'=>'填写成功,我们已收到您的填写记录。关注四季校服公众号,进入个人中心可以查看及更新征询单或更换单。注意:征询单/更换单提交后无法删除，只能修改一次。'];

    }


    //根据商品名称获取规格
    public function getProductGuiGeByName(Request $request)
    {
        $input = $request->all();
        if(!array_key_exists('name',$input)){
            return ['code'=>1,'message'=>'参数不完整'];
        }
        $product = Product::where('name',$input['name'])->first();
        if(empty($product)){
            return ['code'=>1,'message'=>'该商品不存在'];
        }
        $specs = $product->specs;
        if(count($specs)){
            $need_arr = [];
            foreach ($specs as $key => $val) {
                $need_arr[] = $val->key_name;
            }
            return ['code'=>0,'message'=>$need_arr];
        }
        else{
            return ['code'=>1,'message'=>'该商品没有更多规格可选'];
        }
    }

    //更新征询单记录
    public function updateConsult($id,Request $request)
    {
        $input = $request->all();

        // $input = array_filter( $input, function($v, $k) {
        //     return $v != '' && $v != null;
        // }, ARRAY_FILTER_USE_BOTH );


        $record = ConsultRecord::find($id);

        if(empty($record)){
             return ['code'=>1,'message'=>'未知错误'];
        }

        $record->update(
            [
                'name' => $input['name'],
                'class'=>$input['class'],
                'shengao'=>$input['shengao'],
                'tizhong'=>$input['tizhong'],
                'remark'=>$input['remark'],
                'user_id'=>$input['user_id'],
                'sex'=>$input['sex'],
                'school_name'=>$input['school_name'],
                'user_edit' => 1
            ]
        );


        if(!array_key_exists('pname',$input) || !array_key_exists('chima',$input) || !array_key_exists('zengding',$input) || !array_key_exists('tuihui',$input)){
            return ['code'=>1,'message'=>'请选择校服'];
        }

        //先重置
        AttachConsult::where('consult_id',$id)->delete();

 
        if(count($input['pname']) && count($input['chima']) && count($input['zengding']) && count($input['tuihui'])){
            $i = 0;
            foreach ($input['pname'] as $key => $value) {
                if(!empty($input['pname'][$i])){
                    AttachConsult::create(
                        [
                            'consult_id'=>$record->id,
                            'pname' => $input['pname'][$i],
                            'chima' => $input['chima'][$i],
                            'zengding' => $input['zengding'][$i],
                            'tuihui' => $input['tuihui'][$i],
                            'price' => $input['price'][$i]
                        ]
                    );
                    $i++;
                }

            }
        }
         return ['code'=>0,'message'=>'修改成功'];
    }



    //根据学校名称获取到学校的班级
    public function getClassesBySchoolName(Request $request)
    {
        $input = $request->all();
        if(!array_key_exists('name',$input)){
            return ['code'=>1,'message'=>'参数不完整'];
        }
        $school = School::where('name',$input['name'])->first();
        if(empty($school)){
            return ['code'=>1,'message'=>'没有找到该学校'];
        }
        $classes = SchoolClass::where('school_id',$school->id)->get();
        return ['code'=>0,'message'=>$classes];
    }

    //新首页
    public function mainIndex(Request $request)
    {
        return view(frontView('main_index'));
    }

    public function clothProxy(Request $request)
    {
        return view(frontView('cloth_proxy'));
    }

    //新首页mobile版
    public function mainIndexMobile(Request $request)
    {
        $new_posts = app('commonRepo')->catRepo()->getCachePostOfCat('new_post');
        return view(frontView('main_index_mobile'),compact('new_posts'));
    }
}

