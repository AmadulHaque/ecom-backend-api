<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function location(Request $request): JsonResponse
    {
        $parent_id = $request->input('parent_id', null);

        $locations = Location::query()
            ->where('parent_id', $parent_id)
            ->select('id', 'name', 'type', 'parent_id')
            ->get();

        return success('Locations showed successfully', $locations);
    }
}
