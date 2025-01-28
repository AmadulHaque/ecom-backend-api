<?php

namespace App\Services;

use App\Exceptions\CategoryCreationException;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubCategoryChild;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    const MAIN = '1';

    const SUB = '2';

    const CHILD = '3';

    public static function getCategories(): mixed
    {
        try {
            $categories = Category::with('subcategories.subchilds')->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image,
                    'subcategories' => $category->subcategories->map(function ($subcategory) {
                        return [
                            'id' => $subcategory->id,
                            'name' => $subcategory->name,
                            'slug' => $subcategory->slug,
                            'image' => $subcategory->image,
                            'subchilds' => $subcategory->subchilds->map(function ($subchild) {
                                return [
                                    'id' => $subchild->id,
                                    'name' => $subchild->name,
                                    'slug' => $subchild->slug,
                                    'image' => $subchild->image,
                                ];
                            }),
                        ];
                    }),
                ];
            });

            return success('show all category', $categories);
        } catch (Exception $e) {
            return failure($e->getMessage(), 500);
        }
    }

    public function getAllCategories($request)
    {
        return match ($request->type ?? '1') {
            self::MAIN => $this->getMainCategory($request),
            self::SUB => $this->getSubCategory($request),
            self::CHILD => $this->getChildCategory($request),
            default => [],
        };
    }

    private function getBaseQuery($model, $request, $type)
    {
        $perPage = $request->perPage ?? 10;
        $page = $request->page ?? 1;

        return $model::query()
            ->when($type === self::MAIN, fn ($query) => $query->with('media'))
            ->when($type === self::SUB, fn ($query) => $query->with(['category', 'media']))
            ->when($type === self::CHILD, fn ($query) => $query->with(['subCategory', 'subCategory.category', 'media']))
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%")
            )
            ->when($request->category_id, fn ($query, $categoryId) => $query->where('category_id', $categoryId)
            )
            ->orderBy('id', 'asc')
            ->paginate($perPage, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function getMainCategory($request)
    {
        return $this->getBaseQuery(Category::class, $request, self::MAIN);
    }

    public function getSubCategory($request)
    {
        return $this->getBaseQuery(SubCategory::class, $request, self::SUB);
    }

    public function getChildCategory($request)
    {
        return $this->getBaseQuery(SubCategoryChild::class, $request, self::CHILD);
    }

    public function findCategory($id): Category|SubCategory|SubCategoryChild
    {
        $type = request()->get('type') ?? '0';

        return match ($type) {
            self::MAIN => Category::find($id),
            self::SUB => SubCategory::find($id),
            self::CHILD => SubCategoryChild::find($id),
            default => throw new CategoryCreationException('Invalid category type')
        };
    }

    public function storeCategory(array $data): Category|SubCategory|SubCategoryChild
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['added_by'] = auth()->id();

                return match ($data['type']) {
                    self::MAIN => $this->createCategoryBase($data, Category::class),
                    self::SUB => $this->createCategoryBase($data, SubCategory::class),
                    self::CHILD => $this->createCategoryBase($data, SubCategoryChild::class),
                    default => throw new CategoryCreationException('Invalid category type')
                };
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateCategory($data, $id)
    {
        try {
            return DB::transaction(function () use ($data, $id) {
                $category = $this->findCategory($id);
                $this->updateCategoryBase($data, $category);
            });
        } catch (Exception $e) {
            throw $e;
        }

    }

    private function updateCategoryBase(array $data, $category)
    {
        $categoryData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'category_id' => $data['category_id'] ?? null,
            'sub_category_id' => $data['sub_category_id'] ?? null,

        ];
        if (isset($data['image'])) {
            $categoryData['image'] = $data['image'];
        }
        $category = $category->update($categoryData);

        return $category;
    }

    private function createCategoryBase(array $data, $modelClass)
    {
        $categoryData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'category_id' => $data['category_id'] ?? null,
            'sub_category_id' => $data['sub_category_id'] ?? null,

        ];
        $category = $modelClass::create($categoryData);
        if (isset($data['image'])) {
            $category->image = $data['image'];
            $category->save();
        }

        return $category;
    }

    public function deleteCategory($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $category = $this->findCategory($id);

                if ($category->products()->exists()) {
                    throw new Exception('Category has products, cannot delete');
                }
                if ($category->coupons && $category->coupons()->exists()) {
                    throw new Exception('Category has coupons, cannot delete');
                }
                if ($category->subcategories && $category->subcategories()->exists()) {
                    throw new Exception('Category has subcategories, cannot delete');
                }
                if ($category->subchilds && $category->subchilds()->exists()) {
                    throw new Exception('Category has subchilds, cannot delete');
                }
                $category->delete();
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
