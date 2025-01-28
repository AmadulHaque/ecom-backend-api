<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrimeView;
use App\Services\PrimeViewService;
use Illuminate\Http\Request;

class PrimeViewController extends Controller
{
    protected $primeViewService;

    public function __construct(PrimeViewService $primeViewService)
    {
        $this->primeViewService = $primeViewService;
        $this->middleware('permission:prime-view-list')->only('index');
        $this->middleware('permission:prime-view-create')->only(['create', 'store']);
        $this->middleware('permission:prime-view-update')->only(['edit', 'update']);
        $this->middleware('permission:prime-view-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $prime_views = $this->primeViewService->getPrimeViews($request);
        if ($request->ajax()) {
            return view('components.prime-views.table', ['entity' => $prime_views])->render();
        }

        return view('Admin::prime-views.index', compact('prime_views'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:prime_views,name',
            'status' => 'required|in:active,inactive',
        ]);

        $this->primeViewService->storePrimeView($data);

        return response()->json(['success' => 'Prime View Created Successfully']);
    }

    public function edit(PrimeView $primeView)
    {
        return view('components.prime-views.form', ['data' => $primeView])->render();
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|unique:prime_views,name,'.$id,
            'status' => 'required|in:active,inactive',
        ]);

        $this->primeViewService->updatePrimeView($id, $data);

        return response()->json(['success' => 'Prime View updated Successfully']);
    }

    public function destroy(string $id)
    {
        $this->primeViewService->deletePrimeView($id);

        return response()->json(['success' => 'Prime View deleted Successfully']);
    }
}
