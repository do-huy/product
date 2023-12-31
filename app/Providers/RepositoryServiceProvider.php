<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Address\Repositories\AddressRepository;
use Modules\Address\Repositories\AddressRepositoryEloquent;
use Modules\Carousel\Repositories\CarouselRepository;
use Modules\Carousel\Repositories\CarouselRepositoryEloquent;
use Modules\Category\Repositories\CategoryRepository;
use Modules\Category\Repositories\CategoryRepositoryEloquent;
use Modules\Home\Repositories\HomeRepository;
use Modules\Home\Repositories\HomeRepositoryEloquent;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\ProductRepositoryEloquent;
use Modules\SubCategory\Repositories\SubCategoryRepository;
use Modules\SubCategory\Repositories\SubCategoryRepositoryEloquent;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(SubCategoryRepository::class, SubCategoryRepositoryEloquent::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(CarouselRepository::class, CarouselRepositoryEloquent::class);
        $this->app->bind(HomeRepository::class, HomeRepositoryEloquent::class);
        $this->app->bind(AddressRepository::class, AddressRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
