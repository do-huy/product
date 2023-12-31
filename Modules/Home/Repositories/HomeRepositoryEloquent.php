<?php

namespace Modules\Home\Repositories;

use Modules\Carousel\app\Models\Carousel;
use Modules\Category\app\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Home\Repositories\HomeRepository;
use Modules\Product\app\Models\Product;
use Validators\Home\Repositories\HomeValidator;

/**
 * Class HomeRepositoryEloquent.
 *
 * @package namespace Modules\Home\Repositories;
 */
class HomeRepositoryEloquent extends BaseRepository implements HomeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    public function getCategory()
    {
        $categories = Category::select('id','name')->get();
        return $categories;
    }

    public function getCarousel()
    {
        $carousels = Carousel::select('id','name')->get();
        return $carousels;
    }

    public function getProduct()
    {
        $products = $this->model->with(['seller' => function ($query) {
            $query->select('id', 'name');
        }])->select('id', 'name','seller_id','price','slug')->get();
        return $products;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
