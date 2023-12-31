<?php

namespace Modules\Carousel\Services;

use Modules\Carousel\Repositories\CarouselRepository;

class CarouselService
{
    protected $carouselRepository;

    public function __construct(CarouselRepository $carouselRepository)
    {
        $this->carouselRepository = $carouselRepository;
    }

    public function createCarousel($data)
    {
        return $this->carouselRepository->create($data);
    }

    public function getById($id)
    {
        return $this->carouselRepository->getById($id);
    }

    public function updateCarousel($data, $id)
    {
        return $this->carouselRepository->update($data, $id);
    }

}
