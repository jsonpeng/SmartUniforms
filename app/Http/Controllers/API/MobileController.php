<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Overtrue\EasySms\EasySms;
use Log;
use Config;
use App\Jobs\SendSms;
use App\User;
use App\Models\MachineIde;

class MobileController extends Controller
{



  public function testWechatMessage(Request $request){
    $input = $request->all();
    if(isset($input['open_id'])){
      app('commonRepo')->weixinText('吉丁甲测试微信消息:亲爱的家长，我们于{time}在{address}发现了您的{product}，请知悉',$input['open_id']);
      return 'success';
    }
    else{
      return 'fail';
    }
  }

	//发送短信验证码
    public function sendVerifyCode(Request $request)
    {
        $input = $request->all();
        if(array_key_exists('mobile', $input) && array_key_exists('time', $input) && array_key_exists('address', $input) ){
            return $this->dispatch(new SendSms($input));
        }
        
    }

    /**
     * 激活积分卡
     * @param  [type] $type     [激活渠道 手机、微信]
     * @param  [type] $code     [激活码]
     * @param  [type] $identify [用户标识，手机号或者OPENID]
     */
    public function activaCard(Request $request,$id)
    {
    	 # code...
          $input=$request->all(); 
          $user = User::find($id);

          if(empty($user)){
             return $this->ajax_result_fail;
          }
     
          $code = explode("_",$input['code']);
          $user->update([
            'mobile'=> $code[0]
          ]);

          $result = app('commonRepo')->activeMemberCard($input['type'],$input['code'],$user);
          if($result){
            
                   return ['code'=>0,'message'=>$result];
          }
          else{
                  return $this->ajax_result_fail;
          } 

        
        

    }

    //存储智能读卡器的信息
    //需要的参数
    // [int]        card_id     读卡器的id
    // [string]     content     读卡器读取的内容,
    // [datetime]   read_time   读取时间
    public function saveCardRecord(Request $request){

        $input =$request->all();
        
        #处理经纬度地址
        if(array_key_exists('location',$input)){
            $input_location = explode(',', $input['location']);
            $input['location'] = getAddressLocation($input_location[0],$input_location[1]);
        }

        #机器
        $machine = MachineIde::where('machine_id',$input['card_id'])->first();
        
        if(empty($machine)){
          return $this->ajax_result_fail;
        }

        $input['remark'] = $machine->machine_name;

        // #处理别名
        // $card_records = app('commonRepo')->cardRecordRepo()->model()::where('card_id',$input['card_id']);

        // $card_records_list = $card_records->get();
        // if(count($card_records_list)){
        //     foreach ($card_records_list as $key => $val) {
        //       #如果其中有别名 就更新所有的别名
        //       if(!empty($val->remark)){
        //          $card_records->update(['remark'=>$val->remark]);
        //          $input['remark'] = $val->remark;
        //       }
        //     }
        // }

        return $this->defaultAjaxActionByRepo(app('commonRepo')->cardRecordRepo(),$input,'store',true);

    }

    //保存征询单信息
    public function createConsultRecord(Request $request){
        $input = $request->all();
        $input['user_id'] = auth('web')->user();
        return $this->defaultAjaxActionByRepo(app('commonRepo')->consultRecordRepo(),$input,'store',true);     
     }

    //更新征询单信息
    public function updateConsultRecord(Request $request,$id){
        $input = $request->all();
        $input['user_id'] = auth('web')->user();
        return $this->defaultAjaxActionByRepo(app('commonRepo')->consultRecordRepo(),$input,'update',true,$id);     
     }

}
