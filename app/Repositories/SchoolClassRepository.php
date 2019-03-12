<?php

namespace App\Repositories;

use App\Models\SchoolClass;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SchoolClassRepository
 * @package App\Repositories
 * @version October 22, 2018, 4:49 pm CST
 *
 * @method SchoolClass findWithoutFail($id, $columns = ['*'])
 * @method SchoolClass find($id, $columns = ['*'])
 * @method SchoolClass first($columns = ['*'])
*/
class SchoolClassRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'school_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SchoolClass::class;
    }
}
