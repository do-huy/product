<?php

namespace Modules\SubCategory\app\Http\Controllers;

use App\DataTables\SubCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Traits\DeleteModelTraits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\SubCategory\app\Http\Requests\SubCategoryRequest;
use Modules\SubCategory\app\Models\SubCategory;
use Modules\SubCategory\Services\SubCategoryService;

class SubCategoryController extends Controller
{
    use DeleteModelTraits;
    protected $subCategoryService, $subCategory;
    public function __construct(SubCategoryService $subCategoryService, SubCategory $subCategory) {
        $this->subCategoryService = $subCategoryService;
        $this->subCategory = $subCategory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoriesDataTable $subCategoriesDataTable)
    {
        return $subCategoriesDataTable->render('subcategory::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->subCategoryService->getCategory();
        return view('subcategory::create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->all();
            $this->subCategoryService->createSubCategory($data);
            return redirect()->route('subCategory.index')->with('success','Thêm danh mục phụ thành công.');
        });
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('subcategory::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subCategory = $this->subCategoryService->getById($id);
        $categories = $this->subCategoryService->getCategory();
        return view('subcategory::edit',compact('subCategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $data = $request->all();
            $this->subCategoryService->updateSubCategory($data, $id);
            return redirect()->route('subCategory.index')->with('success','Cập nhập danh mục phụ thành công.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTraits($id, $this->subCategory);
    }
}
