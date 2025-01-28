<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        $slider = $this->route('slider');

        $rules = [
            'title' => [
                'nullable',
                'max:255',
                Rule::unique('sliders', 'title')->ignore($slider ? $slider->id : null),
            ],
            'sub_title' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'full_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'small_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'slider_type' => 'required|in:1,2',
        ];

        if ($slider) {
            $rules['full_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
            $rules['small_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }

        return $rules;
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.unique' => 'The title has already been taken.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
            'link.url' => 'The link must be a valid URL.',
            'full_image.required' => 'The desktop image field is required.',
            'small_image.required' => 'The mobile image field is required.',
        ];
    }
}
