<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Services\locationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(locationService $locationService)
    {
        $this->locationService = $locationService;
        $this->middleware('permission:location-list')->only('index');
        $this->middleware('permission:location-create')->only(['create', 'store']);
        $this->middleware('permission:location-update')->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $locations = $this->locationService->getLocations($request);
        $divisions = $this->locationService->getDivisions();

        if ($request->ajax()) {
            return view('components.location.table', ['entity' => $locations])->render();
        }

        return view('Admin::locations.index', compact('locations', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $locations = $this->locationService->getSearchLocations($request);

        return view('Admin::locations.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request)
    {
        $this->locationService->createLocation($request);

        return response()->json(['success' => 'Location Created Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $location = $this->locationService->getLocationById($id);
        $locations = $this->locationService->getSearchLocations($request);

        return view('Admin::locations.edit', compact('location', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, string $id)
    {
        $location = $this->locationService->getLocationById($id);
        $this->locationService->updateLocation($request, $location);

        return response()->json(['success' => 'Location Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
