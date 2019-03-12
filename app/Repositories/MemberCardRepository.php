<?php

namespace App\Repositories;

use App\Models\MemberCard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MemberCardRepository
 * @package App\Repositories
 * @version March 28, 2018, 3:08 pm CST
 *
 * @method MemberCard findWithoutFail($id, $columns = ['*'])
 * @method MemberCard find($id, $columns = ['*'])
 * @method MemberCard first($columns = ['*'])
*/
class MemberCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'register_type',
        'code',
        'openid',
        'mobile'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MemberCard::class;
    }

    //未短信通知的手机记录
    public function unInformRecords(){
        return MemberCard::where('status',0)->get();
    }

    //全部通知
    public function allInformByArr($arr){
        $MemberCards = MemberCard::whereIn('code',$arr)->get();
        $status = true;
        foreach ($MemberCards as $key => $val) {
            if($val->status == 0){
                $status = false;
            }
        }
        return $status;
    }
}
