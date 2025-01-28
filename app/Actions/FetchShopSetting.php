<?php

namespace App\Actions;

use App\Models\ShopSetting;

class FetchShopSetting
{
    public function execute()
    {
        return ShopSetting::get()->map(function ($setting) {
            return [
                'key' => $setting->key,
                'value' => $setting->value,
            ];
        });

    }
}
