<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachConsult
 * @package App\Models
 * @version October 17, 2018, 10:52 am CST
 *
 * @property integer consult_id
 * @property string name
 * @property string chima
 * @property integer zengding
 * @property integer tuihui
 */
class AttachConsult extends Model
{
    use SoftDeletes;

    public $table = 'attach_consults';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'consult_id',
        'pname',
        'chima',
        'zengding',
        'tuihui',
        'price',
        'do'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'consult_id' => 'integer',
        'pname' => 'string',
        'chima' => 'string',
        'zengding' => 'integer',
        'tuihui' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function consult(){
        return $this->belongsTo('App\Models\ConsultRecord','consult_id','id');
    }

    
}
