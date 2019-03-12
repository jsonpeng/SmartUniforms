<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ConsultRecord
 * @package App\Models
 * @version May 17, 2018, 5:46 pm CST
 *
 * @property string name
 * @property string class
 * @property string shengao
 * @property string tizhong
 * @property integer chima
 * @property string guige
 * @property string remark
 */
class ConsultRecord extends Model
{
    use SoftDeletes;

    public $table = 'consult_records';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'class',
        'shengao',
        'tizhong',
        'chima',
        'guige',
        'remark',
        'user_id',
        'sex',
        'school_name',
        'commit',
        'type',
        'do',
        'user_edit'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'class' => 'string',
        'shengao' => 'string',
        'tizhong' => 'string',
        'chima' => 'integer',
        'guige' => 'string',
        'remark' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    
}
