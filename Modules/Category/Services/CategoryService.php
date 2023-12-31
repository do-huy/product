<?php

namespace Modules\Category\Services;

use Modules\Category\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->create($data);
    }

    public function getById($id)
    {
        return $this->categoryRepository->getById($id);
    }

    public function updateCategory($data, $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

}
