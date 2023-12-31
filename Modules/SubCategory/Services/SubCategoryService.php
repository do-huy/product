<?php

namespace Modules\SubCategory\Services;

use Modules\SubCategory\Repositories\SubCategoryRepository;

class SubCategoryService
{
    protected $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function getCategory()
    {
        return $this->subCategoryRepository->getCategory();
    }

    public function createSubCategory($data)
    {
        return $this->subCategoryRepository->create($data);
    }

    public function getById($id)
    {
        return $this->subCategoryRepository->getById($id);
    }

    public function updateSubCategory($data, $id)
    {
        return $this->subCategoryRepository->update($data, $id);
    }

}
