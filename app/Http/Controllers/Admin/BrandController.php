<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function merchantBrands(Request $request)
    {
        $search = $request->search ?? '';
        $merchant_ids = $request->merchant_ids ?? [];
        $merchant_type = $request->merchant_type ?? '';

        $query = DB::table('brands');
        if ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        if ($merchant_type == '1' && $merchant_ids) {
            $query->whereNotIn('merchant_id', $merchant_ids);
        }
        if ($merchant_type == '2' && $merchant_ids) {
            $query->whereIn('merchant_id', $merchant_ids);
        }

        return success('Brands fetched successfully', $query->get());
    }
}
