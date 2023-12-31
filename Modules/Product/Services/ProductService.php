<?php

namespace Modules\Product\Services;

use Modules\Product\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCategory()
    {
        return $this->productRepository->getCategory();
    }

    public function createProduct($data)
    {
        return $this->productRepository->create($data);
    }

    public function getById($slug)
    {
        return $this->productRepository->getById($slug);
    }

    public function updateProduct($data, $id)
    {
        return $this->productRepository->update($data, $id);
    }

}
