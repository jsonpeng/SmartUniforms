<?php

namespace App\Repositories;

use App\Models\School;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SchoolRepository
 * @package App\Repositories
 * @version October 17, 2018, 8:46 am CST
 *
 * @method School findWithoutFail($id, $columns = ['*'])
 * @method School find($id, $columns = ['*'])
 * @method School first($columns = ['*'])
*/
class SchoolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return School::class;
    }
}
