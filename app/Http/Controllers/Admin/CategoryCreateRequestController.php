<?php

namespace App\Http\Controllers\Admin;

use App\Actions\FetchCategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryCreateRequest;
use App\Models\SubCategory;
use App\Models\SubCategoryChild;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryCreateRequestController extends Controller
{
    public function index(Request $request)
    {

        $category_requests = (new FetchCategoryRequest)->execute($request);
        if ($request->ajax()) {
            return view('components.category_requests.table', ['category_requests' => $category_requests])->render();
        }

        return view('backend.pages.category_create_requests.index', compact('category_requests'));
    }

    public function show($id)
    {
        try {
            $category_request = CategoryCreateRequest::findOrFail($id);

            return view('backend.pages.category_create_requests.edit', compact('category_request'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message', 'Category request not found');
        }
    }

    // status update for category request

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:1,2,3',
        ]);

        try {
            $category_request = CategoryCreateRequest::findOrFail($id);
            $category_request->update([
                'status' => $request->type,
            ]);

            // if ($request->type == '2') {
            //     DB::beginTransaction();

            //     // Get or create category
            //     $category = Category::firstOrCreate(
            //         ['name' => $category_request->category_name],
            //         ['slug' => Str::slug($category_request->category_name)]
            //     );

            //     if ($category_request->sub_category_name) {
            //         // Get or create subcategory
            //         $sub_category = SubCategory::firstOrCreate(
            //             [
            //                 'name' => $category_request->sub_category_name,
            //                 'category_id' => $category->id
            //             ],
            //             ['slug' => Str::slug($category_request->sub_category_name)]
            //         );

            //         if ($category_request->sub_sub_category_name) {
            //             // Get or create child category
            //             SubCategoryChild::firstOrCreate(
            //                 ['name' => $category_request->sub_sub_category_name],
            //                 [
            //                     'sub_category_id' => $sub_category->id,
            //                     'slug' => Str::slug($category_request->sub_sub_category_name)
            //                 ]
            //             );
            //         }
            //     }

            //     DB::commit();
            // }

            return \success('Category request status updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'An error occurred: '.$e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category_request = CategoryCreateRequest::findOrFail($id);
            $category_request->delete();

            return response()->json(['message' => 'Category request deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message', 'Category request not found');
        }
    }
}
