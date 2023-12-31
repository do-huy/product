<?php

namespace Modules\Category\Repositories;

use Modules\Category\app\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Category\Repositories\CategoryRepository;
use Validators\Category\Repositories\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace Modules\Category\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function create($data)
    {
        $category = $this->model->create($data);
        if (request()->hasFile('image')) {
            $category->addMediaFromRequest('image')
                ->usingName($category->name)
                ->toMediaCollection('category');
        }
    }

    public function getById($id)
    {
        return  $this->model
                ->select('id','name','status')
                ->find($id);
    }

    public function update($data, $id)
    {
        $category = $this->model->find($id);
        $category->fill($data);
        $category->update();
        if (request()->hasFile('image')) {
            $category->clearMediaCollection('category');
            $category->addMediaFromRequest('image')
                ->usingName($category->name)
                ->toMediaCollection('category');
        }
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
