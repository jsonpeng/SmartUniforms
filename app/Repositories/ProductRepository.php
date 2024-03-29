<?php

namespace App\Repositories;

use App\Models\Product;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use Carbon\Carbon;
use App\Models\ProductPromp;
use App\Models\AttachConsult;

class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'price',
        'unit',
        'sales_price',
        'sales_start',
        'sales_end',
        'inventory',
        'warn_inventory',
        'max_buy',
        'intro',
        'remark',
        'delivery',
        'service_promise',
        'paras',
        'recommend',
        'recommend_title',
        'recommend_intro',
        'shelf',
        'freight',
        'category_id',
        'brand_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    //获取所有规格校服的统计
    public function getSchoolGuige()
    {
        $products = Product::where('type','校服')->with('specs')->get();
        $specs = collect([]);
        foreach ($products as $key => $val) {
           if(count($val['specs'])){
                foreach ($val['specs'] as $key => $spec) {
                    $spec['name'] = $val->name;
                    $num = getConsultNum($val->name,$spec->key_name);
                    $spec['zhengding'] =  $num['zengdings'];
                    $spec['tuihui'] = $num['tuihuis'];
                    if(!empty($spec['zhengding'] || !empty($spec['tuihui']) || $spec['zhengding'] == '0' || $spec['tuihui'] == '0')){
                         $specs[] = $spec;
                    }
                }
           }
        }
        //$consults = AttachConsult::where('do',0)->with('consult.user');
        // $consults =  $consults->filter(function($item){
        //     return $item['consult'] != null && $item['consult']['user'] != null;
        // });
        return ['specs'=>$specs];
    }


    //获取所有未处理的征订单的统计
    public function getAllConsults(){
        //return AttachConsult::where('do',0)->with('consult.user');
        $cousults = AttachConsult::where('do',0)->get();
        foreach ($cousults as $key => $val1) {
            $val1['consult'] = $val1->consult;
            if(!empty($val1['consult'])){
                $val1['consult']['user'] = $val1['consult']->user;
            }
        }
        return $cousults;
    }

    /**
     * 获取全部产品
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function products($skip = 0, $take = 1000,$type="商品",$school_name=null)
    {
      return Cache::remember('products_'.$skip.'_'.$take.$type.$school_name, Config::get('web.cachetime'), function() use($skip, $take,$type,$school_name){
        $products = Product::where('shelf', 1)
            ->where('type',$type);

            if(!empty($school_name)){
                $products = $products->where('school_name',$school_name);
            }

            $products = $products->orderBy('sort', 'asc')
            ->orderBy('is_hot', 'desc')
            ->orderBy('created_at', 'desc')
            ->skip($skip)->take($take)->get();
            

            foreach ($products as $key => $value) {
                if ($value->prom_type) {
                    $value['realPrice'] = $this->getSalesPrice($value);
                }
            }
            return $products;
      });
    }

    /**
     * 获取单个产品信息
     * @Author   yangyujiazi
     * @DateTime 2018-03-17
     * @param    [type]      $id [description]
     * @return   [type]          [description]
     */
    public function product($id)
    {
      return Cache::remember('product_'.$id, Config::get('web.cachetime'), function() use($id){
        return $this->findWithoutFail($id);
      });
    }

    /**
     * 获取特定促销的商品
     * @param  [type] $promp_id [促销类型]
     * @return [type]           [description]
     */
    public function productsOfPromp($promp_id, $skip = 0, $take = 20)
    {
        return Cache::remember('productsOfPromp'.$promp_id.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($promp_id, $skip, $take){
            $products = Product::where('prom_id', $promp_id)
            ->where('shelf', 1)
            ->orderBy('sort', 'desc')
            ->orderBy('is_hot', 'desc')
            ->orderBy('created_at', 'desc')
            ->skip($skip)->take($take)->get();

            foreach ($products as $key => $value) {
                if ($value->prom_type) {
                    $value['realPrice'] = $this->getSalesPrice($value);
                }
            }
            return $products;
        });
    }

    /**
     * 当前正在促销的商品
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function productsOfCurPromp($skip = 0, $take = 20)
    {
        //获取当前正在促销的活动
        $now = Carbon::now();
        $productPromps = ProductPromp::where('time_begin', '<=', $now)->where('time_end', '>=', $now)->get();
        $products = collect([]);
        foreach ($productPromps as $productPromp) {
            $results = $this->productsOfPromp($productPromp->id, 0, 10000);
            $products = $products->concat($results);
        }
        $slice = $products->slice($skip);
        $products = $slice->take($take);

        foreach ($products as $key => $value) {
            if ($value->prom_type) {
                $value['realPrice'] = $this->getSalesPrice($value);
            }
        }
        return $products;
    }

    /**
     * 获取推荐商品
     * @return [type] [description]
     */
    public function getRecommendProducts($skip = 0, $take = 20){
        return Cache::remember('newProducts_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($skip, $take){
            $products = Product::where('recommend', 1)
                ->where('shelf', 1)
                ->orderBy('sort', 'desc')
                ->orderBy('is_hot', 'desc')
                ->orderBy('created_at', 'desc')
                ->skip($skip)->take($take)->get();

            foreach ($products as $key => $value) {
                if ($value->prom_type) {
                    $value['realPrice'] = $this->getSalesPrice($value);
                }
            }
            return $products;
        });
    }

    /**
     * 新品
     * @param  integer $skip [跳过商品数目]
     * @param  integer $take [获取数目]
     * @return [type]        [description]
     */
    public function newProducts($skip = 0, $take = 20)
    {
        return Cache::remember('newProducts_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($skip, $take){
            $products = Product::where('is_new', 1)
                ->where('shelf', 1)
                ->orderBy('sort', 'desc')
                ->orderBy('is_hot', 'desc')
                ->orderBy('created_at', 'desc')
                ->skip($skip)->take($take)->get();

                foreach ($products as $key => $value) {
                    if ($value->prom_type) {
                        $value['realPrice'] = $this->getSalesPrice($value);
                    }
                }
                return $products;
        });
    }

    /**
     * 关联产品
     * @param  [type]  $id   [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function relatedProducts($id, $take = 10)
    {
        return Cache::remember('relatedProducts'.$id.'_'.$take, Config::get('web.cachetime'), function() use($id, $take){
            $products = Product::where('shelf', 1)->orderByRaw("RAND()")->take($take)->get();
            foreach ($products as $key => $value) {
                if ($value->prom_type) {
                    $value['realPrice'] = $this->getSalesPrice($value);
                }
            }
            return $products;
        });
    }

    /**
     * 获取分类ID下的产品
     * @param  [type] $cat_id [description]
     * @return [type]         [description]
     */
    public function getProductsCached($cat_id, $skip = 0, $take = 18){
        return Cache::remember('get_products_of_cat_'.$cat_id.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($cat_id, $skip, $take){
            return Product::where('category_id', $cat_id)
                ->where('shelf', 1)
                ->orderBy('sort', 'asc')
                ->orderBy('is_hot', 'desc')
                ->orderBy('created_at', 'desc')
                ->skip($skip)->take($take)->get();
        });
    }

    //获取某分类，及其子分类下的产品信息
    public function getProductsOfCatWithChildrenCatsCached($cat_id, $skip = 0, $take = 18){
        return Cache::remember('getProductsOfCatWithChildrenCatsCached'.$cat_id.'_skip'.$skip.'_take'.$take, Config::get('web.cachetime'), function() use($cat_id, $skip, $take){
            $cat = \App\Models\Category::where('id', $cat_id)->first();
            if (empty($cat)) {
                return [];
            } else {
                $parent_path = '';
                if ($cat->level == 1) {
                    $parent_path = '0_'.$cat->id;
                }else{
                    $parent_path = $cat->parent_path.'_'.$cat->id;
                }
                $childrenCats = \App\Models\Category::where('parent_path', 'like', $parent_path.'%')->get();
                //抽取CATID
                $catIds = [$cat->id];
                foreach ($childrenCats as $value) {
                    array_push($catIds, $value->id);
                }
                return Product::where('shelf', 1)
                    ->where('type','商品')
                    ->whereIn('category_id', $catIds)
                    ->orderBy('sort', 'asc')
                    ->orderBy('is_hot', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->skip($skip)->take($take)->get();
            }
        });
    }

    /*
     * 清空促销
     */
    public function resetPrompByPromId($id){
        return Product::where('prom_id',$id)->update(['prom_type'=>0,'prom_id'=>0]);
    }

    /*
     * 获取指定活动的带规格信息的商品
     */
    public function getPrompProductWithSpecsByPromId($id){
        return Product::where('prom_id',$id)->with('specs')->get();
    }


    /*
     * 更新商品的促销方式
     * 0无1抢购2团购3商品促销4订单促销5拼团
     */
    public function updateProductPrompType($product_id, $prom_id, $prom_type){
        return Product::where('id',$product_id)->update(['prom_id'=>$prom_id,'prom_type'=>$prom_type]);

    }

    //获取产品的当前售价(包含优惠售价)
    public function getSalesPrice($product, $includeTeamSale = true)
    {
        if (empty($product->prom_type) || empty($product->prom_id)) {
          return $product->price;
        }

        # 秒杀
        if ($product->prom_type == 1) {
            $promp = \App\Models\FlashSale::where('id', $product->prom_id)->first();
            if (!empty($promp) && $promp->status == '进行中') {
                return $promp->price;
            }else{
                return $product->price;
            }
        }

        //商品优惠进行中
        if ($product->prom_type == 3) {
          $promp = \App\Models\ProductPromp::where('id', $product->prom_id)->first();
          if (empty($promp) || $promp->status != '进行中') {
            return $product->price;
          } else {
            if ($promp->type == 0) {
                return round($product->price*$promp->value/100, 2);
            }
            if ($promp->type == 1) {
                return abs($product->price - $promp->value);
            }
            if ($promp->type == 2) {
                return $promp->value;
            }
            return $product->price;
          }
        }

        # 拼团
        if ($product->prom_type == 5 && $includeTeamSale) {
            $promp = \App\Models\TeamSale::where('id', $product->prom_id)->first();
            if (!empty($promp)) {
                return $promp->price;
            }else{
                return $product->price;
            }
        }else{
            return $product->price;
        }
    }

    //根据产品ID获取产品的优惠售价
    public function getSalesPriceById($id)
    {
        $product = $this->findWithoutFail($id);
        if (empty($product)) {
            return null;
        }
        return $this->getSalesPrice($product);
    }

    public function getPromp($product)
    {
        //优惠活动
        $promp = null;
        switch ($product->prom_type) {
            case 0:
                return null;
                break;
            case 1:
                # 秒杀
                $promp = \App\Models\FlashSale::where('id', $product->prom_id)->first();
                break;
            case 2:
                # 团购
                return null;
                break;
            case 3:
                # 商品促销
                $promp = \App\Models\ProductPromp::where('id', $product->prom_id)->first();
                break;
            case 5:
                # 拼团
                $promp = \App\Models\TeamSale::where('id', $product->prom_id)->first();
                break;
            default:
                return null;
                break;
        }
        return $promp;
    }

    //获取商品的收藏状态通过user和product_id
    public function getCollectionStatusApi($user,$product_id){
     $product = $this->findWithoutFail($product_id);
        if (!empty($product)) {
            $collection = $user->collections();
            $collections = $collection->get();
            if ($collection->count()) {
                $status = false;
                foreach ($collections as $item) {
                    if ($item->id == $product_id) {
                        $status = true;
                    }
                }
                return $status;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    /**
     * 删除商品时 删除关联的信息
     */
    public function deleteAttachInfoByProduct($product){
        // 删除关联的产品信息
        \App\Models\ProductImage::where('product_id', $product->id)->delete();
        //用户收藏
        $product->users()->sync([]);
        //规格
        \App\Models\SpecProductPrice::where('product_id',$product->id)->delete();
        //WORD
        $product->words()->sync([]);
        //促销信息
        #商品促销
        #秒杀
        \App\Models\FlashSale::where('product_id',$product->id)->delete();
        #拼团
        \App\Models\TeamSale::where('product_id',$product->id)->delete();

    }

}
