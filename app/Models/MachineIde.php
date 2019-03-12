<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MachineIde
 * @package App\Models
 * @version June 13, 2018, 9:14 am CST
 *
 * @property integer machine_id
 * @property string machine_name
 */
class MachineIde extends Model
{
    use SoftDeletes;

    public $table = 'machine_ides';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'machine_id',
        'machine_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'machine_id' => 'string',
        'machine_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
