<?php

namespace App\Http\Controllers\Admin;

use App\Actions\FetchReason;
use App\Http\Controllers\Controller;
use App\Services\ReasonService;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    protected $reasonService;

    public function __construct(ReasonService $reasonService)
    {
        $this->reasonService = $reasonService;
        $this->middleware('permission:reason-list')->only('index');
        $this->middleware('permission:reason-create')->only(['create', 'store']);
        $this->middleware('permission:reason-update')->only(['edit', 'update']);
        $this->middleware('permission:reason-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $reasons = (new FetchReason)->execute($request);
        if ($request->ajax()) {
            return view('components.reason.table', ['entity' => $reasons])->render();
        }

        return view('Admin::reasons.index', compact('reasons'));
    }

    public function create()
    {
        return view('Admin::reasons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:cancel,return,exchange,refund',
            'name' => 'required|unique:reasons,name',
            'status' => 'required',
        ]);
        $this->reasonService->createReason($data);

        return response()->json(['message' => 'Reason created successfully!']);
    }

    public function edit(string $id)
    {
        $reason = $this->reasonService->getReason($id);

        return view('Admin::reasons.edit', compact('reason'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'type' => 'required|in:cancel,return,exchange,refund',
            'name' => 'required|unique:reasons,name,'.$id,
            'status' => 'required',
        ]);
        $this->reasonService->updateReason($id, $data);

        return response()->json(['message' => 'Reason updated successfully!']);
    }

    public function destroy(string $id)
    {
        $this->reasonService->deleteReason($id);

        return response()->json(['message' => 'Reason deleted successfully!']);
    }
}
