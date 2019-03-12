<?php

namespace App\Repositories;

use App\Models\MachineIde;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MachineIdeRepository
 * @package App\Repositories
 * @version June 13, 2018, 9:14 am CST
 *
 * @method MachineIde findWithoutFail($id, $columns = ['*'])
 * @method MachineIde find($id, $columns = ['*'])
 * @method MachineIde first($columns = ['*'])
*/
class MachineIdeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'machine_id',
        'machine_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MachineIde::class;
    }
}
