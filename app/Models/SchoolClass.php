<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SchoolClass
 * @package App\Models
 * @version October 22, 2018, 4:49 pm CST
 *
 * @property integer school_id
 * @property string name
 */
class SchoolClass extends Model
{
    use SoftDeletes;

    public $table = 'school_classes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'school_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'school_id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
