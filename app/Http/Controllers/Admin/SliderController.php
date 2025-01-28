<?php

namespace App\Http\Controllers\Admin;

use App\Actions\FetchSlider;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
        $this->middleware('permission:slider-list')->only('index');
        $this->middleware('permission:slider-create')->only(['create', 'store']);
        $this->middleware('permission:slider-update')->only(['edit', 'update']);
        $this->middleware('permission:slider-delete')->only('destroy');
    }

    /**
     * Display a listing of the sliders.
     */
    public function index(Request $request)
    {
        $sliders = (new FetchSlider)->execute($request);
        if ($request->ajax()) {
            return view('components.slider.table', ['entity' => $sliders])->render();
        }

        return view('Admin::sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('Admin::sliders.create');
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(SliderRequest $request)
    {
        $slider = $this->sliderService->store($request->validated());

        return response()->json(['success' => 'Slider created successfully!']);
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('Admin::sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $this->sliderService->update($slider, $request->validated());

        return response()->json(['success' => 'Slider updated successfully!']);
    }

    /**
     * Remove the specified slider from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->sliderService->delete($slider);

        return response()->json(['success' => 'Slider deleted successfully!']);
    }
}
