<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopSetting;
use Illuminate\Http\Request;

class ShopSettingController extends Controller
{
    public function index(Request $request)
    {
        $groupName = $request->input('group');
        $settingsGroups = ShopSetting::orderBy('order')->get()->groupBy('group_name');
        if ($request->ajax()) {
            $settings = ShopSetting::where('group_name', $groupName)->get();

            return view('components.setting.form', compact('settings'))->render();
        }

        return view('Admin::setting.index', compact('settingsGroups'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token'); // Exclude the CSRF token

        foreach ($data as $key => $value) {
            $setting = ShopSetting::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'file' && $request->hasFile($key)) {
                    // Handle file upload
                    // add validation for file type only jpeg,png
                    $request->validate([
                        $key => 'file|mimes:jpeg,png|max:2048',
                    ]);

                    $file = $request->file($key);
                    $filename = time().'_'.$file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads/settings', $filename, 'public');
                    $value = $filePath;
                }
                if ($setting->type === 'select' && $setting->options === 'custom_location') {
                    $value = implode(',', $value);
                }
                $setting->value = $value;
                $setting->save();
            }
        }

        return response()->json(['message' => 'Settings updated successfully!']);
    }
}
