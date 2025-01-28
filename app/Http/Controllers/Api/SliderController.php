<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchSlider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $sliders = (new FetchSlider)->handle();

        return success('Sliders showed successfully', $sliders);
    }
}
