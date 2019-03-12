<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use App\Models\RegCode;
use Carbon\Carbon;
use App\Models\AttachConsult;

//过滤处理特殊字节
function filter_str($nickname){      
          $strEncode = '';
          $length = mb_strlen($nickname,'utf-8');
          for ($i=0; $i < $length; $i++) {
              $_tmpStr = mb_substr($nickname,$i,1,'utf-8');
              if(strlen($_tmpStr) >= 4){
                  $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
              }else{
                  $strEncode .= $_tmpStr;
             }
         }
         if(empty($strEncode)){
            $strEncode = '微信昵称';
         }
        return $strEncode;
}



function find_code($code){
    $code = RegCode::where('code',$code)->first();
    return empty($code->name) ? (object)['attr' => $code->code,'template' => $code->template] :  (object)['attr' => $code->name,'template' => $code->template];
}

function getConsultNum($name,$chima){
    $zhengding = AttachConsult::where('do',0)->where('pname','like','%'.$name.'%')->where('chima','like','%'.$chima.'%')->first(
         array(
            \DB::raw('SUM(zengding) as zengdings'),
            \DB::raw('SUM(tuihui) as tuihuis')
               )
     );

    return $zhengding;
}

function sms_tem_content($time=null,$address=null,$product=null,$template=0){
    if(empty($time)){
        $time = Carbon::today()->format('Y-m-d');
    }
    if(empty($address)){
        $address = '未知地点';
    }
    if(empty($product)){
        $product = '未知物品';
    }
    return $template ?  '亲爱的家长,您的'.$product.'于'.$time.'已经安放在'.$address.'，请速领取。' : '亲爱的家长,我们于'.$time.'在'.$address.'发现了您的'.$product.',请知悉。';
}


function sms_tem_id($template=0){
    return  $template ? 'SMS_137685478' : 'SMS_132995417';
}

/**
 * 地图逆解析
 */
function getAddressLocation($jindu,$weidu){
    $address = file_get_contents('http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location='.$weidu.','.$jindu.'&output=json&pois=1&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5');
    $address = explode(',',$address); 
    $sub_address = substr($address[3],21);
    $sub_address =substr($sub_address,0,strlen($sub_address)-1); 
    return $sub_address;
}

function chimaList(){
      $list= preg_replace("/\n|\r\n/", "_",getSettingValueByKey('chima_list'));
      $list_arr = explode('_',$list);
      return $list_arr;
}


/**
 * 获取设置信息
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function getSettingValueByKey($key){
    return app('setting')->valueOfKey($key);
}

function getSettingValueByKeyCache($key){
    return Cache::remember('getSettingValueByKey'.$key, Config::get('web.cachetime'), function() use ($key){
        return getSettingValueByKey($key);
    });
}


/**
 * 获取主题设置
 * @return [array] [theme setting]
 */
function theme()
{
    $themes = Config::get('zcjytheme.theme');
    $themeName = app('setting')->valueOfKey('theme');
    if (empty($themeName)) {
        $themeName = 'default';
    }
    foreach ($themes as $theme) {
        if ($theme['name'] == $themeName) {
            return $theme;
        }
    }
    return [
        'name' => 'default',
        'parent' => 'default',
        'display_name' => '默认主题',
        'image' => 'themes/default/cover.png',
        'des' => '默认主题',
        'maincolor' => '#ff4e44',
        'secondcolor' => '#84d4da'
    ];
}

/**
 * 主色调
 * @return [type] [description]
 */
function themeMainColor()
{
    $theme_maincolor = app('setting')->valueOfKey('theme_main_color');
    if (empty($theme_maincolor)) {
        return theme()['maincolor'];
    }
    return $theme_maincolor;
}

/**
 * 次色调
 * @return [type] [description]
 */
function themeSecondColor()
{
    $theme_secondcolor = app('setting')->valueOfKey('theme_second_color');
    if (empty($theme_secondcolor)) {
        return theme()['secondcolor'];
    }
    return $theme_secondcolor;
}

