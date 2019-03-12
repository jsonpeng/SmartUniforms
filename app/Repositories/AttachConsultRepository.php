<?php

namespace App\Repositories;

use App\Models\AttachConsult;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachConsultRepository
 * @package App\Repositories
 * @version October 17, 2018, 10:52 am CST
 *
 * @method AttachConsult findWithoutFail($id, $columns = ['*'])
 * @method AttachConsult find($id, $columns = ['*'])
 * @method AttachConsult first($columns = ['*'])
*/
class AttachConsultRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'consult_id',
        'name',
        'chima',
        'zengding',
        'tuihui'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachConsult::class;
    }
}
