<?php

namespace App\Actions;

use App\Models\CategoryCreateRequest;

class FetchCategoryRequest
{
    public function execute($request)
    {
        $perPage = $request->perPage ?? 10;
        $status = $request->status ?? null;
        $page = $request->page ?? 1;

        return CategoryCreateRequest::with('merchant', 'merchant.user')
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->select('id', 'category_name', 'status', 'merchant_id', 'created_at')
            ->paginate($perPage, ['*'], 'page', $page)
            ->withQueryString();
    }
}
