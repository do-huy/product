<?php

namespace Modules\SubCategory\Repositories;

use Modules\Category\app\Models\Category;
use Modules\SubCategory\app\Models\SubCategory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SubCategory\Repositories\SubCategoryRepository;
use Validators\SubCategory\Repositories\SubCategoryValidator;

/**
 * Class SubCategoryRepositoryEloquent.
 *
 * @package namespace Modules\SubCategory\Repositories;
 */
class SubCategoryRepositoryEloquent extends BaseRepository implements SubCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SubCategory::class;
    }

    public function getCategory()
    {
        return Category::select('id', 'name', 'status')->where('status', 1)->get();
    }

    public function create($data)
    {
        $this->model->create($data);
    }

    public function getById($id)
    {
        return  $this->model
                ->select('id', 'name', 'category_id', 'status')
                ->find($id);
    }

    public function update($data, $id)
    {
        $subCategory = $this->model->find($id);
        $subCategory->fill($data);
        $subCategory->update();
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
