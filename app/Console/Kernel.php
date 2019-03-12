<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\Models\CouponUser;
use Log;
use App\Jobs\SendSms;
use Schema;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule. 
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //备份
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
        if(Schema::hasTable('settings')){
            //自动发未通知记录的短信
               if(getSettingValueByKey('send_sms_time') == 'now'){
                    //Log::info('now');
                    $schedule->call(function () {
                            $this->sendMessage();
                    })->everyMinute();
                }
                else{
                    //Log::info('定时');
                    $schedule->call(function () {
                            $this->sendMessage();
                    })->daily()->at(getSettingValueByKey('send_sms_time'));
                }
        }
         
        
    }

    private function sendMessage(){
            #未通知的发送记录
            $records = app('commonRepo')->cardRecordRepo()->unInformRecords();

            if(count($records)){
                foreach($records as $k => $record){
                    #从中取出激活码
                    $codes_arr = $this->subNum(explode(',', $record->content));
                    #取出所有的激活记录
                    $active_records = app('commonRepo')->memberCardRepo()->all();
                    foreach ($active_records as $key => $active_record) {
                        #如果在记录中有就发短信
                        if(in_array($active_record->code,$codes_arr)){
                                $reg_code = find_code($active_record->code);
                                $message = ['mobile'=>$active_record->mobile,'time'=>Carbon::parse($record->read_time)->format('Y-m-d'),'address'=>empty($record->remark) ? $record->location : $record->remark,'product'=>(string)($reg_code->attr),'template'=>$reg_code->template];
                                
                         Log::info($message);
                         #发短信
                         dispatch(new SendSms($message));
                         //app('commonRepo')->sendVerifyCode($message['mobile'],$message['time'],$message['address'],$message['product'],$reg_code->template);
                         #更新通知状态
                         $active_record->update([
                            'status'=>1
                         ]);
                         $user = user_mobile($active_record->mobile);
                          // Log::info($user);
                         #给对应的微信用户也加上通知
                         if(!empty($user) && !empty($user->openid)){
                             app('commonRepo')->weixinText(sms_tem_content($message['time'],$message['address'],$message['product'],$reg_code->template),$user->openid);
                         }
                        }
                    }
                    if(app('commonRepo')->memberCardRepo()->allInformByArr($codes_arr)){
                        #更新短信提醒记录
                        $record->update([
                                    'code'=>1
                            ]);
                     }
                }
            }
            /*
            #未通知的记录
            $records = app('commonRepo')->memberCardRepo()->unInformRecords();
          
            #如果存在未通知的就发短信
            if(count($records)){
                foreach($records as $k => $v){
                    $card_record_detail =app('commonRepo')->cardRecordRepo()->getDetailByNumber($v->code); 
                     Log::info($card_record_detail);
                     #确认激活码存在
                    if(!empty($card_record_detail)){
                         #发送的对象
                         $message = ['mobile'=>$v->mobile,'time'=>Carbon::parse($card_record_detail->read_time)->format('Y-m-d'),'address'=>empty($card_record_detail->remark) ? $card_record_detail->location : $card_record_detail->remark];
                         // Log::info($message);
                         #发短信
                         app('commonRepo')->sendVerifyCode($message['mobile'],$message['time'],$message['address']);
                         #更新通知状态
                         $v->update([
                            'status'=>1
                         ]);
                         $user = user_mobile($v->mobile);
                          // Log::info($user);
                         #给对应的微信用户也加上通知
                         if(!empty($user) && !empty($user->openid)){
                             app('commonRepo')->weixinText('亲爱的家长，我们于'.$message['time'].'在'.$message['address'].'找到了您的物品，请知悉。',$user->openid);
                         }
                    }
                }
            }
            */
    }

    private function subNum($num_arr){
        if(count($num_arr)){
            foreach ($num_arr as $key => $val) {
                    $num_arr[$key] = substr($val,3,5);
            }
        }
        return $num_arr;
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
