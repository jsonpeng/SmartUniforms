<?php

namespace App\Repositories;

use App\Models\ConsultRecord;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ConsultRecordRepository
 * @package App\Repositories
 * @version May 17, 2018, 5:46 pm CST
 *
 * @method ConsultRecord findWithoutFail($id, $columns = ['*'])
 * @method ConsultRecord find($id, $columns = ['*'])
 * @method ConsultRecord first($columns = ['*'])
*/
class ConsultRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'class',
        'shengao',
        'tizhong',
        'chima',
        'guige',
        'remark'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ConsultRecord::class;
    }

    
}
