<?php

namespace Modules\Product\app\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Product\app\Http\Requests\ProductRequest;
use Modules\Product\app\Models\Product;
use Modules\Product\Services\ProductService;

class ProductController extends Controller
{

    use DeleteModelTraits;

    protected $productService, $product;
    public function __construct(ProductService $productService, Product $product) {
        $this->productService = $productService;
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $productsDataTable)
    {
        return $productsDataTable->render('product::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productService->getCategory();
        return view('product::create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $this->productService->createProduct($data);
            return redirect()->route('product.index')->with('success','Thêm sản phẩm thành công.');
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $product = $this->productService->getById($slug);
        $categories = $this->productService->getCategory();
        return view('product::edit',compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->productService->updateProduct($data, $id);
            return redirect()->route('product.index')->with('success','Cập nhập sản phẩm thành công.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTraits($id, $this->product);
    }
}
