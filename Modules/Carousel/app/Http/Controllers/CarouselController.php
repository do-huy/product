<?php

namespace Modules\Carousel\app\Http\Controllers;

use App\DataTables\CarouselsDataTable;
use App\Http\Controllers\Controller;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Carousel\app\Http\Requests\CarouselRequest;
use Modules\Carousel\app\Models\Carousel;
use Modules\Carousel\Services\CarouselService;

class CarouselController extends Controller
{

    use DeleteModelTraits;
    protected $carouselService, $carousel;

    public function __construct(CarouselService $carouselService, Carousel $carousel) {
        $this->carouselService = $carouselService;
        $this->carousel = $carousel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CarouselsDataTable $carouselsDataTable)
    {
        return $carouselsDataTable->render('carousel::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('carousel::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarouselRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $this->carouselService->createCarousel($data);
            return redirect()->route('carousel.index')->with('success','Thêm carousel / banner thành công.');
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('carousel::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $carousel = $this->carouselService->getById($id);
        return view('carousel::edit',compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarouselRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->carouselService->updateCarousel($data, $id);
            return redirect()->route('carousel.index')->with('success','Cập nhập carousel / banner thành công.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTraits($id, $this->carousel);
    }
}
