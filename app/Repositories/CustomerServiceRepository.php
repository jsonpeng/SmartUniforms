<?php

namespace App\Repositories;

use App\Models\CustomerService;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CustomerServiceRepository
 * @package App\Repositories
 * @version February 27, 2018, 5:21 pm CST
 *
 * @method CustomerService findWithoutFail($id, $columns = ['*'])
 * @method CustomerService find($id, $columns = ['*'])
 * @method CustomerService first($columns = ['*'])
*/
class CustomerServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'platform',
        'job',
        'head_img',
        'qr_code',
        'commit',
        'show'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CustomerService::class;
    }

    public function descToShow()
    {
        return CustomerService::orderBy('created_at', 'desc')->get();
    }
}
