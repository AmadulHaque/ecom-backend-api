<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchShopBasicDetails;
use App\Actions\FetchShopProducts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function basicDetails($id)
    {
        return (new FetchShopBasicDetails)->execute($id);
    }

    public function shopProducts(Request $request, $id)
    {
        return (new FetchShopProducts)->execute($request, $id);
    }
}
