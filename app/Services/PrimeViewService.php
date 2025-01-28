<?php

namespace App\Services;

use App\Models\PrimeView;

class PrimeViewService
{
    // --------------- Prime View Wev Services ---------------#
    public function getPrimeViews($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');

        $prime_views = PrimeView::query()
            ->with('products')
            ->paginate($perPage, ['*'], 'page', $page);

        return $prime_views;
    }

    public function getPrimeViewAll()
    {
        return PrimeView::select('id', 'name')->get();
    }

    public function storePrimeView($data)
    {
        $prime_view = PrimeView::create($data);

        return $prime_view;
        // $prime_view->products()->sync($request->products);
    }

    public function updatePrimeView($id, $data)
    {
        $prime_view = PrimeView::find($id)->update($data);

        return $prime_view;
    }

    public function deletePrimeView($id)
    {
        $prime_view = PrimeView::find($id)->delete();

        return $prime_view;
    }
}
