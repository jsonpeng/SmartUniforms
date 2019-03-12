<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class School
 * @package App\Models
 * @version October 17, 2018, 8:46 am CST
 *
 * @property string name
 * @property string number
 */
class School extends Model
{
    use SoftDeletes;

    public $table = 'schools';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
       'name' => 'required',
    ];

    
}
