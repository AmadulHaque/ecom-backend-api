<?php

namespace App\Services;

use App\Models\Slider;

class SliderService
{
    /**
     * Store a new slider.
     */
    public function store(array $data): Slider
    {
        $slider = Slider::create([
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'link' => $data['link'],
            'slider_type' => $data['slider_type'],
            'status' => $data['status'],
        ]);
        $slider->full_image = $data['full_image'];
        $slider->small_image = $data['small_image'];

        return $slider;
    }

    /**
     * Update an existing slider.
     */
    public function update(Slider $slider, array $data): Slider
    {
        $slider->update($data);

        return $slider;
    }

    /**
     * Delete a slider.
     */
    public function delete(Slider $slider): bool
    {
        return $slider->delete();
    }
}
