<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchShopSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopSettingController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = (new FetchShopSetting)->execute($request);

        return success('Shop Setting fetched successfully', $data);
    }
}
