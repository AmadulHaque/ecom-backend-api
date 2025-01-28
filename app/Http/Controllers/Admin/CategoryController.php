<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        try {
            $entity = $this->categoryService->getAllCategories($request);

            return customView(['ajax' => 'components.category.table', 'default' => 'Admin::categories.index'], compact('entity'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            if ($request->category_id) {
                $data = $this->categoryService->getSubCategory($request);
            } else {
                $data = $this->categoryService->getMainCategory($request);
            }

            return success('Get categories successfully', $data);
        }

        return view('Admin::categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->storeCategory($request->validated());

            return success('Category created successfully');
        } catch (\Throwable $th) {
            return failure($th->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->category_id) {
                $data = $this->categoryService->getSubCategory($request);
            } else {
                $data = $this->categoryService->getMainCategory($request);
            }

            return success('Get categories successfully', $data);
        }
        $category = $this->categoryService->findCategory($id);

        return view('Admin::categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($request->validated(), $id);

            return success('Category updated successfully');
        } catch (\Exception $th) {
            return failure($th->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);

            return success('Category deleted successfully');
        } catch (\Exception $th) {
            return failure($th->getMessage());
        }
    }
}