/**
 * 前端页面路径
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function frontView($name)
{
    $themeSetting = theme();
    if (view()->exists('front.'.theme()['name'].'.'.$name)) {
        return 'front.'.theme()['name'].'.'.$name;
    }else{
        if (view()->exists('front.'.theme()['parent'].'.'.$name)) {
            return 'front.'.theme()['parent'].'.'.$name;
        }else{
            
            return 'front.default.'.$name;
        }
    }
}


/**
 * 功能是否被打开 （需要系统 和商家同时开启该功能）
 * @param  [type] $func_name [description]
 * @return [type]            [description]
 */
function funcOpen($func_name)
{
    $config  = Config::get('web.'.$func_name);
    if ($config && sysOpen($func_name)) {
        return true;
    }else{
        return false;
    }
    //return empty($config) ? false : $config;
}

function funcOpenCache($func_name)
{
    return Cache::remember('funcOpen'.$func_name, Config::get('web.cachetime'), function() use ($func_name){
        return funcOpen($func_name);
    });
}

/**
 * 商家自己控制功能是否打开
 * @param  [type] $func_name [description]
 * @return [type]            [description]
 */
function sysOpen($func_name)
{
    $config  = intval( getSettingValueByKey($func_name) );
    return empty($config) ? false : true;
}

function sysOpenCache($func_name)
{
    return Cache::remember('sysOpen'.$func_name, Config::get('web.cachetime'), function() use ($func_name){
        return sysOpen($func_name);
    });
}


//将时间处理成以偶数小时开头，分跟秒为0的时间
function processTime($cur_time)
{
    if ($cur_time->hour%2) {
        $cur_time->subHour();
    }
    $cur_time->minute = 0;
    $cur_time->second = 0;
    return $cur_time;
}


/**
 * 笛卡尔积
 * @return [type] [description]
 */
function combineDika() {
    $data = func_get_args();
    $data = current($data);
    $cnt = count($data);
    $result = array();
    $arr1 = array_shift($data);
    foreach($arr1 as $key=>$item) 
    {
        $result[] = array($item);
    }       

    foreach($data as $key=>$item) 
    {                                
        $result = combineArray($result,$item);
    }
    return $result;
}

/**
 * 数组转对象
 * @param  [type] $d [description]
 * @return [type]    [description]
 */
function arrayToObject($d) {
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object) array_map(__FUNCTION__, $d);
    }
    else {
        // Return object
        return $d;
    }
}

/**
 * 数组转字符串
 * @param  [type] $re1 [description]
 * @return [type]      [description]
 */
function arrayToString($re1){
    $str = "";
    $cnt = 0;
    foreach ($re1 as $value)
    {
        if($cnt == 0) {
            $str = $value;
        }
        else{
            $str = $str.','.$value;
        }
        $cnt++;
    }
}

/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
*/

function combineArray($arr1,$arr2) {         
    $result = array();
    foreach ($arr1 as $item1) 
    {
        foreach ($arr2 as $item2) 
        {
            $temp = $item1;
            $temp[] = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}

/**
 * 删除数字元素
 * @param  [type] $arr [description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function array_remove($arr, $key){
    if(!array_key_exists($key, $arr)){
        return $arr;
    }
    $keys = array_keys($arr);
    $index = array_search($key, $keys);
    if($index !== FALSE){
        array_splice($arr, $index, 1);
    }
    return $arr;

}


//修改env
function modifyEnv(array $data)
{
    $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

    $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

    $contentArray->transform(function ($item) use ($data){
        foreach ($data as $key => $value){
            if(str_contains($item, $key)){
                return $key . '=' . $value;
            }
        }
        return $item;
    });

    $content = implode($contentArray->toArray(), "\n");

    \File::put($envPath, $content);
}

/**
 * 指定位置插入字符串
 * @param $str  原字符串
 * @param $i    插入位置
 * @param $substr 插入字符串
 * @return string 处理后的字符串
 */
function insertToStr($str, $i, $substr){
    //指定插入位置前的字符串
    $startstr="";
    for($j=0; $j<$i; $j++){
        $startstr .= $str[$j];
    }

    //指定插入位置后的字符串
    $laststr="";
    for ($j=$i; $j<strlen($str); $j++){
        $laststr .= $str[$j];
    }

    //将插入位置前，要插入的，插入位置后三个字符串拼接起来
    $str = $startstr . $substr . $laststr;

    //返回结果
    return $str;
}