<?php

namespace App\Repositories;

use App\Models\CardLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CardLogRepository
 * @package App\Repositories
 * @version March 28, 2018, 3:09 pm CST
 *
 * @method CardLog findWithoutFail($id, $columns = ['*'])
 * @method CardLog find($id, $columns = ['*'])
 * @method CardLog first($columns = ['*'])
*/
class CardLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shopinfo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CardLog::class;
    }
}
