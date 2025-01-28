<?php

namespace App\Services\Admin;

use App\Enums\MerchantStatus;
use App\Enums\PayoutStatus;
use App\Enums\ShopProductStatus;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Payout;
use App\Models\ShopProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardService
{

    public function getDateRange($startDate, $endDate): array
    {
        return [
            'startDate' => Carbon::parse($startDate),
            'endDate' => Carbon::parse($endDate),
        ];
    }

    /**
     * Get dashboard statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        // return Cache::remember('dashboard_statistics', now()->addMinutes(5), function () {
            return [
                'total_products' => ShopProduct::count(),
                'pending_products' => ShopProduct::where('status', ShopProductStatus::PENDING->value)->count(),
                'active_shops' => Merchant::where('shop_status', MerchantStatus::Active->value)->count(),
                'total_customers' => User::where('role', 3)->count(),
                'total_orders' => Order::count(),
            ];
        // });
    }

    /**
     * Get chart data for customers and orders
     *
     * @param array $dateRange
     * @return array
     */
    public function getChartData(array $dateRange): array
    {
        $customerData = $this->getCustomerData($dateRange);
        $orderData = $this->getOrderData($dateRange);

        $dates = $this->getMergedDates($customerData, $orderData);

        return [
            'dates' => $dates,
            'customers' => $this->formatChartData($customerData, $dates),
            'orders' => $this->formatChartData($orderData, $dates),
        ];
    }

    /**
     * Get customer registration data
     *
     * @param array $dateRange
     * @return Collection
     */
    private function getCustomerData(array $dateRange): Collection
    {
        return User::where('role', 'customer')
            ->whereBetween('created_at', [
                $dateRange['startDate'],
                $dateRange['endDate']
            ])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
    }

    /**
     * Get order data
     *
     * @param array $dateRange
     * @return Collection
     */
    private function getOrderData(array $dateRange): Collection
    {
        return Order::whereBetween('created_at', [
                $dateRange['startDate'],
                $dateRange['endDate']
            ])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
    }

    /**
     * Get merged and sorted dates from both datasets
     *
     * @param Collection $customerData
     * @param Collection $orderData
     * @return array
     */
    private function getMergedDates(Collection $customerData, Collection $orderData): array
    {
        $dates = array_unique(
            array_merge(
                $customerData->keys()->toArray(),
                $orderData->keys()->toArray()
            )
        );
        sort($dates);
        return $dates;
    }

    /**
     * Format data for chart display
     *
     * @param Collection $data
     * @param array $dates
     * @return array
     */
    private function formatChartData(Collection $data, array $dates): array
    {
        return array_map(function ($date) use ($data) {
            return $data[$date] ?? 0;
        }, $dates);
    }
}