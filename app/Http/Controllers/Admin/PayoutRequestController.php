<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PayoutRequestService;
use Illuminate\Http\Request;

class PayoutRequestController extends Controller
{
    protected $payoutRequestService;

    public function __construct(PayoutRequestService $payoutRequestService)
    {
        $this->payoutRequestService = $payoutRequestService;
    }

    public function index(Request $request)
    {
        $data = $this->payoutRequestService->getPayoutRequests($request);

        return customView(['ajax' => 'components.payout_request.table', 'default' => 'Admin::payout_requests.index'], ['entity' => $data]);
    }

    public function show($id)
    {
        $data = $this->payoutRequestService->getPayoutRequestById($id);

        return view('Admin::payout_requests.show', compact('data'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $this->payoutRequestService->updateStatus($request, $id);

        return redirect()->route('admin.payout-requests.index')->with('success', 'Payout request status updated successfully');
    }
}
