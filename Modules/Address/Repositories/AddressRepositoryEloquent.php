<?php

namespace Modules\Address\Repositories;

use Modules\Address\app\Models\Address;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Address\Repositories\AddressRepository;
use Validators\Address\Repositories\AddressValidator;

/**
 * Class AddressRepositoryEloquent.
 *
 * @package namespace Modules\Address\Repositories;
 */
class AddressRepositoryEloquent extends BaseRepository implements AddressRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Address::class;
    }

    public function getAddress()
    {
        $addresses = auth()->user()->addresses()
        ->orderBy('is_default', 'DESC')
        ->get();
        return $addresses;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
