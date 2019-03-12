<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CardLog
 * @package App\Models
 * @version March 28, 2018, 3:09 pm CST
 *
 * @property string shopinfo
 */
class CardLog extends Model
{
    use SoftDeletes;

    public $table = 'card_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'shopinfo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'shopinfo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'shopinfo' => 'required'
    ];

    
}
