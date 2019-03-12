<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MemberCard
 * @package App\Models
 * @version March 28, 2018, 3:08 pm CST
 *
 * @property string register_type
 * @property string code
 * @property string openid
 * @property string mobile
 */
class MemberCard extends Model
{
    use SoftDeletes;

    public $table = 'member_cards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'register_type',
        'code',
        'openid',
        'mobile',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'register_type' => 'string',
        'code' => 'string',
        'openid' => 'string',
        'mobile' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register_type' => 'required',
        'code' => 'required'
    ];

    

    
}
