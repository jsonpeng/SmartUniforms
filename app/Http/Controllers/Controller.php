<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $SUCCESS=0;
    public $FAIL=1;
    public $SERVER_ERROR=2;

    public $ajax_result_success=['code'=>0,'message'=>'请求成功'];
    public $ajax_result_fail=['code'=>1,'message'=>'请求异常'];
    public $api_result_success=['status_code'=>0,'data'=>'请求成功'];
	public $api_result_fail=['status_code'=>1,'data'=>'请求异常'];


	//当前微信用户
	public function weixinAuth(){
    	return optional(auth('web')->user());
	}

	//当前api用户
	public function apiAuth(){
		return optional(auth()->user());
	}

    
	
    /**
    * 默认ajax操作通过Repository对象
    * @param  [object]   $repo_obj [Repository对象]
    * @param  [array]    $input    [input的提交vale]
    * @param  [string]   $action   [动作(store添加 update更新 delete删除 show查看)]
    * @param  [bool]     $use_api  [使用api请求或者ajax请求]
    * @param  [int]      $id       [需要操作的id]
    */
   public function defaultAjaxActionByRepo($repo_obj,$input,$action='store',$use_api=false,$id=null){

 		$return_data=empty($use_api)?$this->ajax_result_success:$this->api_result_success;
        $return_data_error=empty($use_api)?$this->ajax_result_fail:$this->api_result_fail;

   
        #如果提交中有空的字符串
        // if($this->varifyInputValNull($input)){
        //    return $return_data_error;
        // }

        #创建操作
        if($action=='store'){
            $create_success_obj=($repo_obj->model())::create($input);

           	return $return_data;
        }

        $obj=$repo_obj->findWithoutFail($id);
        if(!empty($obj)){
            #更新操作
            if($action=='update'){
                $obj->update($input);
            }
            #删除操作
            if($action=='delete'){
                $repo_obj->delete($id);
            }
            #查看操作
            if($action=='show'){
                 empty($use_api)
                 ?
                 optional($return_data)['message']=$obj
                 :
                 optional($return_data)['data']=$obj;

            }
            return $return_data;
        }else{
        	return $return_data_error;
        }
   }


   public function varifyInputValNull($input){
         $input_val_null=false;
         if(!empty($input)){
            foreach ($input as $key => $value) {
                # code...
                if($value=='' || $value==null){
                    $input_val_null=true;
                }
            }
        }
        return $input_val_null;
   }

}
