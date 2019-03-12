<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RegCode
 * @package App\Models
 * @version April 11, 2018, 2:01 pm CST
 *
 * @property integer code
 * @property integer item_id
 * @property integer status
 * @property integer user_id
 * @property string share_link
 */
class RegCode extends Model
{
    use SoftDeletes;

    public $table = 'reg_codes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'item_id',
        'status',
        'user_id',
        'share_link',
        'price',
        'name',
        'template'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'integer',
        'item_id' => 'integer',
        'status' => 'integer',
        'user_id' => 'integer',
        'share_link' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'price' => 'required'
    ];

    #关联的商品
    public function item(){
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }

    #关联的用户
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    
    #激活码使用状态
    public function getUseStateAttribute(){

        return empty($this->status)?'未使用':'已使用';

    }

    #关联商品对象
    public function getItemObjAttribute(){
        return $this->item()->first();
    }

    #关联的用户名
    public function getUserNickNameAttribute(){
        return !empty($this->user()->first())?$this->user()->first()->nickname:'';
    }
    
}
