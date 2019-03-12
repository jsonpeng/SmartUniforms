<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Point;
use App\Models\Theme;
use App\Models\SpecProductPrice;
use App\Models\TeamFound;
use App\Models\TeamSale;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use DB;

use App\Repositories\ProductRepository;
use App\Repositories\SpecProductPriceRepository;
use App\Repositories\ProductAttrValueRepository;
use App\Repositories\TeamSaleRepository;

use Config;
use EasyWeChat\Factory;

class ProductController extends Controller
{

	private $productRepository;
    private $specProductPriceRepository;
    private $productAttrValueRepository;
    private $teamSaleRepository;

    public function __construct(
        ProductRepository $productRepo,
        SpecProductPriceRepository $specProductPriceRepo,
        TeamSaleRepository $teamSaleRepo,
        ProductAttrValueRepository $productAttrValueRepo)
    {
        $this->productRepository = $productRepo;
        $this->specProductPriceRepository = $specProductPriceRepo;
        $this->productAttrValueRepository = $productAttrValueRepo;
        $this->teamSaleRepository = $teamSaleRepo;
    }

    //产品详情
    public function index(Request $request, $id=0){

    	$product = $this->productRepository->product($id);
        //商品不存在
        if (empty($product) || $product->shelf == 0) {
            return redirect()->back();
        }
        //添加用户访问商品记录
        //
        //商品展示图片
        $productImages = $product->images;
        //商品规格信息
        $filter_spec = $this->specProductPriceRepository->get_spec($product->id);
        //计算优惠价格
        $spec_goods_price = $this->specProductPriceRepository->productSpecWithSalePrice($id);
        // $spec_goods_prices = SpecProductPrice::where('product_id', $id)->get();
        // foreach ($spec_goods_prices as $item) {
        //     $item['realPrice'] = $this->specProductPriceRepository->getSalesPrice($item);
        // }
        // $spec_goods_price = json_encode($spec_goods_prices);
        //属性信息
        $attrs = $this->productAttrValueRepository->getAllAttrOfProductCached($product->id);
        //推荐产品
        $relatedProducts = $this->productRepository->relatedProducts($product->id);
        //促销信息
        $promp = $this->productRepository->getPromp($product);
        //服务保障
        $words = $product->words;
        //如果是拼团活动，则显示已拼但是未拼满的团
        $teamFounders = collect([]);
        $join_team = 0;
        if ($request->has('join_team')) {
            $join_team = $request->input('join_team');
        }
        $start_or_Join = 0;
        if ($request->has('start_or_Join')) {
            $start_or_Join = $request->input('start_or_Join');
        }
        if ($product->prom_type == 5) {
            $teamFounders = $this->teamSaleRepository->teamFounders($product->id);
        }

        //最终售价，将优惠活动计算在内
        $product['realPrice'] = $this->productRepository->getSalesPrice($product);

        $app = null;
        if(Config::get('web.app_env') == 'product'){
            $app = Factory::officialAccount(Config::get('wechat.official_account.default'));
        }

        return view(frontView('product.index'))
                ->with('app', $app)
                ->with('product', $product)
                ->with('join_team', $join_team)
                ->with('start_or_Join', $start_or_Join)
                ->with('attrs', $attrs)
                ->with('promp', $promp)
                ->with('words', $words)
                ->with('filter_spec', $filter_spec)
                ->with('relatedProducts', $relatedProducts)
                ->with('spec_goods_price', $spec_goods_price)
                ->with('productImages', $productImages)
                ->with('teamFounders', $teamFounders);

    }

}
