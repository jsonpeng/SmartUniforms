<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Illuminate\Support\Facades\Artisan;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    //清空缓存
    public function clearCache()
    {
    Artisan::call('cache:clear');
    return ['status'=>true,'msg'=>''];
    }

    //运行定时任务
    public function autoTask(){
         Artisan::call('schedule:run');
    }
    
    /**
     * 获取分页数目
     * @return [type] [description]
     */
    public function defaultPage(){
        return empty(getSettingValueByKey('records_per_page')) ? 15 : getSettingValueByKey('records_per_page');
    }

    /**
     * 验证是否展开
     * @return [int] [是否展开tools 0不展开 1展开]
     */
    public function varifyTools($input,$order=false){
        $tools=1;
        // if(count($input)){
        //     $tools=1;
        //     if(array_key_exists('page', $input) && count($input)==1) {
        //         $tools = 0;
        //     }
        //     if($order){
        //         if(array_key_exists('menu_type', $input) && count($input)==1) {
        //             $tools = 0;
        //         }
        //     }
        // }
        return $tools;
    }

     /**
     * 倒序显示带分页
     */
    public function descAndPaginateToShow($obj,$attr,$desc='desc'){
       if(!empty($obj)){
            return $obj->orderBy($attr,$desc)->paginate($this->defaultPage());
        }else{
            return [];
        }
    }

    /**
     * 查询索引初始化状态
     */
    public function defaultSearchState($obj){
         if(!empty($obj)){
            return $obj::where('id','>',0);
         }else{
            return [];
         }
    }

}
