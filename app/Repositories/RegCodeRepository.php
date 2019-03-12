<?php

namespace App\Repositories;

use App\Models\RegCode;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RegCodeRepository
 * @package App\Repositories
 * @version April 11, 2018, 2:01 pm CST
 *
 * @method RegCode findWithoutFail($id, $columns = ['*'])
 * @method RegCode find($id, $columns = ['*'])
 * @method RegCode first($columns = ['*'])
*/
class RegCodeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'item_id',
        'status',
        'user_id',
        'share_link'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RegCode::class;
    }

    /**
     * 最新的激活码
     */
    public function newCode($use_order=false){

        $new_code= empty($use_order)
        ?
            RegCode::orderBy('id','desc')->orderBy('code','desc')->first()
        :   RegCode::orderBy('id','asc')->where('status',0)->first();

        #如果用于后台添加
        if(empty($use_order)){
            return empty($new_code)?10001:$new_code->code+1;
        }else
        #如果用于订单支付成功后使用
        {
            #如果没有找到就新建
            if(empty($new_code)){
                #新建最后一个使用后的code 并且数量 +1
                $last_code  = RegCode::orderBy('id','desc')->where('status',1)->first();
                $new_code= RegCode::create([
                    'code'=>empty($last_code) ? 10001 : $last_code->code+1
                 ]);

                return $new_code->code;

            }#有的话就直接返回这个
            else{
                return $new_code->code;
            }
        }
    }

    /**
     * 根据code码来更新item_id和user_id
     */
    public function updateRelByCode($code,$attr){
        $regcode=RegCode::where('code',$code)->first();

        if(!empty($regcode)){
            $regcode->update($attr);
            return true;
        }else{
            return false;
        }
        
    }


}
