<?php

namespace App\Repositories;

use App\Models\CardRecord;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CardRecordRepository
 * @package App\Repositories
 * @version April 12, 2018, 2:58 pm CST
 *
 * @method CardRecord findWithoutFail($id, $columns = ['*'])
 * @method CardRecord find($id, $columns = ['*'])
 * @method CardRecord first($columns = ['*'])
*/
class CardRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'card_id',
        'content',
        'read_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CardRecord::class;
    }

    //根据激活码找到详细信息
    public function getDetailByNumber($num){
        return CardRecord::where('content','like','%'.$num.'%')
        ->orderBy('created_at','desc')
        ->first();
    }

    //根据激活码找到信息列表
    public function getListByNumber($num){
        return CardRecord::where('content','like','%'.$num.'%')->get();
    }

    //没有发送短信通知的记录
    public function unInformRecords(){
        return CardRecord::where('code',0)->get();
    }


}
