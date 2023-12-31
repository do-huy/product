<?php

namespace Modules\Carousel\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Carousel\app\Models\Carousel;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Carousel\Repositories\CarouselRepository;
use Validators\Carousel\Repositories\CarouselValidator;

/**
 * Class CarouselRepositoryEloquent.
 *
 * @package namespace Modules\Carousel\Repositories;
 */
class CarouselRepositoryEloquent extends BaseRepository implements CarouselRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Carousel::class;
    }

    public function create($data)
    {
        $carousel = new $this->model($data);
        $carousel->user_id = Auth::user()->id;
        $carousel->save();
        if (request()->hasFile('image')) {
            $carousel->addMediaFromRequest('image')
                ->usingName($carousel->name)
                ->toMediaCollection('carousel');
        }
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $carousel = $this->model->find($id);
        $carousel->fill($data);
        $carousel->user_id = Auth::user()->id;
        $carousel->update();

        if (request()->hasFile('image')) {
            $carousel->clearMediaCollection('carousel');
            $carousel->addMediaFromRequest('image')
                ->usingName($carousel->name)
                ->toMediaCollection('carousel');
        }

        return $carousel;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
