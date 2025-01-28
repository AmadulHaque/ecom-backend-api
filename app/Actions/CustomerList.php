<?php

namespace App\Actions;

use App\Models\User;

class CustomerList
{
    public function execute($request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $customer = User::query()// customer()
            ->with([
                'addresses.location.parent.parent',
            ])
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['phone', 'email', 'name'], 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return $customer;
    }
}
