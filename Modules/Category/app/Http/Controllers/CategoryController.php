<?php

namespace Modules\Category\app\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Category\app\Http\Requests\CreateCategoryRequest;
use Modules\Category\app\Http\Requests\UpdateCategoryRequest;
use Modules\Category\app\Models\Category;
use Modules\Category\Services\CategoryService;

class CategoryController extends Controller
{
    use DeleteModelTraits;
    protected $categoryService, $category;

    public function __construct(CategoryService $categoryService, Category $category) {
        $this->categoryService = $categoryService;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CategoriesDataTable $categoriesDataTable)
    {
        return $categoriesDataTable->render('category::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $this->categoryService->createCategory($data);
            return redirect()->route('category.index')->with('success','Thêm danh mục thành công.');
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->categoryService->getById($id);
        return view('category::edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->categoryService->updateCategory($data, $id);
            return redirect()->route('category.index')->with('success','Cập nhập danh mục thành công.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTraits($id, $this->category);
    }
}
