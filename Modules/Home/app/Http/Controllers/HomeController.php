<?php

namespace Modules\Home\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Carousel\app\Models\Carousel;
use Modules\Category\app\Models\Category;
use Modules\Home\Services\HomeService;
use Modules\Product\app\Models\Product;

class HomeController extends Controller
{
    protected $homeService;
    public function __construct(HomeService $homeService) {
        $this->homeService = $homeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = $this->homeService->getCarousel();
        $categories = $this->homeService->getCategory();
        $products = $this->homeService->getProduct();
        return view('home::index',compact('carousels','categories','products'));
    }
}
