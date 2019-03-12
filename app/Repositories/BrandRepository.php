<?php

namespace App\Repositories;

use App\Models\Brand;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class BrandRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'intro',
        'sort',
        'image',
        'parent_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Brand::class;
    }

    public function allCached()
    {
        return Cache::remember('all_brands', Config::get('web.cachetime'), function(){
            return  Brand::orderBy('sort', 'asc')->get();
        });
    }

    public function getBrandArray(){
        $brandArray = array(null => '无品牌');
        $brands = Brand::select('id', 'name')->get()->toArray();
        while (list($key, $val) = each($brands)) {
            $brandArray[$val['id']] = $val['name'];
        }
        return $brandArray;
    }

    public function getProductsOfBrandCached($brand_id)
    {
        return Cache::remember('products_of_brand_'.$brand_id, Config::get('web.cachetime'), function() use($brand_id) {
            return \App\Models\Product::where('brand_id', $brand_id)->orderBy('sort', 'asc')->get();
        });
    }

    public function pagelist($page){
        if($page==0 || empty($page)){
            $page=1;
        }
        return Brand::paginate($page);
    }
}
