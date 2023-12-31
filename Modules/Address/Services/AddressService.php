<?php

namespace Modules\Address\Services;

use Modules\Address\Repositories\AddressRepository;

class AddressService
{
    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAddress()
    {
        return $this->addressRepository->getAddress();
    }


}
