<?php

namespace Modules\Home\Services;

use Modules\Home\Repositories\HomeRepository;

class HomeService
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    public function getCategory()
    {
        return $this->homeRepository->getCategory();
    }
    public function getCarousel()
    {
        return $this->homeRepository->getCarousel();
    }
    public function getProduct()
    {
        return $this->homeRepository->getProduct();
    }



}
