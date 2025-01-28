<?php

namespace App\Actions;

use App\Models\Slider;

class FetchSlider
{
    public function execute($request)
    {
        $status = $request->status ?? '';
        $search = $request->search ?? '';
        $sliders = Slider::with('media')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })->get();

        return $sliders;
    }

    public function handle()
    {
        $sliders = Slider::with('media')->where('status', 'active')->get()->groupBy('slider_type')->map(function ($slider) {
            return [
                'slider_type' => $slider[0]->label ?? '',
                'sliders' => $slider->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'sub_title' => $item->sub_title,
                        'link' => $item->link,
                        'status' => $item->status,
                        'full_image' => $item->full_image,
                        'small_image' => $item->small_image,
                    ];
                }),
            ];
        });

        return $sliders;
    }
}
