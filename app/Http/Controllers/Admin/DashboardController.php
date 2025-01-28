<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfDay();
        $endDate = $request->end_date ?? now()->endOfDay();

        $dateRange = $this->dashboardService->getDateRange($startDate, $endDate);

        $statistics = $this->dashboardService->getStatistics();
        $chartData = $this->dashboardService->getChartData($dateRange);

        return view('Admin::dashboard', [
            'startDate' => $dateRange['startDate'],
            'endDate' => $dateRange['endDate'],
            'statistics' => $statistics,
            'chartData' => $chartData,
        ]);
    }
}
