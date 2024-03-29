<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\ProductAttrValueRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use phpDocumentor\Reflection\Types\Object_;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\Product;
use App\Models\Category;
use App\Models\Spec;
use App\Models\SpecItem;
use App\Models\Word;
use App\Models\SpecProductPrice;
use App\Models\ProductAttr;
use App\Models\ProductAttrValue;
use App\Models\School;
use DB;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;
    private $categoryRepository;
    private $brandRepository;
    private $productTypeRepository;
    private $productAttrValueRepository;

    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo,
        ProductTypeRepository $productTypeRepo,
        ProductAttrValueRepository $productAttrValueRepo)
    {
        $this->productRepository = $productRepo;
        $this->categoryRepository = $categoryRepo;
        $this->brandRepository = $brandRepo;
        $this->productTypeRepository = $productTypeRepo;
        $this->productAttrValueRepository = $productAttrValueRepo;
    }


    public function getSchoolExcel(Request $request)
    {
    
        $data = $this->productRepository->getSchoolGuige();
  
        return ($data);
    }

    //导出校服规格总体记录
    public function exportSchoolsAllSpecs(Request $request){
      
        $data = $this->productRepository->getSchoolGuige();
        $products = $data['specs'];
        $time = Carbon::now();
        //dd($consults);
        Excel::create($time.'校服规格总体汇总报告', function($excel) use($products) {
           

         
            // 第一列sheet
            $excel->sheet('汇总', function($sheet) use($products) {
                $sheet->setWidth(array(
                    'A'     =>  22,
                    'B'     =>  18,
                    'C'     =>  10,
                    'D'     =>  10,
                    'E'     =>  10,
                ));
            
                $sheet->appendRow(array('名称', '尺码', '价格', '征订', '退回'));
              
                $products->each(function ($item, $key) use (&$sheet) {
                        $sheet->appendRow(array(
                                $item->name,
                                $item->key_name,
                                $item->price,
                                $item->zhengding,
                                $item->tuihui
                        ));
                });
                  
            });

         

        })->download('xls');
    }

    //导出征订详情汇总报告
    public function exportAllConsults(Request $request)
    {
        ini_set('memory_limit', '512M');
        $consults = $this->productRepository->getAllConsults();
        ob_end_clean();
        $time = Carbon::now();
        $title = '征订详情汇总报告-截止到'.$time;

        ##处理多维数组
        foreach ($consults as $key => $item) {
            $item['weixin_nickname'] =    filter_str($item['consult']['user']->nickname);
            $item['xingming'] = $item['consult']->name;
            $item['xingbie']  = $item['consult']->sex;
            $item['banji']    = $item['consult']->class;
            $item['shengao']  = $item['consult']->shengao;
            $item['tizhong']  = $item['consult']->tizhong;
            $item['beizhu'] =   $item['consult']->remark;
        }

        return app('commonRepo')->exportExcelTable(
            [
             'weixin_nickname'=>'微信昵称', 
             'xingming' => '姓名', 
             'xingbie'=>'性别',
             'banji'=> '班级', 
             'shengao'=>'身高',
             'tizhong'=>'体重',
             'pname'=>'校服名称',
             'chima'=>'尺码',
             'price'=>'价格',
             'zengding'=>'征订',
             'tuihui'=>'退回',
             'created_at'=>'填写时间',
             'beizhu'=>'备注'
            ],
            $consults,
            $title);
        /*
        Excel::create($time.'征订详情汇总报告', function($excel) use($consults) {
            //第列sheet
            $excel->sheet('详情', function($sheet) use($consults) {
                $sheet->setWidth(array(
                    'A'     =>  22,
                    'B'     =>  12,
                    'C'     =>  10,
                    'D'     =>  12,
                    'E'     =>  10,
                    'F'     =>  10,
                    'G'     =>  20,
                    'H'     =>  20,
                    'I'     =>  10,
                    'J'     =>  10,
                    'K'     =>  10,
                    'L'     =>  22,
                    'M'     =>  100
                ));
                $sheet->appendRow(array('微信昵称', '姓名', '性别', '班级', '身高','体重','校服名称','尺码','价格','征订','退回','填写时间','备注'));

              // $consults = $consults->get();
               // $consults = $consults->chunk(100, function($consults) use(&$sheet) {
                    $consults->each(function ($item, $key) use (&$sheet) {
                        //foreach ($consults as $key => $item) {
                                        $sheet->appendRow(array(
                                                filter_str($item['consult']['user']->nickname),
                                                $item['consult']->name,
                                                $item['consult']->sex,
                                                $item['consult']->class,
                                                $item['consult']->shengao,
                                                $item['consult']->tizhong,
                                                $item->pname,
                                                $item->chima,
                                                $item->price,
                                                $item->zengding,
                                                $item->tuihui,
                                                $item->created_at,
                                                $item['consult']->remark
                                        ));
                         //}
                  // });
                });
            });

        })->export('xls');*/
    }




    //校服列表
    public function schoolClothesIndex(Request $request)
    { 
        //清除空字符串
        $inventory_warn=empty(getSettingValueByKey('inventory_warn')) ? 0 : getSettingValueByKey('inventory_warn');

        $cats =  $this->categoryRepository->getCascadeCategories();
        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        
        $products = [];
        $tools=$this->varifyTools($input);

        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=0;
        $level02=0;
        $level03=0;
        $first_cats= $this->categoryRepository->getRootCatArray();
        $created_desc_status=true;
        if (array_key_exists('type', $input)) {
            //查询特定分类
            $category = $this->categoryRepository->findWithoutFail($input['type']);
            if (empty($category)) {
                return view('admin.products.index')
                    ->with('products', [])->with('cats', $cats)->withInput(Input::all());
            }else{
                $products = Product::orderBy('created_at', 'desc')->where('category_id',$input['type'])->where('type','校服');

            }
        }else{
            $products = Product::where('id','>','0')->where('type','校服');
        }
        if(array_key_exists('cat_level01',$input) || array_key_exists('cat_level02',$input) || array_key_exists('cat_level03',$input)){
            $input['category_id']=0;
   
            if ($input['cat_level01']!=0) {
                $input['category_id'] = $input['cat_level01'];
                $second_cats=$this->categoryRepository->getRootCatArray($input['category_id']);
            }

            if ($input['cat_level02']!=0) {
                $input['category_id'] = $input['cat_level02'];

                $third_cats=$this->categoryRepository->getRootCatArray($input['category_id']);
                $level02= $input['category_id'];
            }

            if ($input['cat_level03']!=0) {
                $input['category_id'] = $input['cat_level03'];
                $level03= $input['category_id'];
            }

            if($input['category_id']!=0) {

                $products = $products->whereIn('category_id', $this->categoryRepository->getCatArrById($input['category_id']));
            }
        }

        if(array_key_exists('product_id_sort',$input)){
            $products = $products->orderBy('id', $input['product_id_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }
        if (array_key_exists('schools_name', $input)) {
            $products = $products->where('school_name',$input['schools_name']);
        }
        if (array_key_exists('product_name', $input)) {
            $products = $products->where('name', 'like', '%'.$input['product_name'].'%');
        }
        if(array_key_exists('price_start',$input)){
            $products = $products->where('price', '>=', $input['price_start']);
        }
        if(array_key_exists('price_end',$input)){
            $products = $products->where('price', '<=', $input['price_start']);
        }
        if (array_key_exists('price_sort', $input)) {
            $products = $products->orderBy('price', $input['price_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        if (array_key_exists('recommend', $input)) {
           $products = $products->where('recommend', $input['recommend']);
        }
        if (array_key_exists('shelf', $input)) {
            $products = $products->where('shelf', $input['shelf']);
        }
        if (array_key_exists('inventory', $input)) {
            $products = $products->orderBy('inventory', $input['inventory']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        if($created_desc_status){
            $products=$products->orderBy('created_at', 'desc');
        }

        $products = $products->with('specs')->paginate($this->defaultPage());

        $schools = School::all();

        return view('admin.school_product.index')
            ->with('tools',$tools)
            ->with('inventory_warn',$inventory_warn)
            ->with('products', $products)
            ->with('cats', $cats)
            ->with('first_cats',$first_cats)
            ->with('second_cats', $second_cats)
            ->with('third_cats',$third_cats)
            ->with('level01',$level01)
            ->with('level02',$level02)
            ->with('level03',$level03)
            ->with('schools',$schools)
            ->withInput(Input::all());
    }

    //添加校服
    public function schoolClothesCreate(Request $request)
    {
        $categories = $this->categoryRepository->getRootCatArray();
        $brands = $this->brandRepository->getBrandArray();
        //默认库存
        $defaultInventory = getSettingValueByKey('inventory_default');
        $wordList=Word::all();
        $schools = School::all();
        $selectedWords=[];
        return view('admin.school_product.create')
                ->with('categories', $categories)
                ->with('brands', $brands)
                ->with('defaultInventory', $defaultInventory)
                ->with('wordlist',$wordList)
                ->with('selectedWords',$selectedWords)
                ->with('schools',$schools);
    }


    //添加操作
    public function sstore(CreateProductRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }
        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }
        $inputs=$input;
        $input=array_remove($input,'words');

        $product = $this->productRepository->create($input);

        if(array_key_exists('words',$inputs)){
            //return $inputs['words'];
            if(!empty($inputs['words'])){
                $product->words()->sync($inputs['words']);
            }

        }
        $request->session()->flash('product_edit_rember',$product->id);

        return redirect(route('products.sedit', [$product->id]));
        
    }

    //编辑校服
     public function schoolClothesEdit(Request $request,$id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }
        $first_cats=[0 => '请选择分类'];
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $categories = $this->categoryRepository->getRootCatArray();
        $brands = $this->brandRepository->getBrandArray();
        $images = $product->images;
        $types = $this->productTypeRepository->all();
        $edit_rember=false;
        $spec_show=false;
        $wordlist=Word::all();
        $selectedWords=[];
        $product_words= $product->words()->get();
        if(!empty($product_words)){
           foreach ($product_words as $item){
               array_push($selectedWords,$item->id);
           }
        }
     //  return $wordlist;
       //return $selectedWords;

        //要处理商品分类无无分类的情况，就是category_id为0
        if ($request->session()->has('product_edit_rember')) {
            $edit_rember=true;
        }
        if($request->has('spec')){
            $spec_show=true;
        }
        $parent_cat = Category::where('parent_id', $product->category_id)->first();
        if (empty($parent_cat)) {
            $level01 = $product->category_id;
        }

        if($product->category_id!=0) {
            $level = $this->categoryRepository->getCategoryLevelByCategoryId($product->category_id);
            //return $level;
            if (!empty($level)) {
                $level = explode('_', $level);
            }

            //return $level[0];
            if (count($level) == 3) {
                $third_cats = [0 => '请选择分类', $level[2] => varifiedCatName($this->categoryRepository->findWithoutFail($level[2]))];
                $second_cats = [0 => '请选择分类', $level[1] => varifiedCatName($this->categoryRepository->findWithoutFail($level[1]))];
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level03 = $level[2];
                $level02 = $level[1];
                $level01 = $level[0];
            } else if (count($level) == 2) {
                $second_cats = [0 => '请选择分类', $level[1] => varifiedCatName($this->categoryRepository->findWithoutFail($level[1]))];
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level02 = $level[1];
                $level01 = $level[0];
            } else {
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level01 = $level[0];
            }
        }
        $schools = School::all();
        return view('admin.school_product.edit', compact('wordlist','selectedWords','spec_show','edit_rember','images', 'product', 'categories', 'brands', 'types','level','level01', 'level02','level03','fist_cats','second_cats','third_cats','schools'));
    }

    //编辑操作
    public function supdate($id, Request $request)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');
            return redirect(route('products.index'));
        }
        $input = $request->all();

        //$input['price'] = $product->price;
        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }
        if (!array_key_exists('recommend', $input)) {
            $input['recommend'] = 0;
        }


        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }
        $inputs=$input;
        $input=array_remove($input,'words');

        $product = $this->productRepository->update($input, $id);

        if(array_key_exists('words',$inputs)){
            //return $inputs['words'];
            if(!empty($inputs['words'])){
                $product->words()->sync($inputs['words']);
            }

        }

        Flash::success('产品信息更新成功');

        return redirect(route('products.sindex'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function sdestroy($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }

        $this->productRepository->deleteAttachInfoByProduct($product);
        $this->productRepository->delete($id);

        Flash::success('产品删除成功');

        return redirect(route('products.sindex'));
    }

    //删除操作


    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //清除空字符串
        $inventory_warn=empty(getSettingValueByKey('inventory_warn')) ? 0 : getSettingValueByKey('inventory_warn');

        $cats =  $this->categoryRepository->getCascadeCategories();
        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        
        $products = [];
        $tools=$this->varifyTools($input);

        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=0;
        $level02=0;
        $level03=0;
        $first_cats= $this->categoryRepository->getRootCatArray();
        $created_desc_status=true;
        if (array_key_exists('type', $input)) {
            //查询特定分类
            $category = $this->categoryRepository->findWithoutFail($input['type']);
            if (empty($category)) {
                return view('admin.products.index')
                    ->with('products', [])->with('cats', $cats)->withInput(Input::all());
            }else{
                $products = Product::orderBy('created_at', 'desc')->where('category_id',$input['type'])->where('type','商品');

            }
        }else{
            $products = Product::where('id','>','0')->where('type','商品');
        }
        if(array_key_exists('cat_level01',$input) || array_key_exists('cat_level02',$input) || array_key_exists('cat_level03',$input)){
            $input['category_id']=0;
   
            if ($input['cat_level01']!=0) {
                $input['category_id'] = $input['cat_level01'];
                $second_cats=$this->categoryRepository->getRootCatArray($input['category_id']);
            }

            if ($input['cat_level02']!=0) {
                $input['category_id'] = $input['cat_level02'];

                $third_cats=$this->categoryRepository->getRootCatArray($input['category_id']);
                $level02= $input['category_id'];
            }

            if ($input['cat_level03']!=0) {
                $input['category_id'] = $input['cat_level03'];
                $level03= $input['category_id'];
            }

            if($input['category_id']!=0) {

                $products = $products->whereIn('category_id', $this->categoryRepository->getCatArrById($input['category_id']));
            }
        }

        if(array_key_exists('product_id_sort',$input)){
            $products = $products->orderBy('id', $input['product_id_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }
        if (array_key_exists('product_name', $input)) {
            $products = $products->where('name', 'like', '%'.$input['product_name'].'%');
        }
        if(array_key_exists('price_start',$input)){
            $products = $products->where('price', '>=', $input['price_start']);
        }
        if(array_key_exists('price_end',$input)){
            $products = $products->where('price', '<=', $input['price_start']);
        }
        if (array_key_exists('price_sort', $input)) {
            $products = $products->orderBy('price', $input['price_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        if (array_key_exists('recommend', $input)) {
           $products = $products->where('recommend', $input['recommend']);
        }
        if (array_key_exists('shelf', $input)) {
            $products = $products->where('shelf', $input['shelf']);
        }
        if (array_key_exists('inventory', $input)) {
            $products = $products->orderBy('inventory', $input['inventory']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        if($created_desc_status){
            $products=$products->orderBy('created_at', 'desc');
        }
        $products = $products->with('specs')->paginate($this->defaultPage());

        return view('admin.products.index')
            ->with('tools',$tools)
            ->with('inventory_warn',$inventory_warn)
            ->with('products', $products)
            ->with('cats', $cats)
            ->with('first_cats',$first_cats)
            ->with('second_cats', $second_cats)
            ->with('third_cats',$third_cats)
            ->with('level01',$level01)
            ->with('level02',$level02)
            ->with('level03',$level03)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getRootCatArray();
        $brands = $this->brandRepository->getBrandArray();
        //默认库存
        $defaultInventory = getSettingValueByKey('inventory_default');
        $wordList=Word::all();
        $selectedWords=[];
        return view('admin.products.create')
                ->with('categories', $categories)
                ->with('brands', $brands)
                ->with('defaultInventory', $defaultInventory)
                ->with('wordlist',$wordList)
                ->with('selectedWords',$selectedWords);
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }
        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }
        $inputs=$input;
        $input=array_remove($input,'words');

        $product = $this->productRepository->create($input);

        if(array_key_exists('words',$inputs)){
            //return $inputs['words'];
            if(!empty($inputs['words'])){
                $product->words()->sync($inputs['words']);
            }

        }
        $request->session()->flash('product_edit_rember',$product->id);

        return redirect(route('products.edit', [$product->id]));
        
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }

        $images = $product->images()->get();
        $paras = $product->paras()->get();

        return view('admin.products.show')
            ->with('product', $product)
            ->with('images', $images)
            ->with('paras', $paras);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }
        $first_cats=[0 => '请选择分类'];
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $categories = $this->categoryRepository->getRootCatArray();
        $brands = $this->brandRepository->getBrandArray();
        $images = $product->images;
        $types = $this->productTypeRepository->all();
        $edit_rember=false;
        $spec_show=false;
        $wordlist=Word::all();
        $selectedWords=[];
        $product_words= $product->words()->get();
        if(!empty($product_words)){
           foreach ($product_words as $item){
               array_push($selectedWords,$item->id);
           }
       }
     //  return $wordlist;
       //return $selectedWords;

        //要处理商品分类无无分类的情况，就是category_id为0
        if ($request->session()->has('product_edit_rember')) {
            $edit_rember=true;
        }
        if($request->has('spec')){
            $spec_show=true;
        }
        $parent_cat = Category::where('parent_id', $product->category_id)->first();
        if (empty($parent_cat)) {
            $level01 = $product->category_id;
        }

        if($product->category_id!=0) {
            $level = $this->categoryRepository->getCategoryLevelByCategoryId($product->category_id);
            //return $level;
            if (!empty($level)) {
                $level = explode('_', $level);
            }

            //return $level[0];
            if (count($level) == 3) {
                $third_cats = [0 => '请选择分类', $level[2] => varifiedCatName($this->categoryRepository->findWithoutFail($level[2]))];
                $second_cats = [0 => '请选择分类', $level[1] => varifiedCatName($this->categoryRepository->findWithoutFail($level[1]))];
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level03 = $level[2];
                $level02 = $level[1];
                $level01 = $level[0];
            } else if (count($level) == 2) {
                $second_cats = [0 => '请选择分类', $level[1] => varifiedCatName($this->categoryRepository->findWithoutFail($level[1]))];
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level02 = $level[1];
                $level01 = $level[0];
            } else {
                $first_cats = [$level[0] => varifiedCatName($this->categoryRepository->findWithoutFail($level[0]))];
                $level01 = $level[0];
            }
        }


        return view('admin.products.edit', compact('wordlist','selectedWords','spec_show','edit_rember','images', 'product', 'categories', 'brands', 'types','level','level01', 'level02','level03','fist_cats','second_cats','third_cats'));
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');
            return redirect(route('products.index'));
        }
        $input = $request->all();

        //$input['price'] = $product->price;
        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }
        if (!array_key_exists('recommend', $input)) {
            $input['recommend'] = 0;
        }


        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }
        $inputs=$input;
        $input=array_remove($input,'words');

        $product = $this->productRepository->update($input, $id);

        if(array_key_exists('words',$inputs)){
            //return $inputs['words'];
            if(!empty($inputs['words'])){
                $product->words()->sync($inputs['words']);
            }

        }

        Flash::success('产品信息更新成功');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }

        $this->productRepository->deleteAttachInfoByProduct($product);
        $this->productRepository->delete($id);

        Flash::success('产品删除成功');

        return redirect(route('products.index'));
    }

    public function wordsList(){
        $wordList=Word::all();
        //return $wordList;
        return view('admin.products.wordlist')
                ->with('wordList',$wordList);
    }

    public function wordsListAdd(){
        return view('admin.products.wordlist_add');
    }

    public function wordsListStore(Request $request){
        $input=$request->all();
        $productWord=Word::create($input);
        Flash::success('字段添加成功');
        return redirect(route('wordlist.index'));
    }

    public function wordsListUpdate(Request $request,$id){
        $input=$request->all();
        $word=Word::find($id);
        if(!empty($word)){
            $word->update(['name'=>$input['name']]);
            return ['code'=>0,'message'=>$input['name']];
        }else {
            return ['code'=>1,'message'=>'未知错误'];
        }
    }

    public function wordsListDestroy($id){
        //删除与产品的关联信息
        
        $productWord=Word::find($id);

        if(!empty($productWord)){

            $productWord->product()->sync([]);
            $productWord->delete();
        }

        Flash::success('字段删除成功');
        return redirect(route('wordlist.index'));
    }

    public function ajaxGetSpecSelect(Request $request)
    {
        $input = $request->all();
        $input['product_id'] = $input['product_id'];        
        $specList = Spec::where('type_id', $input['spec_type'])->orderBy('sort', 'desc')->get();
        /*
        $specList = M('Spec')->where("type_id = ".I('get.spec_type/d'))->order('`order` desc')->select();
        foreach($specList as $k => $v)        
            $specList[$k]['spec_item'] = M('SpecItem')->where("spec_id = ".$v['id'])->order('id')->getField('id,item'); // 获取规格项                
        */
        foreach ($specList as $item) {
            $item['spec_item'] = $item->items()->get();
        }

        $spec_keys = SpecProductPrice::where('product_id', $input['product_id'])->select("key")->get();
        $items_id = '';
        $index = 1;
        foreach ($spec_keys as $key => $value) {
            if ($index++ != 1) {
                $items_id .= '_';
            }
            $items_id .= $value->key;
        }
       
        //$items_id = M('SpecGoodsPrice')->where('goods_id = '.$product_id)->getField("GROUP_CONCAT(`key` SEPARATOR '_') AS items_id");
        $items_ids = explode('_', $items_id);
        
        // 获取商品规格图片   
        /*             
        if($product_id)
        {
           $specImageList = M('SpecImage')->where("goods_id = $product_id")->getField('spec_image_id,src');                 
        }        
        $this->assign('specImageList',$specImageList);
        
        $this->assign('items_ids',$items_ids);
        $this->assign('specList',$specList);*/
        return view('admin.products.ajax_spec', compact('items_ids', 'specList')); 
    }

    public function ajaxGetAttrInput(Request $request)
    {
        //header("Content-type: text/html; charset=utf-8");
        $input = $request->all();
        $attributeList = ProductAttr::where('type_id', $input['type_id'])->get();                                
        $str = '';

        foreach($attributeList as $key => $val)
        {                                                                        
            $curAttrVal_tmp = $this->productAttrValueRepository->getProductAttrVal(0, $input['product_id'], $val->id);
             //促使他 循环
            if(empty($curAttrVal_tmp)){
                $curAttrVal[] = array('id' =>'','product_id' => '','attr_id' => '','attr_value' => '','attr_price' => '');
            }else{
                $curAttrVal[] = array('id' =>$curAttrVal_tmp->id,'product_id' => $curAttrVal_tmp->product_id,'attr_id' => $curAttrVal_tmp->attr_id,'attr_value' => $curAttrVal_tmp->attr_value);
            }
            
            foreach($curAttrVal as $k =>$v)
            {   
                $str .= sprintf("<tr class=attr_%d>", $val->id);
                $addDelAttr = ''; // 加减符号
                // 单选属性 或者 复选属性
                if($val->attr_type == 1 || $val->attr_type == 2)
                {
                    if($k == 0)                                
                        $addDelAttr .= "<a onclick='addAttr(this)' href='javascript:void(0);'>[+]</a>&nbsp&nbsp";                                                                    
                    else                                
                         $addDelAttr .= "<a onclick='delAttr(this)' href='javascript:void(0);'>[-]</a>&nbsp&nbsp";                               
                }

                $str .= sprintf("<td>%s %s</td> <td>", $addDelAttr, $val->name);
                        
                // 手工录入
                if($val->input_type == 0)
                {
                    $str .= "<input type='text' class='form-control' size='40' value='".$v['attr_value']."' name='attr_".$val->id."[]' />";
                }
                // 从下面的列表中选择（一行代表一个可选值）
                if($val->input_type == 1)
                {
                    $str .= "<select class='form-control' name='attr_".$val->id."[]'><option value='0'>无</option>";
                    $tmp_option_val = explode(' ', $val->values);
                    foreach($tmp_option_val as $k2=>$v2)
                    {
                        // 编辑的时候 有选中值
                        $v2 = preg_replace("/\s/","",$v2);
                        if($v['attr_value']== $v2)
                            $str .= sprintf("<option selected='selected' value='%s'>%s</option>", $v2, $v2) ;
                        else
                            $str .= sprintf("<option value='%s'>%s</option>", $v2, $v2);
                    }
                    $str .= "</select>";                
                }
                // 多行文本框
                if($val->input_type == 2)
                {
                    $str .= "<textarea class='form-control' cols='40' rows='3' name='attr_".$val->id."[]'>".($input['product_id'] ? $v['attr_value'] : $val->values)."</textarea>";
                }                                                        
                $str .= "</td></tr>";       
            } 
            array_pop($curAttrVal);                 
            
        }        
        return  $str;
    }
    public function ajaxDelSpecInputByKey(Request $request){
        $input=$request->all();
        $key_name=$input['key'];
        $spec=SpecProductPrice::where('key',$key_name);
        if($spec->count()>0){
            $spec->delete();
            return ['code'=>0,'message'=>'删除成功'];
        }else{
            return ['code'=>1,'message'=>'该规格信息不存在'];
        }

    }

    public function ajaxGetSpecInput(Request $request, $product_id)
    {
        $input = $request->all();
        $spec_arr = null;
        if (array_key_exists('spec_arr', $input) && $input['spec_arr'] != '') {
            $spec_arr = $input['spec_arr'];
        }else{
            return 
            "<table class='table table-bordered' id='spec_input_tab'><tr><td><b>价格</b></td>
               <td><b>库存</b></td>
               <td><b>SKU</b></td>
               <td><b>图片</b></td>
             </tr></table>";
        }

        foreach ($spec_arr as $k => $v)
        {
            $spec_arr_sort[$k] = count($v);
        }
        asort($spec_arr_sort);        
        foreach ($spec_arr_sort as $key =>$val)
        {
            $spec_arr2[$key] = $spec_arr[$key];
        }
        
        $clo_name = array_keys($spec_arr2);         
        $spec_arr2 = combineDika($spec_arr2); //  获取 规格的 笛卡尔积                 
        /*   
        $spec = M('Spec')->getField('id,name'); // 规格表
        $specItem = M('SpecItem')->getField('id,item,spec_id');//规格项
        $keySpecGoodsPrice = M('SpecGoodsPrice')->where('goods_id = '.$product_id)->getField('key,key_name,price,store_count,bar_code,sku');//规格项
        */
        //var_dump($spec_arr2);
        $spec_tmp = Spec::select('id', 'name')->get();
        $spec = array();
        foreach ($spec_tmp as $key => $value) {
            $spec[$value['id']] = $value['name'];
        }
        $specItem_tmp = SpecItem::select('id','name','spec_id')->get();
        $specItem = array();
        foreach ($specItem_tmp as $key => $value) {
            $specItem[$value->id] = ['item' => $value->name, 'spec_id' => $value->spec_id];
        }

        $keySpecGoodsPrice_tmp = SpecProductPrice::where('product_id', $product_id)->get();
        $keySpecGoodsPrice = array();
        foreach ($keySpecGoodsPrice_tmp as $key => $value) {
            $keySpecGoodsPrice[$value->key] = ['key_name' => $value->key_name, 'inventory' => $value->inventory,'price' => $value->price,'sku' => $value->sku,'image'=>$value->image];
        }
        
        $str = "<table class='table table-bordered form-group' id='spec_input_tab'>";
        $str .="<tr>";       
        // 显示第一行的数据

        foreach ($clo_name as $k => $v) 
        {
           $str .= sprintf(" <td><b>%s</b></td>", $spec[$v]) ;
        }    
        $str .="<td><b>价格</b></td>
               <td><b>库存</b></td>
               <td><b>SKU</b></td>
               <td><b>图片</b></td>
               <td><b>操作</b></td>
             </tr>";
        $i=0;
        // 显示第二行开始 
        foreach ($spec_arr2 as $k => $v) 
        {
            $str .="<tr>";
            $item_key_name = array();
            foreach($v as $k2 => $v2)
            {
                $str .= sprintf("<td>%s</td>", $specItem[$v2]['item']);
                $item_key_name[$v2] = $spec[$specItem[$v2]['spec_id']].':'.$specItem[$v2]['item'];
            }   
            ksort($item_key_name);            
            $item_key = implode('_', array_keys($item_key_name));
            $item_name = implode(' ', $item_key_name);
           // $i++;

            //return $item_key;
            //$keySpecGoodsPrice[$item_key]['price'] ? false : $keySpecGoodsPrice[$item_key]['price'] = 0; // 价格默认为0
            //$keySpecGoodsPrice[$item_key]['inventory'] ? false : $keySpecGoodsPrice[$item_key]['inventory'] = 0; //库存默认为0
            $price = 0;
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('price', $keySpecGoodsPrice[$item_key])) {
                $price = $keySpecGoodsPrice[$item_key]['price'];
            }
            $inventory = 0;
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('inventory', $keySpecGoodsPrice[$item_key])) {
                $inventory = $keySpecGoodsPrice[$item_key]['inventory'];
            }
            $sku = '';
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('sku', $keySpecGoodsPrice[$item_key])) {
                $sku = $keySpecGoodsPrice[$item_key]['sku'];
            }
            $image='';
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('image', $keySpecGoodsPrice[$item_key])) {
                $image = $keySpecGoodsPrice[$item_key]['image'];
            }
             //dd(1);
            //$spec_obj=SpecProductPrice::where('key',$item_key);
            //if($spec_obj->count()){
            $str .= sprintf("<td width=100><input name=item[%s][price] class='form-control' value='%s' onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>", $item_key, $price);
            $str .= sprintf("<td width=100><input name=item[%s][inventory] class='form-control' value='%s' onkeyup='this.value=this.value.replace(/[^\d-.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d-.]/g,\"\")'/></td>", $item_key, $inventory);            
            $str .= sprintf("<td width=150><input name=item[%s][sku] class='form-control' value='%s' />
                <input type='hidden' name=item[%s][key_name] value='%s' /></td>", $item_key, $sku, $item_key, $item_name);
            $image_set=empty($image)?'设置':'';
            $str.="<td style='padding: 0;'><a onclick='specimage(this)' data-toggle=modal href=javascript:; data-target=#myModal3 class=btn btn-primary type=button><span>".$image_set."</span><img src='".$image."' alt='' style='width:25px; height: 25px;'></a><input type='hidden' name=item[".$item_key."][image] id='spec_image".$item_key."' value='".$image."' /></td><td style='cursor: pointer;' onclick='del_ajax_model(this)' data-key='".$item_key."'>删除</td>";
            $str .="</tr>";  
        //}
                 
        }
        $str .= "</table>";
        return $str;
    }

    public function ajaxSaveTypeAttr(Request $request, $id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            return ['code' => 1, 'message' => '产品不存在'];
        }

        $input = $request->all();
        //过滤异常
        if($input['goods_type']==0){
            SpecProductPrice::where('product_id', $id)->delete();
            $product->update(['type_id' => $input['goods_type']]);
            return ['code' => 0, 'message' => '更新成功'];
        }
        //删除原有规格信息
        SpecProductPrice::where('product_id', $id)->delete();

        //更新模型
        if ($product->type_id != $input['goods_type']) {
            $product->update(['type_id' => $input['goods_type']]);
        }
        if(array_key_exists('item',$input)) {
            //插入信息的规格信息
            foreach ($input['item'] as $key => $item) {
                if ($item['price'] != 0) {
                    SpecProductPrice::create([
                        'key' => $key,
                        'key_name' => $item['key_name'],
                        'price' => $item['price'],
                        'inventory' => $item['inventory'],
                        'sku' => $item['sku'],
                        'product_id' => $id,
                        'image' => $item['image']
                    ]);
                } else {
                    return ['code' => 1, 'message' => '请输入价格'];
                }

            }
        }

        //更新属性信息
        $this->saveGoodsAttr($id, $input['goods_type'], $input);
        
        return ['code' => 0, 'message' => '保存成功'];
    }

    /**
     *  给指定商品添加属性 或修改属性 更新到 tp_goods_attr
     * @param int $product_id  商品id
     * @param int $product_type  商品类型id
     */
    public function saveGoodsAttr($product_id,$product_type, $inputs)
    {  
        //$GoodsAttr = M('GoodsAttr');
        //$Goods = M("Goods");
                
         // 属性类型被更改了 就先删除以前的属性类型 或者没有属性 则删除        
        if($product_type == 0)  
        {
            ProductAttrValue::where('product_id', $product_id)->delete(); 
            return;
        }
        
        $GoodsAttrList = ProductAttrValue::where('product_id' ,$product_id)->get();
        
        $old_goods_attr = array(); // 数据库中的的属性  以 attr_id _ 和值的 组合为键名
        foreach($GoodsAttrList as $k => $v)
        {                
            $old_goods_attr[$v['attr_id'].'_'.$v['product_id']] = $v;
        }            
                          
        // post 提交的属性  以 attr_id _ 和值的 组合为键名    
        $post_goods_attr = array();
        foreach($inputs as $k => $v)
        {
            $attr_id = str_replace('attr_','',$k);
            if(!strstr($k, 'attr_') || strstr($k, 'attr_price_'))
               continue;                                 
            foreach ($v as $k2 => $v2)
            {                      
               $v2 = str_replace('_', '', $v2); // 替换特殊字符
               $v2 = str_replace('@', '', $v2); // 替换特殊字符
               $v2 = trim($v2);
               
               if(empty($v2))
                   continue;
               
               
               $tmp_key = $attr_id."_".$product_id;
               //$post_attr_price = I("post.attr_price_{$attr_id}");
               //$attr_price = $post_attr_price[$k2]; 
               //$attr_price = $attr_price ? $attr_price : 0;
               if(array_key_exists($tmp_key , $old_goods_attr)) // 如果这个属性 原来就存在
               {   
                    /*
                   if($old_goods_attr[$tmp_key]['attr_price'] != $attr_price) // 并且价格不一样 就做更新处理
                   {                       
                        $goods_attr_id = $old_goods_attr[$tmp_key]['goods_attr_id'];                         
                        ProductAttrValue::where("id", $goods_attr_id)->update('attr_price'=>$attr_price);                       
                   }    
                   */
                   ProductAttrValue::where("attr_id", $attr_id)->where('product_id', $product_id)->update(['attr_value'=>$v2]);
               }
               else // 否则这个属性 数据库中不存在 说明要做删除操作
               {
                   ProductAttrValue::create(array('product_id'=>$product_id,'attr_id'=>$attr_id,'attr_value'=>$v2));                       
               }
               unset($old_goods_attr[$tmp_key]);
           }
            
        }     
        // 没有被 unset($old_goods_attr[$tmp_key]); 掉是 说明 数据库中存在 表单中没有提交过来则要删除操作
        foreach($old_goods_attr as $k => $v)
        {                
           ProductAttrValue::where('id', $v['id'])->delete(); // 
        }                       

    }
    //通过商品id获取商品信息
    public function getSingleProductById($id){
        $product=$this->productRepository->findWithoutFail($id);
        return ['code'=>0,'message'=>$product];
    }

    //获取所有规格信息的商品
    public function ajaxGetProductList(Request $request){
        $product=SpecProductPrice::all();
        return ['code'=>0,'message'=>$product];
    }

    public function allLowGoods(Request $request){
        //inventory
        $inventory_warn=empty(getSettingValueByKey('inventory_warn')) ? 0 : getSettingValueByKey('inventory_warn');
        $inputs=$request->all();

        $product=Product::where('id','>',0)->where('inventory','<=',$inventory_warn)->where('inventory','<>',-1)->orderBy('created_at', 'desc');
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $cats= $this->categoryRepository->getRootCatArray();
        $type='';
        $tools=$this->varifyTools($inputs);
        //$type=1 单选
        if(array_key_exists('type',$inputs)){
            $type='_'.$inputs['type'];
        }
        if(array_key_exists('prom_id',$inputs)) {
            $product=$product->where('prom_type','3')->where('prom_id',$inputs['prom_id']);
        }
        if(array_key_exists('cat_level01',$inputs) || array_key_exists('cat_level02',$inputs) || array_key_exists('cat_level03',$inputs)){
            $inputs['category_id'] = 0;
            if ($inputs['cat_level03']!=0) {
                $inputs['category_id'] = $inputs['cat_level03'];
                $third_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level03= $inputs['category_id'];
            }
            if ($inputs['cat_level02']!=0) {
                $inputs['category_id'] = $inputs['cat_level02'];
                $second_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level02= $inputs['category_id'];
            }
            if ($inputs['cat_level01']!=0) {
                $inputs['category_id'] = $inputs['cat_level01'];
            }
            if($inputs['category_id']!=0) {
                $category_id_arr= $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($inputs['category_id']);
                // return $category_id_arr;
                $products= $product->whereIn('category_id', $category_id_arr);
            }
        }

        if(array_key_exists('keywords',$inputs)){
            $product=$product->where('name','like', '%' . $inputs['keywords'] . '%');
        }
        $product_list_get=$product->with('specs')->get();
        $products=$product->with('specs')->paginate($this->defaultPage());
        $i=0;
        foreach ($product_list_get as $item){
            $items=$item->specs;
            if(count($items)){
                // $i++;
                foreach ($items as $item2) {
                    $i++;
                }
            }else{
                $i++;
            }
        }
        $product_num=$i;

        return view('admin.products.all_low'.$type)
            ->with('tools',$tools)
            ->with('cats',$cats)
            ->with('second_cats', $second_cats)
            ->with('third_cats',$third_cats)
            ->with('product',$products)
            ->with('products',$products)
            ->with('product_num',$product_num)
            ->with('level01',$level01)
            ->with('level02',$level02)
            ->with('level03',$level03)
            ->withInput(Input::all());
    }


    public function searchSchoolsFrame(Request $request)
    {
        $inputs=$request->all();

        $product=Product::where('id','>',0)->where('type','校服')->orderBy('created_at', 'desc');
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $cats= $this->categoryRepository->getRootCatArray();
        $type='';
        $team_sale=false;
        //$type=1 单选
        if(array_key_exists('type',$inputs)){
                $type='_'.$inputs['type'];
        }
        if(array_key_exists('prom_id',$inputs)) {
            $product=$product->where('prom_type','3')->where('prom_id',$inputs['prom_id']);
        }
        if(array_key_exists('team_sale',$inputs)) {
            if(!empty($inputs['team_sale'])){
                $team_sale=true;
            }
        }

        if(array_key_exists('cat_level01',$inputs) || array_key_exists('cat_level02',$inputs) || array_key_exists('cat_level03',$inputs)){
            $inputs['category_id'] = 0;
            if ($inputs['cat_level03']!=0) {
                $inputs['category_id'] = $inputs['cat_level03'];
                $third_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level03= $inputs['category_id'];
            }
            if ($inputs['cat_level02']!=0) {
                $inputs['category_id'] = $inputs['cat_level02'];
                $second_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level02= $inputs['category_id'];
            }
            if ($inputs['cat_level01']!=0) {
                $inputs['category_id'] = $inputs['cat_level01'];
            }
            if($inputs['category_id']!=0) {
                $category_id_arr= $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($inputs['category_id']);
                // return $category_id_arr;
                $products= $product->whereIn('category_id', $category_id_arr);
            }
        }

        if(array_key_exists('keywords',$inputs)){
            $product=$product->where('name','like', '%' . $inputs['keywords'] . '%');
        }
        $product_list_get=$product->with('specs')->get();
        $products=$product->with('specs')->paginate($this->defaultPage());
        $i=0;
        foreach ($product_list_get as $item){
            $items=$item->specs;
            if(count($items)){
                   // $i++;
                foreach ($items as $item2) {
                    $i++;
                }
            }else{
                $i++;
            }
        }
        $product_num=$i;
        return view('admin.school_product.search_tem'.$type)
                    ->with('team_sale',$team_sale)
                    ->with('cats',$cats)
                    ->with('second_cats', $second_cats)
                    ->with('third_cats',$third_cats)
                    ->with('product',$products)
                    ->with('products',$products)
                    ->with('product_num',$product_num)
                    ->with('level01',$level01)
                    ->with('level02',$level02)
                    ->with('level03',$level03)
                    ->withInput(Input::all());

    }

    public function searchGoodsFrame(Request $request){
        $inputs=$request->all();

        $product=Product::where('id','>',0)->orderBy('created_at', 'desc');
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $cats= $this->categoryRepository->getRootCatArray();
        $type='';
        $team_sale=false;
        //$type=1 单选
        if(array_key_exists('type',$inputs)){
                $type='_'.$inputs['type'];
        }
        if(array_key_exists('prom_id',$inputs)) {
            $product=$product->where('prom_type','3')->where('prom_id',$inputs['prom_id']);
        }
        if(array_key_exists('team_sale',$inputs)) {
            if(!empty($inputs['team_sale'])){
                $team_sale=true;
            }
        }

        if(array_key_exists('cat_level01',$inputs) || array_key_exists('cat_level02',$inputs) || array_key_exists('cat_level03',$inputs)){
            $inputs['category_id'] = 0;
            if ($inputs['cat_level03']!=0) {
                $inputs['category_id'] = $inputs['cat_level03'];
                $third_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level03= $inputs['category_id'];
            }
            if ($inputs['cat_level02']!=0) {
                $inputs['category_id'] = $inputs['cat_level02'];
                $second_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level02= $inputs['category_id'];
            }
            if ($inputs['cat_level01']!=0) {
                $inputs['category_id'] = $inputs['cat_level01'];
            }
            if($inputs['category_id']!=0) {
                $category_id_arr= $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($inputs['category_id']);
                // return $category_id_arr;
                $products= $product->whereIn('category_id', $category_id_arr);
            }
        }

        if(array_key_exists('keywords',$inputs)){
            $product=$product->where('name','like', '%' . $inputs['keywords'] . '%');
        }
        $product_list_get=$product->with('specs')->get();
        $products=$product->with('specs')->paginate($this->defaultPage());
        $i=0;
        foreach ($product_list_get as $item){
            $items=$item->specs;
            if(count($items)){
                   // $i++;
                foreach ($items as $item2) {
                    $i++;
                }
            }else{
                $i++;
            }
        }
        $product_num=$i;
        return view('admin.products.search_tem'.$type)
                    ->with('team_sale',$team_sale)
                    ->with('cats',$cats)
                    ->with('second_cats', $second_cats)
                    ->with('third_cats',$third_cats)
                    ->with('product',$products)
                    ->with('products',$products)
                    ->with('product_num',$product_num)
                    ->with('level01',$level01)
                    ->with('level02',$level02)
                    ->with('level03',$level03)
                    ->withInput(Input::all());
    }



    
}