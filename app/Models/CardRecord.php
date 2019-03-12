<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CardRecord
 * @package App\Models
 * @version April 12, 2018, 2:58 pm CST
 *
 * @property integer card_id
 * @property string content
 * @property  read_time
 */
class CardRecord extends Model
{
    use SoftDeletes;

    public $table = 'card_records';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'card_id',
        'content',
        'read_time',
        'remark',
        'location',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'card_id' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
     
    ];

    
}
